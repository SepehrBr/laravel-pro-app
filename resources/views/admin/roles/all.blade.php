@extends('admin.layouts.app')
@section('content')
{{-- header --}}
<x-admin.header>
    {{-- title --}}
    پنل مقام های کاربران

    {{-- breadcrumb --}}
    <x-slot:breadcrump>
        <x-admin.breadcrump href="{{ url('/admin')}}" >پنل مدیریت</x-admin.breadcrump>
        <x-admin.breadcrump :active="true">لیست مقام ها</x-admin.breadcrump>
    </x-slot>
</x-header>

{{-- content --}}
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">لیست مقام ها</h3>

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
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-info">ایجاد مقام جدید</a>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody><tr>
                    <th>ID مقام</th>
                    <th>نام مقام</th>
                    <th>توضیحات</th>
                    <th>تاریخ ایجاد</th>
                    <th>اقدامات</th>
                </tr>

                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ strlen($role->label) > 10 ? substr($role->label, 0, 30) . " ..." : $role->label }}</td>
                        <td>{{ \Carbon\Carbon::create($role->created_at)->toDayDateTimeString() }}</td>
                        <td class="d-flex">
                            {{-- @can('delete', $role) --}}
                                <form action="{{ route('admin.roles.destroy', [ 'role' => $role->id ])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" href="" class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            {{-- @endcan --}}
                            {{-- @can('edit', $role) --}}
                                <a href="{{ route('admin.roles.edit', [ 'role' => $role->id ])}}" class="btn btn-sm btn-warning mr-2">ویرایش</a>
                            {{-- @endcan --}}
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
        </div>
            <!-- /.card-body -->
        </div>
        <div class="card-footer">
            {{ $roles->render() }}
        </div>
          <!-- /.card -->
        </div>
      </div>
@endsection
