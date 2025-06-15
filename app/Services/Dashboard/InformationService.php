<?php

namespace App\Services\Dashboard;

use App\Http\Requests\dashboard\Information\UpdateInformationRequest;
use App\Models\Information;
use App\Models\ZipCode;

class InformationService
{
    public function edit()
    {
        $information = Information::select('phone', 'email')->first();
        $zip_codes = ZipCode::orderBy('id', "DESC")->paginate(15);
        return view('dashboard.information.index', compact('information', 'zip_codes'));
    }

    public function update(UpdateInformationRequest $request)
    {
        $validated = $request->validated();
        Information::first()->update($validated);
        return back()->with("success", "Information updated successfully");
    }
}
