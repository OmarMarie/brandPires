@if(isset($user))
    <form action="{{ route('users.update', [app()->getLocale(),$user]) }}" method="POST" id="userForm">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('users.store', app()->getLocale()) }}" method="POST" id="userForm">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name"
                               @if(isset($user)) value="{{ $user->name }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email"
                               @if(isset($user)) value="{{ $user->email }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" placeholder="Phone"
                               @if(isset($user)) value="{{ $user->phone_number}}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                            <label>Role</label>
                            @if (!isset($user))
                            {!! Form::select('roles[]', $roles,[], array('class' => 'form-control')) !!}
                            @else
                            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control')) !!}
                            @endif
                       {{-- <select class="form-control" name="role" {{isset($user) ?'disabled':''}}>
                            @if(!isset($user))
                                <option value="" selected disabled>Select User Type</option>
                            @endif
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{isset($user) ? ($role->id == $id_role_user) ? 'selected ' : '' : ''}}>{{ $role->name }}</option>
                            @endforeach
                        </select>--}}

                    </div>

                    {{--
                         <div class="col-md-6 form-group">
                             <label>Active</label>
                             <select name="active" class="form-control">
                                 <option value="0" @if(isset($user) && $user->type == 0) selected @endif>False</option>
                                 <option value="1" @if(isset($user) && $user->type == 1) selected @endif>True</option>
                             </select>
                         </div>--}}
                    <div class="col-md-12 form-group">
                        <input type="submit" value="Submit" class="btn btn-success" style="float: right">
                    </div>
                </div>
            </form>
