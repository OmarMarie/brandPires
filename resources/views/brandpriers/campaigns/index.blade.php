@extends('layouts.main')

@section('content')
    <style>

    </style>
    <div class="container">

        <div class="card">
            <div class="card-header">
                <div class="card-header-title" >Campaigns </div>
                <div class="card-toolbar" style="float: right">
                    <a id="add" class="btn btn-dark"> <i class="fa fa-plus"> </i> New Campaign</a>
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
