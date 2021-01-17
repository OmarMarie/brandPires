@extends('layouts.main')

@section('content')
    <style>

    </style>
    <div class="container">

        <div class="card">
            <div class="card-header">
                <div class="card-header-title" >Gift's </div>
                <div class="card-toolbar" style="float: right">
                    <a id="add" class="btn btn-dark"> <i class="fa fa-plus"> </i> New Gift</a>
                </div>

            </div>

            <div class="card-body">
                <input type="hidden" id="campaign_id" name="campaign_id" value="{{$campaign_id}}">
                <table class="table data-table" id="data-table"></table>
            </div>
        </div>

        @include('brandpriers.modal')

    </div>
@endsection

@section('script')
    @include('brandpriers.gifts.giftsJs')
@endsection
