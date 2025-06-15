<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\Information\UpdateInformationRequest;
use App\Services\Dashboard\InformationService;

class InformationController extends Controller
{
    protected $informationService;

    public function __construct(InformationService $informationService)
    {
        return $this->informationService = $informationService;
    }

    public function edit()
    {
        return $this->informationService->edit();
    }

    public function update(UpdateInformationRequest $request)
    {
        return $this->informationService->update($request);
    }
}
