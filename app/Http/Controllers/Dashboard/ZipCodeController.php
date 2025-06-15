<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ZipCode\ZipCodeRequest;
use App\Services\Dashboard\ZipCodeService;

class ZipCodeController extends Controller
{
    protected $zipCodeService;

    public function __construct(ZipCodeService $zipCodeService)
    {
        return $this->zipCodeService = $zipCodeService;
    }

    public function store(ZipCodeRequest $request)
    {
        return $this->zipCodeService->store($request);
    }

    public function edit(string $id)
    {
        return $this->zipCodeService->edit($id);
    }

    public function update(string $id, ZipCodeRequest $request)
    {
        return $this->zipCodeService->update($id, $request);
    }

    public function destroy(string $id)
    {
        return $this->zipCodeService->destroy($id);
    }
}
