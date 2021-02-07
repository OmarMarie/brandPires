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
@if(isset($tank))
    <form action="{{ route('tanks.update', [app()->getLocale(),$tank]) }}" method="POST" id="userForm">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('tanks.store', app()->getLocale()) }}" method="POST" id="userForm">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Tank Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Tank Name"
                               @if(isset($tank)) value="{{ $tank->name }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" name="price" placeholder="Price"
                               @if(isset($tank)) value="{{ $tank->price }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Size</label>
                        <input type="number" class="form-control" name="size" placeholder="Size"
                               @if(isset($tank)) value="{{ $tank->size}}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Live Time</label>
                        <input type="number" class="form-control" name="live_time" placeholder="Live Time"
                               @if(isset($tank)) value="{{ $tank->live_time}}" @endif>
                    </div>
                    <div class="col-md-12 form-group">
                        <div class="col-sm-2 imgUp">
                            <label>Tank Icon </label>
                            <div class="imagePreview" style="@if(isset($tank))
                                    background:url('{{asset('/images/tank/'.$tank->tank_icon.'')}}');
                                    background-position: center center;
                                    background-color: #fff;
                                    background-size: cover;
                                    background-repeat: no-repeat;
                            @endif"></div>
                            <label class="btn_edit_img btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                   style="color: #262673 !important;">
                                <i class="fa fa-pen icon-sm text-muted"></i>
                                <input type="file" name="tank_icon" id="tank_icon" class="uploadFile img"
                                       value="{{ isset($tank) ? $tank->tank_icon: '' }}"
                                       style="width: 0px;height: 0px;overflow: hidden;">
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <input type="submit" value="Submit" class="btn btn-danger" style="float: right">
                    </div>
                </div>
            </form>

            <script>
                $(function () {
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
