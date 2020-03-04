<div class="card">
    <div class="card-header" id="heading-{{ isset($title) ? Str::slug($title) : 'permission-heading' }}">
        <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse-{{ isset($title) ? Str::slug($title) : 'permission-heading' }}" aria-expanded="false" aria-controls="collapse-{{ isset($title) ? Str::slug($title) : 'permission-heading' }}">
            {{ $title }}
        </a>
    </div>

    <div id="collapse-{{ isset($title) ? Str::slug($title) : 'permission-heading' }}" class="collapse" aria-labelledby="heading-{{ isset($title) ? Str::slug($title) : 'permission-heading' }}" data-parent="#accordion-role-permission" style="">
        <div class="card-body">
            <div class="row">
                @foreach($permissions as $perm)
                    <?php
                        $per_found = null;

                        if( isset($role) ) {
                            $per_found = $role->hasPermissionTo($perm->name);
                        }

                        if( isset($user)) {
                            $per_found = $user->hasDirectPermission($perm->name);
                        }
                    ?>

                    <div class="col-md-3">
                        <div class="checkbox">
                            <label class="{{ Str::contains($perm->name, 'delete') ? 'text-danger' : '' }}">
                                {!! Form::checkbox("permissions[]", $perm->name, $per_found, isset($options) ? $options : []) !!} {{ $perm->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @can('edit_roles')
            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>
        @endcan
    </div>
</div>