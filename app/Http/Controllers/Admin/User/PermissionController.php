<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    public function create(User $user)
    {
        return view('admin.users.permissions', [
            'user' => $user
        ]);
    }
    public function store(Request $request, User $user)
    {
        // validate
        $validated_data = $request->validate([
            'permissions' => ['required', 'array'],
            'roles' => ['required', 'array']
        ]);

        // sync btw relations
        $user->permissions()->sync($validated_data['permissions']);
        $user->roles()->sync($validated_data['roles']);

        return redirect(route('admin.users.index'));
    }
}
