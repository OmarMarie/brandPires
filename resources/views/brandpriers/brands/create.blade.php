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

</style>
@if(isset($brand))
    <form action="{{ route('brands.update', [app()->getLocale(),$brand]) }}" method="POST" id="userForm">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('brands.store', app()->getLocale()) }}" method="POST" id="userForm">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Brand Name</label>
                        <input type="text" class="form-control" name="brand_name" placeholder="Brand Name"
                               @if(isset($brand)) value="{{ $brand->brand_name }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Total Bubbles Number</label>
                        <input type="text" class="form-control" name="total_bubbles_number"
                               placeholder="Total Bubbles Number"
                               @if(isset($brand)) value="{{ $brand->total_bubbles_number }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Total Gifts Number</label>
                        <input type="text" class="form-control" name="total_gifts_number"
                               placeholder="Total Gifts Number"
                               @if(isset($brand)) value="{{ $brand->total_gifts_number}}" @endif>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Total Price</label>
                        <input type="text" class="form-control" name="total_price" placeholder="Total Price"
                               @if(isset($brand)) value="{{ $brand->total_price}}" @endif>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Active</label>
                        <select name="status" class="form-control">
                            <option value="0" @if(isset($brand) && $brand->status == 0) selected @endif>False</option>
                            <option value="1" @if(isset($brand) && $brand->status == 1) selected @endif>True</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group"></div>

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
                        <input type="submit" value="Submit" class="btn btn-success" style="float: right">
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