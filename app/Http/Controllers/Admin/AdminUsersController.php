<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class AdminUsersController extends Controller
{
    public function __construct() {
        $this->middleware('can:show-user')->only('index');
        $this->middleware('can:create-user')->only(['create', 'store']);
        $this->middleware('can:edit-user')->only(['edit', 'update']);
        $this->middleware('can:delete-user')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query();

        // search method
        if (request('search')) {
            $keyword = request('search');
            $users->where('email', 'like', "%$keyword%")
                  ->orWhere('name', 'like', "%$keyword%")
                  ->orWhere('id', $keyword);
        }

        if (request('admin')) {
            $this->authorize('show-staff-users');
            $users->where('is_staff', 1)->orWhere('is_admin', 1);
        }

        if (Gate::allows('show-staff-users')) {
            if (request('admin')) {
                $users->where('is_staff', 1)->orWhere('is_admin', 1);
            }
        } else {
            $users->where('is_admin', 0)->orWhere('is_staff', 0);
        }

        $users = $users->latest()->paginate(10);
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
        if ($request->has('verify_email')) {
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
        $user->deleteOrFail();

        alert()->success('عملیات موفق', 'کاربر با موفقیت حذف شد');

        return back();
    }
}
