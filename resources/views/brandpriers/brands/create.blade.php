<link rel="stylesheet" href="{{ asset('assets/smartwizard/css/smart_wizard_all.css') }}">
<style>
    .imagePreview {
        width: 170px;
        height: 150px;
        background-position: center center;
        background: url('{{asset('/assets/images/default/default-img.jpg')}}');
        background-color: #fff;
        background-size: 100% 150px;
        background-repeat: no-repeat;
        border-radius: 10px;
        display: inline-block;
        webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, .075);
        box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, .075);
        border: 3px solid #fff;
    }

    .btn_edit_img {
        margin-top: -333px;
        margin-left: 155px;

    }

    .imgUp {
        margin-bottom: 15px;
    }

    input-group-addon {

    }
</style>
@if(!isset($brand))
    <div class="container">
        <div id="smartwizard">

            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="#step-1">
                        <strong>Brand Basic Information</strong>
                    </a>
                </li>
            </ul>
            <hr>

            <form action="{{ route('brands.store', app()->getLocale()) }}" method="POST" id="userForm">
                @csrf
                <div class="tab-content">
                    <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Brand Name</label>
                                <input type="text" class="form-control" name="brand_name" autocomplete="off"
                                       placeholder="Brand Name"
                                       @if(isset($brand)) value="{{ $brand->brand_name }}" @endif>
                            </div>
                            <div class="col-md-6 form-group">
                                <label> Company </label>
                                <select name="company_id" class="form-control">
                                    <option value="" selected disabled>Select Company</option>
                                    @foreach($companies  as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Active</label>
                                <select name="status" class="form-control">
                                    <option value="0"
                                            @if(isset($brand) && $brand->status == 0) selected @endif>
                                        False
                                    </option>
                                    <option value="1"
                                            @if(isset($brand) && $brand->status == 1) selected @endif>
                                        True
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Contract</label>
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="1" name="contract">
                                    <label class="custom-file-label" for="1">Choose file</label>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Ad Approval</label>
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="2" name="ad_approval">
                                    <label class="custom-file-label" for="2">Choose file</label>
                                </div>
                            </div>

                            <div class="col-sm-2 imgUp">
                                <label>Brand Icon </label>
                                <div class="imagePreview" style="@if( isset($brand))
                                        background:url('{{asset('/images/brand/'.$brand->img.'')}}');
                                        background-position: center center;
                                        background-color: #fff;
                                        background-size: 100% 150px;
                                        background-repeat: no-repeat;
                                @endif"></div>
                                <label class="btn_edit_img btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                       style="color: #262673 !important;">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" name="brand_icon" id="img"
                                           class="uploadFile img"
                                           value="{{ isset($brand) ? $brand->img: '' }}"
                                           style="width: 0px;height: 0px;overflow: hidden;">
                                </label>
                            </div>

                        </div>

                    </div>
                   {{-- <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name_user" placeholder="Name"
                                       @if(isset($user)) value="{{ $user->name }}" @endif>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone" placeholder="Phone">
                            </div>
                            <div class="col-md-6 form-group">
                                <label> Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       autocomplete="off"
                                       placeholder="Email">
                            </div>
                            <div class="col-md-6 form-group">
                                <label> Password</label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password" autocomplete="off" class="form-control"
                                           name="password" placeholder="Password">
                                    <div class="input-group-addon"
                                         style="padding: .5rem .75rem; padding-top: 18px; width: 50px; margin-bottom: 0; font-size: 1rem; font-weight: 400; line-height: 10px; color: #495057 !important; text-align: center; background-color: #bec0c670; border: 1px solid rgba(0, 0, 0, .15); border-radius: 0px .25rem .25rem 0px;">
                                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                </div>
                <div class="col-md-12 form-group">
                    <input type="submit" value="Submit" class="btn btn-dark" style="float: right">
                </div>
            </form>
        </div>
    </div>
@endif
@if(isset($brand))
    <form action="{{ route('brands.update', [app()->getLocale(),$brand]) }}" method="POST" id="userForm">
        {{ method_field('PUT') }}
        @csrf
        <div class="row">
            <div class="col-md-6 form-group">
                <label>Brand Name</label>
                <input type="text" class="form-control" name="brand_name" placeholder="Brand Name"
                       @if(isset($brand)) value="{{ $brand->brand_name }}" @endif>
            </div>
            <div class="col-md-6 form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="0" @if(isset($brand) && $brand->status == 0) selected @endif>False</option>
                    <option value="1" @if(isset($brand) && $brand->status == 1) selected @endif>True</option>
                </select>
            </div>

            <div class="col-sm-2 imgUp">
                <label>Brand Icon </label>
                <div class="imagePreview" style="@if( isset($brand))
                        background:url('{{asset('/images/brand/'.$brand->img.'')}}');
                        background-position: center center;
                        background-color: #fff;
                        background-size: 100% 150px;
                        background-repeat: no-repeat;
                @endif"></div>
                <label class="btn_edit_img btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                       style="color: #262673 !important;">
                    <i class="fa fa-pen icon-sm text-muted"></i>
                    <input type="file" name="brand_icon" id="img" class="uploadFile img"
                           value="{{ isset($brand) ? $brand->img: '' }}"
                           style="width: 0px;height: 0px;overflow: hidden;">
                </label>
            </div>


            <div class="col-md-12 form-group">
                <input type="submit" value="Submit" class="btn btn-dark" style="float: right">
            </div>
        </div>
    </form>
@endif
<script type="text/javascript" src="{{ asset('assets/smartwizard/js/jquery.smartWizard.js') }}"></script>
<script>
    $(function () {
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

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

        $('#smartwizard').smartWizard({
            selected: 0, // Initial selected step, 0 = first step
            theme: 'dots', // theme for the wizard, related css need to include for other than default theme
            justified: true, // Nav menu justification. true/false
            autoAdjustHeight: true, // Automatically adjust content height
            cycleSteps: false, // Allows to cycle the navigation of steps
            backButtonSupport: true, // Enable the back button support
            @if(isset($supplier))
            enableURLhash: false, // Enable selection of the step based on url hash
            @else
            enableURLhash: true,
            @endif
            transition: {
                animation: 'slide-swing', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
                speed: '400', // Transion animation speed
                easing: '' // Transition animation easing. Not supported without a jQuery easing plugin
            }, toolbarSettings: {
                toolbarPosition: 'bottom', // none, top, bottom, both
                toolbarButtonPosition: 'right', // left, right, center
                showNextButton: false, // show/hide a Next button
                showPreviousButton: false, // show/hide a Previous button
               /* toolbarExtraButtons: [
                    $('<button></button>').text('Finish')
                        .addClass('btn btn-dark sw-btn-group-extra')

                        .attr('id', 'submitBtn')
                        .attr('type', 'submit')
                ]*/ // Extra buttons to show on toolbar, array of jQuery input/buttons elements
            },
            anchorSettings: {
                anchorClickable: true, // Enable/Disable anchor navigation
                @if(isset($supplier))
                enableAllAnchors: true, // Activates all anchors clickable all times
                @else
                enableAllAnchors: false, // Activates all anchors clickable all times
                @endif
                markDoneStep: true, // Add done css
                markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
            },
        });
        $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection) {
            if ($('button.sw-btn-next').hasClass('disabled')) {
                $('button.sw-btn-next').hide();
                $('.sw-btn-group-extra').show(); // show the button extra only in the last page
            } else {
                $('.sw-btn-group-extra').hide();
                $('button.sw-btn-next').show();
            }

        });

        $(document).on("change", ".uploadFile", function () {
            var uploadFile = $(this);
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function () { // set image data as background of div
                    //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                    uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + this.result + ")");
                }
            }

        });
    });
</script>




