<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::query();

        if ($keyword = request('search')) {
            $roles
                ->where('name', 'like', "%$keyword%")
                ->orWhere('label', 'like', "%$keyword%")
                ->orWhere('id', $keyword);
        }

        $roles = $roles->latest()->paginate(10);

        return view('admin.roles.all', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate
        $validated_data = $request->validate([
            'name' => ['required', 'min:2', 'string', Rule::unique('roles')],
            'label' => ['required', 'min:5', 'string', 'max:500'],
            'permissions' => ['required', 'array']
        ]);

        // add to database
        $role = Role::create($validated_data);

        // sync btw relations
        $role->permissions()->sync($validated_data['permissions']);

        alert()->success('موفق', 'مقام جدید ایجاد شد');

        return redirect(route('admin.roles.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // validate
        $validated_data = $request->validate([
            'name' => ['required', 'min:2', 'string', Rule::unique('roles')->ignore($role->id)],
            'label' => ['required', 'min:5', 'string', 'max:500'],
            'permissions' => ['required', 'array']
        ]);

        // update
        $role = Role::update($validated_data);

        // sync tables
        // $role->permissions()->sync();

        return redirect(route('admin.permissions.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return back();
    }
}
