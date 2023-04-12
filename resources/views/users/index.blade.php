@extends('layouts.header')

@section('content')
@php
    $role_permissions = \App\Permission::where('permissions.role_id', auth()->user()->role_id)
        ->pluck('permissions.route_name')->toArray();
@endphp
    <div class="container">
        <h4>Users</h4>
        @if (in_array('user.create', $role_permissions))
        <div class="text-right">
            <button type="button" class="btn btn-success float-right"><i class="fa fa-plus"></i>  <a class="nav-link text-white" href="{{ url('users/create') }}"> Create Uesr </a></button>
        </div>
        @endif
        <br><br><br>
        @if(session()->has('success'))
            <div class="alert alert-success msg">
                {{ session()->get('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger msg">
                {{ session()->get('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="tb-header">
                            <th style="width:10px;">#</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key=>$user)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{config('web_constant.user_roles.'.$user->role_id)}}</td>
                                <td>
                                    <form action="{{ URL::to('users/'.$user->id)}}" method="post" class="user_create">
                                        @csrf
                                        @method('DELETE')
                                        @if (in_array('user.show', $role_permissions) ||
                                                in_array('user.edit', $role_permissions) ||
                                                in_array('user.destroy', $role_permissions) )
                                            <a id="" class="nav-link dropdown-toggle black-text actions" href="#"
                                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                v-pre>
                                            </a>
                                        <div class="dropdown-menu action-list" aria-labelledby="actions">
                                        @if(in_array("user.show", $role_permissions))
                                            <a href="{{url('users/'.$user->id)}}" class="dropdown-item text-blue userView">View Detail</a>
                                        @endif
                                        @if(in_array("user.edit", $role_permissions))
                                            <a href="{{url('users/'.$user->id.'/edit')}}" class="dropdown-item text-blue userEdit">Edit</a>
                                        @endif
                                        @if(in_array("user.destroy", $role_permissions))
                                            <span class="dropdown-item text-blue userDelete">Delete</span>
                                        @endif
                                    </div>
                                    @endif
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('.msg').delay(3000).fadeOut();
        });

        $('.userDelete').click(function(){
            if(confirm('Are you sure you want to delete?')){
                $(this).parent().parent().submit();
            }else{
                return false;
            }
        });
    </script>
@endsection