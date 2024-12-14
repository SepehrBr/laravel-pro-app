<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(20);
        return view('admin.users.all', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate data first
        $validated_data = $request->validate([
            'name' => ['required', 'string', 'min:1', 'max:100'],
            'email' => ['required', 'string', 'min:1', 'max:255', Rule::unique('users', 'email'), 'email'],
            'password' => ['required', 'string', 'min:5', 'confirmed']
        ]);

        try {
            // create user
            $user = User::create($validated_data);

            // verify email
            if ($request->has('verify_email')) {
                $user->markEmailAsVerified();
            }

            alert()->success('کاربر با موفقیت ایجاد شد');

            return redirect(route('admin.users.index'));
        } catch (\Exception $e) {
            alert()->error('در فرایند ایجاد کاربر خطایی رخ داده است.');
            throw new \Exception($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // validate data first
        $validated_data = $request->validate([
            'name' => ['required', 'string', 'min:1', 'max:100'],
            'email' => ['required', 'string', 'min:1', 'max:255', Rule::unique('users', 'email')->ignore($user->id), 'email'],
        ]);

        // update password if new password was added
        if (! is_null($request->password)) {
            $request->validate([
                'password' => ['required', 'string', 'min:5', 'confirmed']
            ]);

            $validated_data['password'] = $request->password;
        }

        // verify email
        if ($request->has('verify')) {
            $user->markEmailAsVerified();
        }

        try {
            $user->update($validated_data);

            alert()->success('کاربر با موفقیت ویرایش شد');

            return redirect(route('admin.users.index'));
        } catch (\Exception $e) {
            alert()->error('در فرایند ویرایش کاربر خطایی رخ داده است.');
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
