<form action="{{ route('updateBrandAttachments', app()->getLocale()) }}" method="POST" id="userForm">

    @csrf
    <input type="hidden" name="brand_id" value="{{ $brand_id }}">

    <div class="row">
        <div class="col-md-6 form-group">
            <label>Contract</label>
            <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="1" name="contract"
                       @if(isset($attachments)) value="{{ $attachments->contract}}" @endif>
                <label class="custom-file-label" for="1">Choose file</label>
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label>Ad Approval</label>
            <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="2" name="ad_approval"
                       @if(isset($attachments)) value="{{ $attachments->ad_approval}}" @endif>
                <label class="custom-file-label" for="2">Choose file</label>
            </div>
        </div>

        <div class="col-md-12 form-group">
            <input type="submit" value="Submit" class="btn btn-danger" style="float: right">
        </div>
    </div>
</form>

<script>
    $(function () {
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });

</script>
