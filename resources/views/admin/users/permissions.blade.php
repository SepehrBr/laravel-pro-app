@extends('admin.layouts.app')


@section('content')
{{-- header --}}
<x-admin.header>
    {{-- title --}}
    پنل ثبت دسترسی و مقام برای کاربر {{ $user->name }}

    {{-- breadcrumb --}}
    <x-slot:breadcrump>
        <x-admin.breadcrump href="{{ url('/admin')}}" >پنل مدیریت</x-admin.breadcrump>
        <x-admin.breadcrump href="{{ route('admin.users.index')}}">لیست کاربران</x-admin.breadcrump>
        <x-admin.breadcrump :active="true">ثبت دسترسی و مقام برای کاربر</x-admin.breadcrump>
    </x-slot>
</x-header>

{{-- content --}}
    <div class="row">
        <div class="col-12">
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">فرم ثبت دسترسی و مقام </h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.users.permissions.store', $user->id)}}" method="post" class="form-horizontal" >
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="permissions" class=" control-label">دسترسی ها</label>
                        <div class="col-10">
                          <select class="form-control" name="permissions[]" id="permissions" multiple >
                            @foreach (App\Models\Permission::all() as $permission)
                                <option value="{{ $permission->id }}" {{ in_array($permission->id, $user->permissions->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $permission->name }} - {{ $permission->label }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      @error('permissions')
                        <div class="error-message text-danger fw-bold">
                            <strong>
                                {{ $message }}
                            </strong>
                        </div>
                      @enderror
                    </div>
                    <div class="form-group">
                        <label for="roles" class="col-2 control-label">مقام ها</label>
                        <div class="col-10">
                            <select class="form-control" name="roles[]" id="roles" multiple >
                            @foreach (App\Models\Role::all() as $role)
                                <option value="{{ $role->id }}" {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $role->name }} - {{ $role->label }}</option>
                            @endforeach
                            </select>
                        </div>
                        </div>
                        @error('roles')
                        <div class="error-message text-danger fw-bold">
                            <strong>
                                {{ $message }}
                            </strong>
                        </div>
                        @enderror
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-info">ایجاد</button>
                      <a href="{{ route('admin.roles.index') }}" type="submit" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                  </form>
                </div>
                <!-- /.card -->
              </div>
          <!-- /.card -->
        </div>
      </div>
@endsection

@section('script')
    <script>
        $('#roles').select2({})
        $('#permissions').select2({})
    </script>
@endsection
