@extends('layouts.main')

@section('content')
    <style>

    </style>
    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>Campaigns</b>
                <div class="card-toolbar" style="float: right">

                    <a id="add" class="btn btn-primary font-weight-bolder">
	<span class="svg-icon svg-icon-md">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
             viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <circle fill="#000000" cx="9" cy="15" r="6"></circle>
        <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
              fill="#000000" opacity="0.3"></path>
    </g>
</svg></span>New Campaign</a>
                </div>

            </div>
            <input type="hidden" id="brand_id" name="brand_id" value="{{ $brand_id }}">
            <input type="hidden" id="package_id" name="package_id" value="{{ $package_logs_id}}">
            <div class="col-md-12">
                <label class="" style="padding: 10px 0px 0px 19px;"> Brand Name : <b
                            style="color:#ffa800;">{{$brandName}}</b> </label>
            </div>
            <div class="col-md-12">
                <label class="" style="padding: 10px 0px 0px 19px;"> package : <b
                            style="color:#ffa800;">Cost: {{$package->cost}} - Number Bubbles: {{$package->number_bubbles}}</b> </label>
            </div>
            <div class="card-body">

                <table class="table data-table" id="data-table"></table>
            </div>
        </div>
        @include('brandpriers.modal')


    </div>
@endsection

@section('script')
    @include('brandpriers.campaigns.campaignsJs')
@endsection