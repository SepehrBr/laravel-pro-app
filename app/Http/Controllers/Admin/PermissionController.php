<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    public function __construct() {
        $this->middleware('can:show-permission')->only('index');
        $this->middleware('can:create-permission')->only(['create', 'store']);
        $this->middleware('can:edit-permission')->only(['edit', 'update']);
        $this->middleware('can:delete-permission')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::query();

        if ($keyword = request('search')) {
            $permissions
                ->where('name', 'like', "%$keyword%")
                ->orWhere('label', 'like', "%$keyword%")
                ->orWhere('id', $keyword);
        }

        $permissions = $permissions->latest()->paginate(10);

        return view('admin.permissions.all', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate
        $validated_data = $request->validate([
            'name' => ['required', 'min:2', 'string', Rule::unique('permissions')],
            'label' => ['required', 'min:5', 'string', 'max:500']
        ]);

        // add to database
        Permission::create($validated_data);

        // sync btw relations


        alert()->success('موفق', 'دسترسی جدید ایجاد شد');

        return redirect(route('admin.permissions.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        // validate
        $validated_data = $request->validate([
            'name' => ['required', 'min:2', 'string', Rule::unique('permissions')->ignore($permission->id)],
            'label' => ['required', 'min:5', 'string', 'max:500']
        ]);

        Permission::update($validated_data);

        return redirect(route('admin.permissions.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return view('admin.permissions.all');
    }
}
