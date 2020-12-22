@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header">{{ __('Roles Edit') }}</div>
                	<form method="post" action="{{route('roles.update',$role->id)}}">
                		@method('PUT')
                		@csrf

                		<div class="form-row mt-4 justify-content-md-center">
                			<div class="form-group col-md-8 col-md-offset-2">
	      						<label for="inputEmail4">Role name</label>
	      						<input type="text" class="form-control" id="name"  name="name" value="{{$role->name}}">
	    					</div>
	    					<div class="form-group col-md-8">
	      						<div class="form-check">
      								<input class="form-check-input" type="checkbox" id="allchecked" {{App\User::roleHasPermissions($role,$permissions)?"checked":""}}>
      								<label class="form-check-label" for="allchecked">All</label>

    							</div>
	    					</div>
	    					@php $i=1; @endphp
	    					@foreach($permissionGroup as $group)
	    					@php $result = App\User::permissionGroupById($group->group_name);
	    					@endphp
	    					<div class="form-group col-md-8">
	      						<div class="form-check">
      								<input class="form-check-input" type="checkbox" id="{{$i}}-setCheck" onclick="checkedPermissionGroup('role-{{$i}}-management-checkbox',this);" {{App\User::roleHasPermissions($role,$result)?"checked":""}}>
      								<label class="form-check-label" for="{{$i}}-setCheck">{{$group->group_name}}</label>

    							</div>
	    					</div>
	    					<div class="form-group col-md-7 role-{{$i}}-management-checkbox">
	    						@php $j=1; @endphp
	    						@foreach($permissions as $permission)
	    						@if($permission->group_name==$group->group_name)
	      						<div class="form-check">
      								<input class="form-check-input" name="permission[]" type="checkbox" {{$role->hasPermissionTo($permission->name)?"checked":""}} id="gridCheck-{{ $permission->id}}" value="{{ $permission->id}}" onclick="checkSinglePermission('role-{{$i}}-management-checkbox','{{$i}}-setCheck',{{ count($result)}});">
      									<label class="form-check-label" for="gridCheck-{{ $permission->id}}">{{ $permission->name}}</label>
    							</div>
    							@endif
    							@php $j++; @endphp
    							@endforeach
	    					</div>
	    					@php $i++; @endphp
	    					@endforeach
	  					</div>
	  					<div class="form-group col-md-8 col-md-offset-2">
	      						<button class="btn btn-info" type="submit">Submit</button>
	    					</div>
    				</form>
            </div>
        </div>
    </div>
</div>

 <script type="application/javascript">
   $(document).ready(function(){ 
    $("#allchecked").click(function(){
        if($(this).is(':checked')){
        	$('input[type=checkbox]').prop('checked',true);
        }else{
        	$('input[type=checkbox]').prop('checked',false);
        }
    })
});

function checkedPermissionGroup(groupclassname,checkthis) {
	const groupId = $("#"+checkthis.id);
	const classCheckBox = $("."+groupclassname+" input");
	if(groupId.is(':checked')){
		classCheckBox.prop('checked',true);
	}else{
		classCheckBox.prop('checked',false);
	}
	implementAllChecked();
}
function checkSinglePermission(groupClassName,groupID,countTotalPermission) {
	const classCheckbox = $('.'+groupClassName+'input');
	const groupIDCheckbox = $('#'+groupID);
	if($("."+groupClassName+" input:checked").length==countTotalPermission){
		groupIDCheckbox.prop('checked',true);
	}else{
		groupIDCheckbox.prop('checked',false);
	}
	implementAllChecked();
}
function implementAllChecked(){
	const countPermission = {{ count($permissions)}};
	const countPermissionGroup = {{ count($permissionGroup)}};
	if($("input[type='checkbox']:checked").length >= parseInt(countPermission) + parseInt(countPermissionGroup)){
		$("#allchecked").prop('checked',true);
	}else{
		$("#allchecked").prop('checked',false);
	}
}
</script>
@endsection
