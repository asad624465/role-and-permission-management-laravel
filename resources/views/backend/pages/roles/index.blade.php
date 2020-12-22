@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Roles Management') }}</div>

                <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col" style="width: 50%">Permissions</th>
      <th scope="col">Action</th>
      
    </tr>
  </thead>
  <tbody>
    @foreach($roles as $role)
    <tr>
      <th scope="row">{{$loop->index+1}}</th>
      <td>{{$role->name}}</td>
      <td>
            @php $i=0; @endphp
          @foreach($role->permissions as $permission)
            <span class="badge {{($i%2==0)?'badge-success':'badge-primary'}}">{{ $permission->name }}</span> 
            @php $i++; @endphp
          @endforeach
      </td>
      <td>
            <a class="btn btn-success btn-sm" href="{{route('roles.edit',$role->id)}}">Edit</a> <a class="btn btn-danger btn-sm" href="{{route('roles.destroy',$role->id)}}">Delete</a> 
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
