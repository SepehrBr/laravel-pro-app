@extends('admin.layouts.app')
@section('content')
{{-- header --}}
<x-admin.header>
    {{-- title --}}
    پنل دسترسی کاربران

    {{-- breadcrumb --}}
    <x-slot:breadcrump>
        <x-admin.breadcrump href="{{ url('/admin')}}" >پنل مدیریت</x-admin.breadcrump>
        <x-admin.breadcrump :active="true">لیست دسترسی ها</x-admin.breadcrump>
    </x-slot>
</x-header>

{{-- content --}}
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">لیست دسترسی ها</h3>

              <div class="card-tools d-flex">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <form action="" class="d-flex">
                    @csrf
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control float-right" placeholder="جستجو"   >

                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                  </form>
                </div>
                <div class="btn-group-sm mr-2">
                    @can('create-permission')
                        <a href="{{ route('admin.permissions.create') }}" class="btn btn-info">ایجاد دسترسی جدید</a>
                    @endcan
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody><tr>
                    <th>ID دسترسی</th>
                    <th>نام دسترسی</th>
                    <th>توضیحات</th>
                    <th>تاریخ ایجاد</th>
                    <th>اقدامات</th>
                </tr>

                @foreach ($permissions as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>{{ strlen($permission->label) > 10 ? substr($permission->label, 0, 30) . " ..." : $permission->label }}</td>
                        <td>{{ \Carbon\Carbon::create($permission->created_at)->toDayDateTimeString() }}</td>
                        <td class="d-flex">
                            @can('delete-permission')
                                <form action="{{ route('admin.permissions.destroy', [ 'permission' => $permission->id ])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" href="" class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            @endcan
                            @can('edit-permission')
                                <a href="{{ route('admin.permissions.edit', [ 'permission' => $permission->id ])}}" class="btn btn-sm btn-warning mr-2">ویرایش</a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
        </div>
            <!-- /.card-body -->
        </div>
        <div class="card-footer">
            {{ $permissions->render() }}
        </div>
          <!-- /.card -->
        </div>
      </div>
@endsection
