<style>
    .input-group-addon {
        padding: .5rem .75rem;
        padding-top: 18px;
        width: 50px;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 10px;
        color: #495057 !important;
        text-align: center;
        background-color: #bec0c670;
        border: 1px solid rgba(0, 0, 0, .15);
        border-radius: 0px .25rem .25rem 0px;
    }
</style>
@if(isset($employee))
    <form action="{{ route('employees.update', [app()->getLocale(),$employee]) }}" method="POST" id="userForm">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('employees.store', app()->getLocale()) }}" method="POST" id="userForm">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name"
                               @if(isset($employee)) value="{{ $employee->name }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone_number" placeholder="Phone"
                               @if(isset($employee)) value="{{ $employee->phone_number}}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email" autocomplete="off"
                               @if(isset($employee)) value="{{ $employee->email }}" @endif>
                    </div>
                    @if(!isset($employee))

                        <div class="col-md-6 form-group">
                            <label> Password</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control" name="password" placeholder="Password"
                                       autocomplete="off">
                                <div class="input-group-addon">
                                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-6 form-group">
                        <label>Active</label>
                        <select name="active" class="form-control">
                            @if(!isset($employee))
                                <option value="" selected disabled>Select Active</option>
                            @endif
                            <option value="0" @if(isset($employee) && $employee->active == 0) selected @endif>
                                False
                            </option>
                            <option value="1" @if(isset($employee) && $employee->active == 1) selected @endif>True
                            </option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="submit" value="Submit" class="btn btn-success" style="float: right">
                    </div>
                </div>
            </form>
            <script>

                $("#show_hide_password a").on('click', function (event) {
                    event.preventDefault();
                    if ($('#show_hide_password input').attr("type") == "text") {
                        $('#show_hide_password input').attr('type', 'password');
                        $('#show_hide_password i').addClass("fa-eye-slash");
                        $('#show_hide_password i').removeClass("fa-eye");
                    } else if ($('#show_hide_password input').attr("type") == "password") {
                        $('#show_hide_password input').attr('type', 'text');
                        $('#show_hide_password i').removeClass("fa-eye-slash");
                        $('#show_hide_password i').addClass("fa-eye");
                    }
                });
            </script>