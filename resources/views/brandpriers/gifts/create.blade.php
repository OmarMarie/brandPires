<style>
    .imagePreview {
        width: 170px;
        height: 150px;
        background-position: center center;
        background: url('{{asset('/assets/images/default/default-img.jpg')}}');
        background-color: #fff;
        background-size: cover;
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

</style>
@if(isset($gift))
    <form action="{{ route('gifts.update', [app()->getLocale(),$gift]) }}" method="POST" id="form">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('gifts.store', app()->getLocale()) }}" method="POST" id="form">
                @endif
                @csrf
                @if(!isset($gift))
                <input type="hidden" name="campaign_id" value="{{$campaign_id}}">
                @endif
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Gift Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Gift Name"
                               @if(isset($gift)) value="{{ $gift->name }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Code Number</label>
                        <input type="text" class="form-control" name="code_number" placeholder="Code Number"
                               @if(isset($gift)) value="{{ $gift->code_number }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Gift From</label>
                        <input type="text" class="form-control" name="gift_from" placeholder="Gift From"
                               @if(isset($gift)) value="{{ $gift->gift_from}}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Center</label>
                        <input type="text" class="form-control" name="center" placeholder="Center"
                               @if(isset($gift)) value="{{ $gift->center}}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label> Country </label>
                        <select class="form-control" id="country_id" name="country_id">
                            @if(!isset($gift))
                                <option value="" selected disabled>Select Country</option>
                            @endif
                            @foreach($countries as $country)
                                <option @if(isset($gift) && $country->id == $gift->country_id) value="{{ $country->id }}"
                                        selected
                                        @else value="{{ $country->id }}" @endif>{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label> City</label>
                        <select class="form-control" id="city_id" name="city_id"
                                @if(isset($gift)) @else disabled="" @endif >
                            @if(!isset($gift))
                                <option value="" selected disabled>Select City</option>
                            @endif
                             @if(isset($gift))
                                 <script>
                                     var country_id = {{ $gift->country_id }}
                                     $.ajax({
                                         url: '/{{app()->getLocale()}}/getCities/' + country_id,
                                         method: 'get',
                                         success: function (result) {
                                             var city_id = {{ $gift->city_id }}
                                             $('#major_id option:not(:first)').remove();
                                             $.each(result, function (index, value) {
                                                 if (city_id == value.id)
                                                     $('#city_id').append("<option value='" + value.id + "' selected>" + value.name + "");
                                                 else
                                                     $('#city_id').append("<option value='" + value.id + "'>" + value.name + "");
                                             });

                                             $('#city_id').removeAttr('disabled');
                                         }
                                     });
                                 </script>
                             @endif
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Date Expired </label>
                        <input type="text" class="form-control" id="datepicker" name="date_of_coupon" placeholder="Date Expired"
                               @if(isset($gift)) value="{{ date("d-m-Y", strtotime($gift->date_of_coupon))}}" @endif>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-sm-2 imgUp">
                        <label>Gift Icon </label>
                        <div class="imagePreview" style="@if(isset($gift))
                                background:url('{{asset('/images/gift/'.$gift->img.'')}}');
                                background-position: center center;
                                background-color: #fff;
                                background-size: cover;
                                background-repeat: no-repeat;
                        @endif"></div>
                        <label class="btn_edit_img btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                               style="color: #262673 !important;">
                            <i class="fa fa-pen icon-sm text-muted"></i>
                            <input type="file" name="gift_icon" id="gift_icon" class="uploadFile img"
                                   value="{{ isset($gift) ? $gift->img: '' }}"
                                   style="width: 0px;height: 0px;overflow: hidden;">
                        </label>
                    </div>


                    <div class="col-md-12 form-group">
                        <input type="submit" value="Submit" class="btn btn-danger" style="float: right">
                    </div>
                </div>
            </form>

            <script>
                $(function () {
                    $('#datepicker').datepicker({
                        format: 'dd-mm-yyyy',
                        todayHighlight: true,
                    });

                    $('#country_id').on('change', function () {
                        var value = $(this).val();
                        $.ajax({
                            url: '/{{app()->getLocale()}}/getCities/' + value,
                            method: 'get',
                            success: function (result) {
                                $('#city_id option:not(:first)').remove();
                                $.each(result, function (index, value) {
                                    $('#city_id').append("<option value='" + value.id + "'>" + value.name + "");
                                });

                                $('#city_id').removeAttr('disabled');
                            }
                        });
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
