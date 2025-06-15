<?php

namespace App\Services\Dashboard;

use App\Http\Requests\Dashboard\ZipCode\ZipCodeRequest;
use App\Models\ZipCode;

class ZipCodeService
{
    public function store(ZipCodeRequest $request)
    {
        $validated = $request->validated();
        ZipCode::create($validated);
        return back()->with("success", "ZIP code added successfully");
    }

    public function edit(string $id)
    {
        $zip_code = ZipCode::findOrFail($id);
        return view('dashboard.information.edit', compact('zip_code'));
    }

    public function update(string $id, ZipCodeRequest $request)
    {
        $validated = $request->validated();
        ZipCode::where("id", $id)->update($validated);
        return to_route('information.edit')->with("success", "ZIP code updated successfully");
    }

    public function destroy(string $id)
    {
        $zip_code = ZipCode::findOrFail($id);
        $zip_code->delete();
        return back()->with("success", "ZIP code deleted successfully");
    }
}
