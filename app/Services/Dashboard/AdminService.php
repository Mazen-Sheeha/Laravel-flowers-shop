<?php

namespace App\Services\Dashboard;

use App\Http\Requests\Dashboard\Admin\CreateAdminRequest;
use App\Http\Requests\Dashboard\Admin\UpdateAdminRequest;
use App\Models\Admin;

class AdminService
{

    public function index()
    {
        $admins = Admin::orderBy('id', 'DESC')->select('id', 'name', 'email')->paginate(15);
        return view('dashboard.admins.index', compact('admins'));
    }

    public function show(string $id)
    {
        $admin = Admin::findOrFail($id);
        return view("dashboard.admins.show", compact('admin'));
    }

    public function create()
    {
        return view("dashboard.admins.create");
    }

    public function store(CreateAdminRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);
        Admin::create($validated);
        return to_route("admins.index")->with("success", "Admin added successfully");
    }

    public function edit(string $id)
    {
        $admin = Admin::findOrFail($id);
        return view('dashboard.admins.edit', compact('admin'));
    }

    public function update(UpdateAdminRequest $request, string $id)
    {
        $validated = $request->validated();
        $admin = Admin::findOrFail($id);
        $old = $admin;
        $validated['password'] = $request->has('password') && $request->password != "" ? bcrypt($request->password) : $admin->password;
        Admin::where('id', $id)->update($validated);
        if ($validated['name'] != $old->name || $validated['email'] != $old->email || ($request->has('password') && $request->password != '')) {
            return to_route("admins.index")->with("success", "Admin updated successfully");
        }
        return back();
    }

    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);
        $adminsCount = Admin::count();
        if ($adminsCount === 1) {
            return back()->withErrors(['message' => "There must be at least one admin"]);
        }
        $admin->delete();
        return back()->with("success", "Admin deleted successfully");
    }
}
