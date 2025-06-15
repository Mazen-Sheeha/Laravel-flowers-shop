<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\FrontService;

class FrontController extends Controller
{
    protected $frontService;

    public function __construct(FrontService $frontService)
    {
        return $this->frontService = $frontService;
    }

    public function home()
    {
        return $this->frontService->home();
    }

    public function contact()
    {
        return $this->frontService->contact();
    }

    public function about()
    {
        return $this->frontService->about();
    }
}
