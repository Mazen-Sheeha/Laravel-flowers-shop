<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Color\CreateColorRequest;
use App\Http\Requests\Dashboard\Color\UpdateColorRequest;
use App\Models\Color;
use App\Services\Dashboard\ColorService;
use Illuminate\Http\Request;

class ColorController extends Controller
{

    protected $colorService;

    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }

    public function index()
    {
        return $this->colorService->index();
    }


    public function store(CreateColorRequest $request)
    {
        return $this->colorService->store($request);
    }

    public function show(Color $color)
    {
        //
    }

    public function edit(string $id)
    {
        return $this->colorService->edit($id);
    }

    public function update(UpdateColorRequest $request, string $id)
    {
        return $this->colorService->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->colorService->destroy($id);
    }
}
