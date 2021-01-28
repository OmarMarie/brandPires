@if(isset($role))
    <form action="{{ route('roles.update', [app()->getLocale(),$role]) }}" method="POST" id="Form">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('roles.store', app()->getLocale()) }}" method="POST" id="userForm">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name"
                               @if(isset($role)) value="{{ $role->name }}" @endif>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Permission:</strong>
                            <br/>
                            @if(!isset($role))
                                @foreach($permission as $value)
                                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                        {{ $value->name }}</label>
                                    <br/>
                                @endforeach
                            @else
                                @foreach($permission as $value)
                                    <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                        {{ $value->name }}</label>
                                    <br/>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <input type="submit" value="Submit" class="btn btn-dark" style="float: right">
                    </div>
                </div>
            </form>
