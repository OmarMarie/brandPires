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
@if(isset($player))
    <form action="{{ route('players.update', [app()->getLocale(),$player]) }}" method="POST" id="userForm">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('players.store', app()->getLocale()) }}" method="POST" id="userForm">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="first_name" placeholder="First Name"
                               @if(isset($player)) value="{{ $player->first_name }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Last Name"
                               @if(isset($player)) value="{{ $player->last_name }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email"
                               @if(isset($player)) value="{{ $player->email }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>phone</label>
                        <input type="text" class="form-control" name="phone_number" placeholder="phone"
                               @if(isset($player)) value="{{ $player->phone_number }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="datepicker">Date Birth</label>
                        <input name="birth_day" id="datepicker" placeholder="Date Birth"
                               class="date-picker form-control"
                               @if(isset($player)) value="{{ $player->birth_day}}" @endif />
                    </div>
                    @if(!isset($player))
                    <div class="col-md-6 form-group">
                        <label>UserName</label>
                        <input type="text" class="form-control" name="username" placeholder="UserName">
                    </div>
                    <div class="col-md-6 form-group">
                        <label> Password</label>
                        <div class="input-group" id="show_hide_password">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                            <div class="input-group-addon">
                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-12 form-group">
                        <input type="submit" value="Submit" class="btn btn-dark" style="float: right">
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

                $(function () {
                    $("#datepicker").datepicker({
                        format: "dd-mm-yyyy",
                    });
                });
            </script>
