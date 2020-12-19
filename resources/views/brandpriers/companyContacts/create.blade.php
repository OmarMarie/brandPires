<form action="{{ route('storeCompanyContacts', app()->getLocale()) }}" method="POST" id="userForm">

    @csrf
    <input type="hidden" name="company_id" value="{{ $company_id }}">

    <div class="row">
        <div class="col-md-6 form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name" placeholder="Name"
                   @if(isset($user)) value="{{ $company->name }}" @endif>
        </div>
        <div class="col-md-6 form-group">
            <label>Job Title</label>
            <input type="text" class="form-control" name="job_title" placeholder="Job Title"
                   @if(isset($company)) value="{{ $company->job_title }}" @endif>
        </div>
        <div class="col-md-6 form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email"
                   @if(isset($company)) value="{{ $company->email }}" @endif>
        </div>
        <div class="col-md-6 form-group">
            <label>Phone</label>
            <input type="text" class="form-control" name="phone" placeholder="Phone"
                   @if(isset($company)) value="{{ $company->phone}}" @endif>
        </div>
        <div class="col-md-12 form-group">
            <input type="submit" value="Submit" class="btn btn-success" style="float: right">
        </div>
    </div>
</form>

