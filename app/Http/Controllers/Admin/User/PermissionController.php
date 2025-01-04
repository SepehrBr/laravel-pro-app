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
        // sync btw relations
        $user->permissions()->sync($request->permissions);
        $user->roles()->sync($request->roles);

        return redirect(route('admin.users.index'));
    }
}
