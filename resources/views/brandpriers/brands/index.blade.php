@extends('layouts.main')

@section('content')
    <style>

    </style>
    <div class="container">

        <div class="card">
            <div class="card-header">
                <div class="card-header-title" > Brands </div>
                <div class="card-toolbar" style="float: right">
                    <a id="add" class="btn btn-danger"> <i class="fa fa-plus"> </i> New Brand</a>
                </div>
            </div>

            <div class="card-body">
                <table class="table data-table" id="data-table"></table>
            </div>
        </div>
        @include('brandpriers.modal')


    </div>
@endsection

@section('script')
    @include('brandpriers.brands.brandsJs')
@endsection
