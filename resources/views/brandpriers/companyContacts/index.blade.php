@extends('layouts.main')

@section('content')
    <style>

    </style>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-header-title" >Contacts </div>
                <div class="card-toolbar" style="float: right">
                    <a id="add" class="btn btn-danger"> <i class="fa fa-plus"> </i>New Contacts</a>
                </div>

            </div>
            <input type="hidden" id="company_id" name="company_id" value="{{ $company_id }}">
            <div class="col-md-12">
                <label class="" style="padding: 10px 0px 0px 19px;"> Company Name : <b
                            style="color:#ffa800;">{{$companyName}}</b> </label>
            </div>
            <div class="card-body">

                <table class="table data-table" id="data-table"></table>
            </div>
        </div>
        @include('brandpriers.modal')


    </div>
@endsection

@section('script')
    @include('brandpriers.companyContacts.companyContactsJs')
@endsection
