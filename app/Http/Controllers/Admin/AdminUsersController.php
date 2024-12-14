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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
