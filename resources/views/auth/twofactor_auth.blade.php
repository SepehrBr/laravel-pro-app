@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Two factor Auth
                    </div>
                    <div class="card-body">
                        <form action="#" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="token" class="col-form-label">token</label>
                                <input type="text" class="form-control" name="token" placeholder="enter your token">
                                @error('token')
                                    <div class="error-message text-danger fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                            <br>
                            <button  class="btn btn-primary">Validate</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
