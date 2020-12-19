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
@if(!isset($company))

    <div class="container">
        <div id="smartwizard">

            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="#step-1">
                        <strong>Company Basic Information</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-2">
                        <strong>Company Attachments</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-3">
                        <strong>Company Account Information</strong>
                    </a>
                </li>
            </ul>
            <hr>

            <form action="{{ route('companies.store', app()->getLocale()) }}" method="POST" id="userForm">
                @csrf
                <div class="tab-content">
                    <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Company Name</label>
                                <input type="text" class="form-control" name="name" autocomplete="off"
                                       placeholder="Company Name">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Commercial Registration No</label>
                                <input type="text" class="form-control" name="commercial_registration_no" placeholder="Commercial Registration No">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="date">Expiry Date Commercial Registration</label>
                                <input name="expiry_date_commercial_registration" id="datepicker" class="date-picker form-control" placeholder="Date"  autocomplete="off"/>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>IBAN</label>
                                <input type="text" class="form-control" name="iban" placeholder="IBAN">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Phone</label>
                                    <input type="text" class="form-control" name="phone" placeholder="Phone">
                            </div>
                            <div class="col-md-6 form-group">
                                <label> Email</label>
                                    <input type="email" class="form-control" id="email" name="email_company"
                                       autocomplete="off"
                                       placeholder="Email">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="0"  >
                                        False
                                    </option>
                                    <option value="1">
                                        True
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group"></div>
                            <div class="col-sm-2 imgUp">
                                <label>Company Icon </label>
                                <div class="imagePreview" style="@if( isset($company))
                                        background:url('{{asset('/images/company/'.$company->img.'')}}');
                                        background-position: center center;
                                        background-color: #fff;
                                        background-size: 100% 150px;
                                        background-repeat: no-repeat;
                                @endif"></div>
                                <label class="btn_edit_img btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                       style="color: #262673 !important;">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" name="icon" id="img"
                                           class="uploadFile img"
                                           value=""
                                           style="width: 0px;height: 0px;overflow: hidden;">
                                </label>
                            </div>

                        </div>
                    </div>
                    <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Commercial Registration</label>
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input"  id="1" name="commercial_registration"  >
                                    <label class="custom-file-label" for="1">Choose file</label>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Identity</label>
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="2"  name="Identity"  >
                                    <label class="custom-file-label" for="2">Choose file</label>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Bank Account</label>
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="3"  name="bank_account"  >
                                    <label class="custom-file-label" for="3">Choose file</label>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Privacy Policy</label>
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="4"  name="privacy_policy"  >
                                    <label class="custom-file-label" for="4">Choose file</label>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name_user" placeholder="Name"
                                       @if(isset($user)) value="{{ $user->name }}" @endif>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone_user" placeholder="Phone">
                            </div>
                            <div class="col-md-6 form-group">
                                <label> Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
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
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif

@if(isset($company))
    <form action="{{ route('companies.update', [app()->getLocale(),$company]) }}" method="POST" id="userForm">
        {{ method_field('PUT') }}
                @csrf
        <div class="row">
            <div class="col-md-6 form-group">
                <label>Company Name</label>
                <input type="text" class="form-control" name="name" autocomplete="off"
                       placeholder="Company Name" value="{{ $company->name }}" >
            </div>
            <div class="col-md-6 form-group">
                <label>Commercial Registration No</label>
                <input type="text" class="form-control" name="commercial_registration_no" placeholder="Commercial Registration No"
                       value="{{ $company->commercial_registration_no }}" >
            </div>
            <div class="col-md-6 form-group">
                <label for="date">Expiry Date Commercial Registration</label>
                <input name="expiry_date_commercial_registration" id="datepicker" class="date-picker form-control" placeholder="Date"  autocomplete="off"
                      value="{{ date("d-m-yy", strtotime($company->expiry_date_CR)) }}"/>
            </div>
            <div class="col-md-6 form-group">
                <label>IBAN</label>
                <input type="text" class="form-control" name="iban" placeholder="IBAN"
                value="{{$company->iban}}" />
            </div>
            <div class="col-md-6 form-group">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone" placeholder="Phone"
                      value="{{ $company->phone}}" />
            </div>
            <div class="col-md-6 form-group">
                <label> Email</label>
                <input type="email" class="form-control" id="email" name="email" autocomplete="off" placeholder="Email"
                      value="{{ $company->email}}" />
            </div>
            <div class="col-md-6 form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="0"
                            @if( $company->status == 0) selected @endif>
                        False
                    </option>
                    <option value="1"
                            @if( $company->status == 1) selected @endif>
                        True
                    </option>
                </select>
            </div>
            <div class="col-md-6 form-group"></div>
            <div class="col-sm-2 imgUp">
                <label>Company Icon </label>
                <div class="imagePreview" style="
                        background:url('{{asset('/images/company/'.$company->logo.'')}}');
                        background-position: center center;
                        background-color: #fff;
                        background-size: 100% 150px;
                        background-repeat: no-repeat;
                "></div>
                <label class="btn_edit_img btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                       style="color: #262673 !important;">
                    <i class="fa fa-pen icon-sm text-muted"></i>
                    <input type="file" name="icon" id="img"
                           class="uploadFile img"
                           value="{{$company->logo}}"
                           style="width: 0px;height: 0px;overflow: hidden;">
                </label>
            </div>
            <div class="col-md-12 form-group">
                <input type="submit" value="Submit" class="btn btn-success" style="float: right">
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

        $("#datepicker").datepicker({
            format: "dd-mm-yyyy",
        });

        $('#smartwizard').smartWizard({
            selected: 0, // Initial selected step, 0 = first step
            theme: 'dots', // theme for the wizard, related css need to include for other than default theme
            justified: true, // Nav menu justification. true/false
            autoAdjustHeight: true, // Automatically adjust content height
            cycleSteps: false, // Allows to cycle the navigation of steps
            backButtonSupport: true, // Enable the back button support
            enableURLhash: false,
            transition: {
                animation: 'slide-swing', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
                speed: '400', // Transion animation speed
                easing: '' // Transition animation easing. Not supported without a jQuery easing plugin
            }, toolbarSettings: {
                toolbarPosition: 'bottom', // none, top, bottom, both
                toolbarButtonPosition: 'right', // left, right, center
                showNextButton: true, // show/hide a Next button
                showPreviousButton: true, // show/hide a Previous button
                toolbarExtraButtons: [
                    $('<button></button>').text('Finish')
                        .addClass('btn btn-success sw-btn-group-extra')
                        .attr('style', 'color: #fff;background-color: #5cb85c;border: 1px solid #5cb85c;')
                        .attr('id', 'submitBtn')
                        .attr('type', 'submit')
                ] // Extra buttons to show on toolbar, array of jQuery input/buttons elements
            },
            anchorSettings: {
                anchorClickable: true, // Enable/Disable anchor navigation
                enableAllAnchors: false, // Activates all anchors clickable all times
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




