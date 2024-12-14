@extends('admin.layouts.app')


@section('content')
{{-- header --}}
<x-admin.header>
    {{-- title --}}
    پنل ایجاد کاربر جدید

    {{-- breadcrumb --}}
    <x-slot:breadcrump>
        <x-admin.breadcrump href="{{ url('/admin')}}" >پنل مدیریت</x-admin.breadcrump>
        <x-admin.breadcrump href="{{ route('admin.users.index')}}">لیست کاربران</x-admin.breadcrump>
        <x-admin.breadcrump :active="true">ایجاد کاربر جدید</x-admin.breadcrump>
    </x-slot>
</x-header>

{{-- content --}}
    <div class="row">
        <div class="col-12">
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">فرم ایجاد کاربر </h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.users.store')}}" method="post" class="form-horizontal" >
                    @csrf
                    <div class="card-body">

                      <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">نام کاربر</label>
                        <div class="col-sm-10">
                          <input value="{{old('name')}}" type="text" name="name" class="form-control" id="name" placeholder="نام کاربر را وارد کنید">
                        </div>
                      </div>
                      @error('name')
                        <div class="error-message text-danger fw-bold">
                            <strong>
                                {{ $message }}
                            </strong>
                        </div>
                      @enderror

                      <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">ایمیل</label>
                        <div class="col-sm-10">
                          <input value="{{old('email')}}" type="email" name="email" class="form-control" id="email" placeholder="ایمیل را وارد کنید">
                        </div>
                      </div>
                      @error('email')
                        <div class="error-message text-danger fw-bold">
                            <strong>
                                {{ $message }}
                            </strong>
                        </div>
                      @enderror

                      <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">پسورد</label>
                        <div class="col-sm-10">
                          <input type="password" name="password" class="form-control" id="password" placeholder="پسورد را وارد کنید">
                        </div>
                      </div>
                      @error('password')
                        <div class="error-message text-danger fw-bold">
                            <strong>
                                {{ $message }}
                            </strong>
                        </div>
                      @enderror
                      <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">تکرار پسورد</label>
                        <div class="col-sm-10">
                          <input type="password" name="password_confirmation" class="form-control" id="password" placeholder="پسورد را وارد کنید">
                        </div>
                      </div>
                      @error('password_confirm')
                        <div class="error-message text-danger fw-bold">
                            <strong>
                                {{ $message }}
                            </strong>
                        </div>
                      @enderror

                      <div class="form-check">
                        <label for="verify_email" class="control-label">
                            ایمیل اکانت فعلی تایید شود
                            <input type="checkbox" name="verify_email" class="form-control" id="verify_email" />
                        </label>
                      </div>
                      @error('password_confirm')
                        <div class="error-message text-danger fw-bold">
                            <strong>
                                {{ $message }}
                            </strong>
                        </div>
                      @enderror

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-info">ورود</button>
                      <a href="{{ route('admin.users.index') }}" type="submit" class="btn btn-default float-left">لغو</a>
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
