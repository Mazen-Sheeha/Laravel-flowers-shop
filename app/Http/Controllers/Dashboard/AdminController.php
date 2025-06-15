<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\CreateAdminRequest;
use App\Http\Requests\Dashboard\Admin\UpdateAdminRequest;
use App\Models\Admin;
use App\Services\Dashboard\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        return $this->adminService = $adminService;
    }

    public function index()
    {
        return $this->adminService->index();
    }

    public function create()
    {
        return $this->adminService->create();
    }

    public function store(CreateAdminRequest $request)
    {
        return $this->adminService->store($request);
    }

    public function show(string $id)
    {
        return $this->adminService->show($id);
    }

    public function edit(string $id)
    {
        return $this->adminService->edit($id);
    }

    public function update(UpdateAdminRequest $request, string $id)
    {
        return $this->adminService->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->adminService->destroy($id);
    }
}
