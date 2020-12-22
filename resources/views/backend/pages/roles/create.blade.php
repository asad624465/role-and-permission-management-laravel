@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header">{{ __('Roles Management') }}</div>
                	<form method="post" action="{{route('roles.store')}}">
                		@csrf

                		<div class="form-row mt-4 justify-content-md-center">
                			<div class="form-group col-md-8 col-md-offset-2">
	      						<label for="inputEmail4">Role name</label>
	      						<input type="text" class="form-control" id="name"  name="name">
	    					</div>
	    					<div class="form-group col-md-8">
	      						<div class="form-check">
      								<input class="form-check-input" type="checkbox" id="allchecked">
      								<label class="form-check-label" for="allchecked">All</label>

    							</div>
	    					</div>
	    					@php $i=1; @endphp
	    					@foreach($permissionGroup as $group)
	    					<div class="form-group col-md-8">
	      						<div class="form-check">
      								<input class="form-check-input" type="checkbox" id="{{$i}}-setCheck" onclick="checkedPermissionGroup('role-{{$i}}-management-checkbox',this);">
      								<label class="form-check-label" for="{{$i}}-setCheck">{{$group->group_name}}</label>

    							</div>
	    					</div>
	    					<div class="form-group col-md-7 role-{{$i}}-management-checkbox">
	    						@php $j=1; @endphp
	    						@foreach($permissions as $permission)
	    						@if($permission->group_name==$group->group_name)
	      						<div class="form-check">
      								<input class="form-check-input" name="permission[]" type="checkbox" id="gridCheck-{{ $permission->id}}" value="{{ $permission->id}}">
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
}
</script>
@endsection
