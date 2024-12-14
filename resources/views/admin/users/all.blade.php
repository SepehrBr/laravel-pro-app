@extends('admin.layouts.app')


@section('content')
{{-- header --}}
<x-admin.header>
    {{-- title --}}
    پنل کاربران

    {{-- breadcrumb --}}
    <x-slot:breadcrump>
        <x-admin.breadcrump href="{{ url('/admin')}}" >پنل مدیریت</x-admin.breadcrump>
        <x-admin.breadcrump :active="true">لیست کاربران</x-admin.breadcrump>
    </x-slot>
</x-header>

{{-- content --}}
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">لیست کاربران</h3>

              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control float-right" placeholder="جستجو">

                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody><tr>
                    <th>ID کاربر</th>
                    <th>نام کاربر</th>
                    <th>ایمیل کاربر</th>
                    <th>وضعیت ایمیل</th>
                    <th>تاریخ عضویت</th>
                    <th>اقدامات</th>
                </tr>

                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ is_null($user->email_verified_at) ? 'badge-danger' : 'badge-success' }} badge-success">{{ is_null($user->email_verified_at) ? 'تایید نشده' : 'تایید شده'  }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::create($user->created_at)->toDayDateTimeString() }}</td>
                        <td>
                            <button class="btn btn-sm btn-danger">حذف</button>
                            <button class="btn btn-sm btn-warning">ویرایش</button>
                        </td>
                    </tr>
                @endforeach
              </tbody></table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
@endsection