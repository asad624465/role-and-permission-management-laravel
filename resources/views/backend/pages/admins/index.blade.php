@extends('layouts.addminMaster')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-item-center justify-content-between">
                  {{ __('User List') }}
                  <a href="{{ route('users.create')}}" class="btn btn-primary btn-sm">Add new user</a>
                </div>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col" >Email</th>
                        <th scope="col" >Permission</th>
                        <th scope="col">Action</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($users as $user)
                      <tr>
                        <th scope="row">{{$loop->index+1}}</th>
                        <td>{{$user->name}}</td>
                        <td>
                           {{$user->email}} 
                        </td>
                        <td>
                           @foreach($user->roles as $role)
                           {{$role->name}}
                           @endforeach 
                        </td>
                        <td>
                          <a class="btn btn-success btn-sm" href="{{route('users.edit',$user->id)}}">Edit</a>
                          <a class="btn btn-danger btn-sm" href="{{ route('users.destroy',$user->id)}}"onclick="event.preventDefault();
                                    document.getElementById('delete-form-{{$user->id }}').submit();">
                                    {{ __('Delete') }}
                            </a>
                            <form id="delete-form-{{$user->id }}" action="{{ route('users.destroy',$user->id)}}" method="POST" class="d-none">
                                @method('DELETE')
                                @csrf
                            </form>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>
@endsection