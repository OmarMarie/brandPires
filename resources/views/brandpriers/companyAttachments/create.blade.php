<form action="{{ route('updateCompanyAttachments', app()->getLocale()) }}" method="POST" id="userForm">

    @csrf
    <input type="hidden" name="company_id" value="{{ $company_id }}">

    <div class="row">
        <div class="col-md-6 form-group">
            <label>Commercial Registration</label>
            <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="1" name="commercial_registration"
                       @if(isset($attachments)) value="{{ $attachments->commercial_registration}}" @endif>
                <label class="custom-file-label" for="1">Choose file</label>
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label>Identity</label>
            <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="2" name="Identity"
                       @if(isset($attachments)) value="{{ $attachments->Identity}}" @endif>
                <label class="custom-file-label" for="2">Choose file</label>
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label>Bank Account</label>
            <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="3" name="bank_account"
                       @if(isset($attachments)) value="{{ $attachments->bank_account}}" @endif>
                <label class="custom-file-label" for="3">Choose file</label>
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label>Privacy Policy</label>
            <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="4" name="privacy_policy"
                       @if(isset($attachments)) value="{{ $attachments->privacy_policy}}" @endif>
                <label class="custom-file-label" for="4">Choose file</label>
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
