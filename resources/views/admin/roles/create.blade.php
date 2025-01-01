@extends('admin.layouts.app')


@section('content')
{{-- header --}}
<x-admin.header>
    {{-- title --}}
    پنل ایجاد مقام جدید

    {{-- breadcrumb --}}
    <x-slot:breadcrump>
        <x-admin.breadcrump href="{{ url('/admin')}}" >پنل مدیریت</x-admin.breadcrump>
        <x-admin.breadcrump href="{{ route('admin.roles.index')}}">لیست مقام ها</x-admin.breadcrump>
        <x-admin.breadcrump :active="true">ایجاد مقام جدید</x-admin.breadcrump>
    </x-slot>
</x-header>

{{-- content --}}
    <div class="row">
        <div class="col-12">
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">فرم ایجاد مقام </h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.roles.store')}}" method="post" class="form-horizontal" >
                    @csrf
                    <div class="card-body">

                      <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">نام مقام</label>
                        <div class="col-sm-10">
                          <input value="{{old('name')}}" type="text" name="name" class="form-control" id="name" placeholder="نام مقام جدید را وارد کنید">
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
                        <label for="label" class="col-sm-2 control-label">توضیحات مقام</label>
                        <div class="col-sm-10">
                          <textarea name="label" id="label" cols="10" rows="10" class="form-control" placeholder="توضایحات مقام را اضافه کنید"></textarea>
                        </div>
                      </div>
                      @error('label')
                        <div class="error-message text-danger fw-bold">
                            <strong>
                                {{ $message }}
                            </strong>
                        </div>
                      @enderror

                      <div class="form-group">
                        <label for="permissions" class="col-sm-2 control-label">دسترسی ها</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="permissions[]" id="permissions" multiple >
                            @foreach (App\Models\Permission::all() as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }} - {{ $permission->label }}</option>
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
