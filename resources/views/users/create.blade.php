@extends('layouts.header')

@section('content')
    <div class="container">
        <h4>Create User</h4>

        <form action="{{route('users.store')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="">User Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label for="">Role</label>
                    <select name="role_id" id="role_id" class="form-control">
                        <option value="">Select Role</option>
                        @foreach (config('web_constant.user_roles') as $key=>$role)
                            <option value="{{$key}}" {{old('role_id') == $key ? 'selected' : ''}}>{{$role}}</option>
                        @endforeach
                        @error('role_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </select>
                </div>
            </div>
            <div class="float-right">
                <a href="/users" class="btn btn-md btn-default">Cancel</a>
                <button type="submit" class="btn btn-md btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection