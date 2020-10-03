@if(isset($companyPackage))
    <form action="{{ route('companyPackages.update', [app()->getLocale(),$companyPackage]) }}" method="POST" id="userForm">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('companyPackages.store', app()->getLocale()) }}" method="POST" id="userForm">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Price</label>
                        <input type="text" class="form-control" name="cost" placeholder="Price"
                               @if(isset($companyPackage)) value="{{ $companyPackage->cost }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Number of bubbles</label>
                        <input type="text" class="form-control" name="number_bubbles" placeholder="Number of bubbles"
                               @if(isset($companyPackage)) value="{{ $companyPackage->number_bubbles }}" @endif>
                    </div>

                    <div class="col-md-6 form-group">
                            <label>Location Distribution</label>
                        <input type="text" class="form-control" name="distribution" placeholder="Location Distribution"
                               @if(isset($companyPackage)) value="{{ $companyPackage->distribution }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Bonus</label>
                        <input type="text" class="form-control" name="bonus" placeholder="Bonus"
                               @if(isset($companyPackage)) value="{{ $companyPackage->bonus }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Bubble Expiry</label>
                        <input type="text" class="form-control" name="bubble_expiry" placeholder="Bubble Expiry"
                               @if(isset($companyPackage)) value="{{ $companyPackage->bubble_expiry }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Top price</label>
                        <input type="text" class="form-control" name="top_up_cos" placeholder="Top price"
                               @if(isset($companyPackage)) value="{{ $companyPackage->top_up_cos }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Average company Packages</label>
                        <input type="text" class="form-control" name="average_players" placeholder="Average companyPackages"
                               @if(isset($companyPackage)) value="{{ $companyPackage->average_players }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Added Gift Capabilities</label>
                        <input type="text" class="form-control" name="added_gift_capabilities"
                               placeholder="Added Gift Capabilities"
                               @if(isset($companyPackage)) value="{{ $companyPackage->added_gift_capabilities }}" @endif>
                    </div>

                    <div class="col-md-12 form-group">
                        <input type="submit" value="Submit" class="btn btn-success" style="float: right">
                    </div>
                </div>
            </form>
