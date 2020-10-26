<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="{{ isset($title) ? str_slug($title) :  'permissionHeading' }}">
		<div class="row">
		<div class="col-md-3">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}" aria-expanded="{{ $closed ?? 'true' }}" aria-controls="dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}">
                {{ $title ?? 'Override Permissions' }} {!! isset($user) ? '<span class="text-danger">(' . $user->getDirectPermissions()->count() . ')</span>' : '' !!}
            </a>
        </h4>
		</div>
		@foreach($permission_heads as $head)
		
		<div class="col-md-1 {{$head == 'view' || $head =='approval' ?'d-none':''}}">
		@if($head =='full') 
			@php($option = (isset($options) ? $options : []))
			<label class="checkbox_label">
				{!! Form::checkbox("full_access", 'full_access', '', array_merge(['class'=>'full_access'],$option)) !!}
				<i></i>
			</label>
		@endif
		
		{{($head =='full') ? 'Full Access' : ucwords(implode(" ",explode('_',$head)))}}</div>
		@endforeach
		</div>
    </div>
    <div id="dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}" class="panel-collapse collapse show in {{ $closed ?? 'in' }}" role="tabpanel" aria-labelledby="dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}">
        <div class="panel-body">
           
			@foreach($modules as $module)
			 <div class="row">
				<div class="col-md-3">
				{{$module->display_name}}
				</div>
                @foreach($module->permissions as $perm)
                    <?php
                        $per_found = null;

                        if( isset($role) ) {
                            $per_found = $role->hasPermissionTo($perm->name);
                        }

                        if( isset($user)) {
                            $per_found = $user->hasDirectPermission($perm->name);
                        }
						$option = (isset($options) ? $options : []);
						$full_class = (strpos($perm->name, 'full') !== false) ?'full':'';
						$view_class = (strpos($perm->name, 'view') !== false) ?'view':'';
                    ?>					
                    <div class="col-md-1 {{(strpos($perm->name, 'view') !== false) ||  ($perm->name == 'approval_approvals') ?'d-none':''}}">
					    @if($perm->status == 'active')
                        <div class="checkbox toggle_check">
                            <label class="toggle_check_label {{ str_contains($perm->name, 'delete') ? 'text-danger' : '' }}">
                                {!! Form::checkbox("permissions[]", $perm->name, $per_found, array_merge(['class'=>$module->name.'_class'." ".$full_class." ".$view_class],$option)) !!}
								<span class="togele_btn"></span>
                            </label>
                        </div>
						@endif
                    </div>
                @endforeach
				</div>
			@endforeach
            
        </div>
    </div>
</div>