@extends('layouts.main')

@section('content')
    <style>

    </style>
    <div class="container">

        <div class="card">
            <div class="card-header">
                <div class="card-header-title" >Tank's</div>
                <div class="card-toolbar" style="float: right">
                    <a id="addTank" class="btn btn-danger"> <i class="fa fa-plus"> </i>New Tank</a>
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
    @include('brandpriers.tanks.tanksJs')
@endsection
