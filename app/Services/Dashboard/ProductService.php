<?php

namespace App\Services\Dashboard;

use App\Http\Requests\dashboard\Product\CreateProductRequest;
use App\Http\Requests\dashboard\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Http\Request;

class ProductService
{
    public function index(Request $request)
    {
        $query = Product::query();
        $category = 'all';
        if ($request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . "%");
        }
        if ($request->category_id) {
            $query->where('category_id',   $request->category_id);
            $category = Category::findOrFail($request->category_id)->name;
        }
        $query->with('colors.images')->with('orders')->orderBy('id', "DESC");
        $products = $query->paginate(15);
        return view("dashboard.products.index", compact('products', 'category'));
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        if (count($categories) < 1) return to_route("categories.index")->withErrors("Please add categories to be able to add products");
        $colors = Color::select('id', 'color')->get();
        if (count($colors) < 1) return to_route("colors.index")->withErrors("Please add colors to be able to add products");
        return view("dashboard.products.create", compact('categories', 'colors'));
    }


    public function store(CreateProductRequest $request)
    {
        $validated = $request->validated();
        $imagesByColor = $request->file('image-');
        if (isset($validated['colors'])) {
            foreach ($validated['colors'] as $colorId) {
                if (!isset($imagesByColor[$colorId])) {
                    return back()->withErrors(['message' => "Each selected color must have at least one picture."])->withInput();
                }
            }
        } else {
            return back()->withErrors(['message' => "Please select one color at least for the product."])->withInput();
        }
        DB::beginTransaction();
        try {
            $product = Product::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'offer' => $validated['offer'] ?? null,
                'desc' => $validated['desc'],
                'category_id' => $validated['category_id'],
            ]);
            $product->colors()->sync($validated['colors']);
            foreach ($imagesByColor as $colorId => $files) {
                foreach ($files as $file) {
                    $path = $file->store('public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'color_id' => $colorId,
                        'image' => $path,
                    ]);
                }
            }
            DB::commit();
            return back()->with("success", "Product created successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'An error occurred while creating the product. Please try again.'])->withInput();
        }
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view("dashboard.products.show", compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::select('id', 'name')->get();
        if (count($categories) < 1) return to_route("categories.index")->withErrors("Please add categories to be able to add products");
        $colors = Color::select('id', 'color')->get();
        if (count($colors) < 1) return to_route("colors.index")->withErrors("Please add colors to be able to add products");
        return view("dashboard.products.edit", compact('product', 'categories', 'colors'));
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $validated = $request->validated();
        $product = Product::findOrFail($id);
        $imagesByColor = $request->file('image-') ?? [];

        if (isset($validated['colors'])) {
            foreach ($validated['colors'] as $colorId) {
                $isNewColor = !$product->colors->contains($colorId);
                $hasNewImages = isset($imagesByColor[$colorId]);
                if ($isNewColor && !$hasNewImages) {
                    return back()->withErrors(['message' => "Each newly added color must have at least one picture."])->withInput();
                }
            }
        }

        DB::beginTransaction();
        try {
            $product->update([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'offer' => $validated['offer'] ?? null,
                'desc' => $validated['desc'],
                'category_id' => $validated['category_id'],
            ]);

            if (isset($validated['colors'])) {
                $currentColors = $product->colors->pluck('id')->toArray();
                $product->colors()->sync($validated['colors']);

                foreach ($validated['colors'] as $colorId) {
                    if (isset($imagesByColor[$colorId])) {
                        ProductImage::where('product_id', $product->id)
                            ->where('color_id', $colorId)
                            ->get()
                            ->each(function ($image) {
                                if (File::exists($image->image)) {
                                    File::delete($image->image);
                                }
                                $image->delete();
                            });

                        foreach ($imagesByColor[$colorId] as $file) {
                            $path = $file->store('public');
                            ProductImage::create([
                                'product_id' => $product->id,
                                'color_id' => $colorId,
                                'image' => $path,
                            ]);
                        }
                    } elseif (!in_array($colorId, $currentColors)) {
                        DB::rollBack();
                        return back()->withErrors(['message' => 'Missing images for new color.'])->withInput();
                    }
                }
            } else {
                $product->colors()->sync($product->colors->pluck('id'));
            }

            DB::commit();
            return to_route('adminProducts.index')->with("success", "Product updated successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Product update error: ' . $e->getMessage());
            return to_route('adminProducts.index')->withErrors(['message' => 'An error occurred while updating the product. Please try again.']);
        }
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if ($product->orders->count()) return back()->withErrors(['message' => "This Product in users orders"]);
        DB::beginTransaction();
        try {
            foreach ($product->colors as $color) {
                $colorImages = ProductImage::where('product_id', $product->id)
                    ->where('color_id', $color->id)
                    ->get();
                foreach ($colorImages as $image) {
                    if (File::exists($image->image)) {
                        File::delete($image->image);
                    }
                    $image->delete();
                }
            }
            $product->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'An error occurred while deleting the product. Please try again.'])->withInput();
        }

        return back()->with("success", "Product deleted successfully");
    }
}
