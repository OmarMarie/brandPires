@extends('layouts.main')

@section('content')
    <style>

    </style>
    <div class="container">

        <div class="card">
            <div class="card-header">
                <div class="card-header-title" >Campaign's </div>
            </div>

            <div class="card-body">
                <table class="table data-table" id="data-table"></table>
            </div>
        </div>

        @include('brandpriers.modal')

    </div>
@endsection

@section('script')
    @include('brandpriers.logCampaingns.logCampaignsJs')
@endsection
