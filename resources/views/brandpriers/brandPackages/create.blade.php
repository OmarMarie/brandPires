<form action="{{ route('storeBrandPackages', app()->getLocale()) }}" method="POST" id="userForm">

    @csrf
    <input type="hidden" name="brand_id" value="{{ $brand_id }}">

    <div class="row">
        <div class="col-md-6 form-group">
            <label> Company Packages</label>
            <select name="companyPackages_id" class="form-control">
                <option value="" selected disabled>Select Company Packages</option>
                @foreach($companyPackages  as $companyPackage)
                    <option value="{{ $companyPackage->id }}">{{ "Cost: ".$companyPackage->cost ." , Number Bubbles: ".$companyPackage->number_bubbles }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12 form-group">
            <input type="submit" value="Submit" class="btn btn-dark" style="float: right">
        </div>
    </div>
</form>

