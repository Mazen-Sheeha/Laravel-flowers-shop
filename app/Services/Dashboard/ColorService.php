<?php

namespace App\Services\Dashboard;

use App\Http\Requests\Dashboard\Color\CreateColorRequest;
use App\Http\Requests\Dashboard\Color\UpdateColorRequest;
use App\Models\Color;

class ColorService
{

    public function index()
    {
        $colors = Color::orderBy('id', 'DESC')->select('id', 'color')->paginate(15);
        return view('dashboard.colors.index', compact("colors"));
    }

    public function store(CreateColorRequest $request)
    {
        $validated = $request->validated();
        Color::create($validated);
        return to_route("colors.index")->with("success", "Color created successfully");
    }

    public function edit(string $id)
    {
        $color = Color::findOrFail($id);
        return view("dashboard.colors.edit", compact('color'));
    }

    public function update(UpdateColorRequest $request, string $id)
    {
        $validated = $request->validated();
        $color = Color::findOrFail($id);
        $color->update($validated);
        return to_route("colors.index")->with("success", "Color updated successfully");
    }

    public function destroy(string $id)
    {
        $color = Color::findOrFail($id);
        if ($color->products()->count() > 0) return back()->withErrors(["message" => "There are products has this color"]);
        $color->delete();
        return to_route("colors.index")->with("success", "Color deleted successfully");
    }
}
