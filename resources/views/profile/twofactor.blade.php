@extends('profile.layouts')

@section('profile.main')
    <h3>two factor</h3>
    <form action="{{ route('twofactor') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="type" >Type</label>
            <select name="type" id="type" class="form-control" >
                @foreach (config('twofactor.types') as $key => $value)
                    <option value="{{ $key }}" {{ (auth()->user()->twofactor_type == $key) ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
            @error('type')
                <div class="error-message text-danger fw-bold">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone" >phone</label>
            <input type="phone" name="phone" id="phone" class="form-control" placeholder="add your phone number" value="{{ old('phone_number') ?? auth()->user()->phone_number}}" >
            @error('phone')
                <div class="error-message text-danger fw-bold">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div class="form-group">
            <button class="btn btn-primary">
                update
            </button>
        </div>
    </form>
@endsection
