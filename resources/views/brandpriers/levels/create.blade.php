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
@if(isset($level))
    <form action="{{ route('levels.update', [app()->getLocale(),$level]) }}" method="POST" id="userForm">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('levels.store', app()->getLocale()) }}" method="POST" id="userForm">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Level Name</label>
                        <input type="text" class="form-control" name="level_name" placeholder="Level Name"
                               @if(isset($level)) value="{{ $level->level_name }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>From Points</label>
                        <input type="number" class="form-control" name="from_pts" placeholder="From Points"
                               @if(isset($level)) value="{{ $level->from_pts }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>To Points</label>
                        <input type="number" class="form-control" name="to_pts" placeholder="To Points"
                               @if(isset($level)) value="{{ $level->to_pts}}" @endif>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Extra</label>
                        <input type="number" class="form-control" name="extra" placeholder="Extra"
                               @if(isset($level)) value="{{ $level->extra}}" @endif>
                    </div>


                    <div class="col-md-6 form-group">
                        <label>Speed</label>
                        <input type="number" class="form-control" name="speed" placeholder="Speed"
                               @if(isset($level)) value="{{ $level->speed}}" @endif>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Duration</label>
                        <input type="number" class="form-control" name="duration" placeholder="Duration"
                               @if(isset($level)) value="{{ $level->duration}}" @endif>
                    </div>

                    <div class="col-sm-2 imgUp">
                        <label>Level Icon </label>
                        <div class="imagePreview" style="@if(isset($level))
                                background:url('{{asset('/images/level/'.$level->level_icon.'')}}');
                                background-position: center center;
                                background-color: #fff;
                                background-size: cover;
                                background-repeat: no-repeat;
                        @endif"></div>
                        <label class="btn_edit_img btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                               style="color: #262673 !important;">
                            <i class="fa fa-pen icon-sm text-muted"></i>
                            <input type="file" name="level_icon" id="level_icon" class="uploadFile img"
                                   value="{{ isset($level) ? $level->level_icon: '' }}"
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
