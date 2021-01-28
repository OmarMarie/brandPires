@extends('layouts.main')
@section('content')
    <style>
        .card_info {
            display: inline-block !important;
            width: 250px !important;
            border-radius: 5px;
            margin-right: 10px;
            padding: 10px;
            margin-bottom: 0px;
            background: #eef0f8 !important;
            text-align: start;
        }

        .gm-style-iw-d {
            overflow-y: auto;
            overflow-x: hidden !important;
        }

        .fa-count-chart {
            float: right;
            font-size: 40px;
            font-weight: bold;
        }

        .divs_fas {
            width: 50px;
            background: #fff;
            border-radius: 50%;
            height: 50px;
        }

        .divs_fas i {
            font-size: 24px;
            color: #000;
            padding: 13px;
        }

        .divs_title {
            padding: 10px 5px 5px 0px;
            text-align: left;
            color: #00000070;
            font-size: 12px;

        }

        .divs_number {
            padding: 2px 5px 10px 0px;
            text-align: left;
            width: 110px;
            color: #000;
            display: inline-block;
            font-weight: bold;
            font-size: 16px;
        }

        .divs_text {
            text-align: left;
            padding: 10px 5px;
            color: #00000070;
        }

        #myChart {
            background: rgb(121 121 121);;
            display: block;
            width: 750px;
            height: 400px;
            padding: 20px 20px;
            border-radius: 5px;
            margin-top: -40px;
        }

        #campaignsChart {
            background: rgb(238 240 248);
            display: block;
            width: 750px;
            height: 400px;
            padding: 20px 20px;
            border-radius: 5px;
        }

        #bubblesChart {
            background: rgb(238 240 248);
            display: block;
            width: 750px;
            height: 400px;
            padding: 20px 20px;
            border-radius: 5px;
        }


        .sub_titel {
            background: #383838;
            font-weight: 600;
            color: #fff;
            padding: 5px 10px;
            display: inline-block;
            border-radius: 5px;
        }

        .sub_titel2 {
            background: #e75858;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            margin-top: 20px;
            padding: 5px 10px;
            display: inline-block;
            border-radius: 5px;
        }

        sub_titel2:hover {
            background: #e87676 !important;
        }

        #map_campaigns_logs {
            height: 366px;
            display: inline-block;
            width: 100%;
            box-shadow: 0 0 30px 0 rgba(82, 63, 105, .05);
            border-radius: 5px;
        }


    </style>
    <div class="container animate__animated animate__fadeIn animate__slow">
        <!--begin::Dashboard-->
        <!--begin::Row-->
        <div class="row">
            <div class="col-md-12"
                 style="margin: 20px 0px; text-align: center; box-shadow: 0 0 30px 0 rgba(82, 63, 105, .05); margin-left: 15px;  border-radius: 5px; background: white">
                <div class="card-header border-0  py-5"
                     style="text-align: left; background: white;padding: 1.25rem !important;">
                    <h3 class="card-title font-weight-bolder">Reports</h3>
                </div>
                <div style="padding: 20px 20px;margin-top: -30px !important;">

                    <a href="{{ route('brands.index', app()->getLocale()) }}">
                        <div class="card_info">
                            <div class=""
                                 style="max-width: 70px; vertical-align: top; display: inline-block; margin-top: 10px;padding-left: 5px; ">
                                <div class="divs_fas" style="">
                                    <i class="far fa-copyright"></i>
                                </div>
                            </div>
                            <div class=""
                                 style="display: inline-block; width: calc(100% - 60px); padding: 0px 0px 0px 15px;">
                                <div class="divs_title">Brands</div>
                                <div style="text-align: left;">
                                    <div class="divs_number">{{$brands}}</div>
                                    <div style="display: inline-block;">
                                        @if($percentageBrands >= 0)
                                            <i class="fas fa-level-up-alt"
                                               style="display: inline-block; color: green;"></i>
                                        @else
                                            <i class="fas fa-level-down-alt"
                                               style="display: inline-block; color: red;"></i>
                                        @endif
                                        <div
                                            style="display: inline-block; {{($percentageBrands >= 0 ? 'color: green;' : 'color: red;')}}">{{$percentageBrands}}
                                            %
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                    <a href="#campaigns">
                        <div class="card_info">
                            <div class=""
                                 style="max-width: 70px; vertical-align: top; display: inline-block; margin-top: 10px;padding-left: 5px; ">
                                <div class="divs_fas" style="">
                                    <i class="fas fa-volleyball-ball"></i>
                                </div>
                            </div>
                            <div class=""
                                 style="display: inline-block; width: calc(100% - 60px); padding: 0px 0px 0px 15px;">
                                <div class="divs_title">Campaigns</div>
                                <div style="text-align: left;">
                                    <div class="divs_number">{{$campaigns}}</div>
                                    <div style="display: inline-block;">
                                        @if($percentageCampaign >= 0)
                                            <i class="fas fa-level-up-alt"
                                               style="display: inline-block; color: green;"></i>
                                        @else
                                            <i class="fas fa-level-down-alt"
                                               style="display: inline-block; color: red;"></i>
                                        @endif
                                        <div
                                            style="display: inline-block; {{($percentageCampaign >= 0 ? 'color: green;' : 'color: red;')}}">{{$percentageBrands}}
                                            %
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                    <div class="card_info" id="add">
                        <div class=""
                             style="max-width: 70px; vertical-align: top; display: inline-block; margin-top: 10px;padding-left: 5px; ">
                            <div class="divs_fas" style="">
                                <i class="fas fa-biking"></i>
                            </div>
                        </div>
                        <div class=""
                             style="display: inline-block; width: calc(100% - 60px); padding: 0px 0px 0px 15px;">
                            <div class="divs_title">Players</div>
                            <div style="text-align: left;">
                                <div class="divs_number">{{$players}}</div>
                                <div style="display: inline-block;">
                                    @if($percentageBubblesPlayer >= 0)
                                        <i class="fas fa-level-up-alt" style="display: inline-block; color: green;"></i>
                                    @else
                                        <i class="fas fa-level-down-alt" style="display: inline-block; color: red;"></i>
                                    @endif
                                    <div
                                        style="display: inline-block; {{($percentageBubblesPlayer >= 0 ? 'color: green;' : 'color: red;')}}">{{$percentageBrands}}
                                        %
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{--

                       <div id="add" class="col-md-2  card card-custom bg-gray-100 card-stretch gutter-b card_info "
                            style="cursor: pointer">
                           <div class="divs_fas" style=" background:#f9b32f;">
                               <i class="fas fa-biking "></i>
                           </div>
                           <div class="divs_title">Players</div>
                           <div class="divs_number">{{$players}}</div>
                           <div class="progress">
                               <div class="progress-bar" role="progressbar"
                                    style="width: {{$percentageBubblesPlayer}}%; background:#f9b32f;"
                                    aria-valuenow="{{ abs($percentageBubblesPlayer)}}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                           </div>
                           <div class="divs_text"> {{($percentageBubblesPlayer > 0 ? 'Best' : 'Better')}} then last week
                               ({{ abs($percentageBubblesPlayer)}}%)
                           </div>
                       </div>--}}

                </div>
            </div>
            <div class="col-md-12" id="campaigns"
                 style="margin: 20px 0px; text-align: center; box-shadow: 0 0 30px 0 rgba(82, 63, 105, .05); margin-left: 15px;  border-radius: 5px; padding: 0px !important;">
                <div class="card-header border-0  py-5 "
                     style="text-align: left;  background: white;padding: 1.25rem !important; ">
                    <h3 class="card-title font-weight-bolder ">Campaigns</h3>
                </div>
                <div style="padding: 20px 20px;margin-top: -30px !important; background: #fff">
                    <div id="map_campaigns_logs"
                         marker_code="var locations =[{{$marker_code}}]">
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"
                 style="margin: 20px 0px;  box-shadow: 0 0 30px 0 rgba(82, 63, 105, .05); margin-left: 15px;  border-radius: 5px; background: white; text-align: center">
                <div class="row">
                    <div class="col-md-6 " style="padding-bottom: 20px;">
                        <div class="card-header border-0  py-5" style="background: white; padding: 1.25rem !important;">
                            <h3 class="card-title font-weight-bolder ">Campaigns</h3>
                        </div>
                        <div class="card-body p-0 position-relative overflow-hidden">
                            <canvas id="campaignsChart" width="750" height="500"
                                    class="chartjs-render-monitor"></canvas>
                        </div>

                    </div>
                    <div class="col-md-6 " style="padding-bottom: 20px;">
                        <div class="card-header border-0  py-5" style="background: white; padding: 1.25rem !important;">
                            <h3 class="card-title font-weight-bolder ">Bubbles</h3>
                        </div>
                        <div class="card-body p-0 position-relative overflow-hidden">
                            <canvas id="bubblesChart" width="750" height="500" class="chartjs-render-monitor"></canvas>
                        </div>

                    </div>

                </div>
            </div>


            <div class="col-md-12"
                 style=" margin: 30px 0px; text-align: center; box-shadow: 0 0 30px 0 rgba(82, 63, 105, .05); margin-left: 15px;  border-radius: 5px; padding: 20px !important; background: white;  ">
                <div class="row">
                    <div class="col-md-6 ">
                        <div class=" " style="width:75%; display:block;  width: 75%;
    display: block;
    background: #000000c7;
    color: #fff;
    font-weight: bold;
    font-size: 20px;
    padding: 25px 0px;
    border-radius: 5px;
    -webkit-box-shadow: 4px 13px 13px -11px rgba(0,0,0,0.75);
    -moz-box-shadow: 4px 13px 13px -11px rgba(0,0,0,0.75);
    box-shadow: 4px 13px 13px -11px rgba(0,0,0,0.75);
    margin-top: -40px;">Sales
                        </div>
                        <div class="row" style="text-align: left; padding: 40px 30px;">
                            <div class="col-md-6 ">
                                <div class="sub_titel"> Date Range</div>
                            </div>
                            <div class="col-md-6">
                                <div style="padding-left: 10px; font-size: 16px;">Total Sales: <span
                                        style="font-weight: bold;"> {{number_format($salesSum, 2)}} <i class="fas fa-dollar-sign"
                                                                                                       style="color: #82c91e;"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="text-align: left; padding: 40px 30px;">
                            <div class="col-md-12">
                                <div class="sub_titel"> Custom Date</div>
                                <label style="display: block; padding-top: 20px;">Date</label>
                                <div class="input-daterange input-group" id="kt_datepicker_5">
                                    <input type="text" class="form-control" name="start"
                                           placeholder="From Date" autocomplete="off">
                                    <div class="input-group-append">
                                                    <span class="input-group-text"
                                                          style="background:#383838 !important"><i
                                                            class="fa fa-ellipsis-h"
                                                            style="color: #fff !important;"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="end"
                                           placeholder="To Date" autocomplete="off">
                                </div>
                            </div>
                            <div style="text-align: right;width: 100%;">
                                <div class="sub_titel2"> Custom Date</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <canvas id="myChart" width="750" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xxl-4 order-1 order-xxl-2">
                <!--begin::List Widget 3-->
                <div class="card card-custom card-stretch gutter-b" style="box-shadow: none;">
                    <!--begin::Header-->
                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bolder text-dark">Representative</h3>

                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body ">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-10">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40 symbol-light-success mr-5">
														<span class="symbol-label">
															<img src="{{asset('assets/media/svg/009-boy-4.svg')}}"
                                                                 class="h-75 align-self-end" alt="">
														</span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Text-->
                            <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Ricky Hunt</a>
                                <span class="text-muted">Brand:brand1 ,brand2 </span>
                            </div>
                            <!--end::Text-->
                            <!--begin::Dropdown-->
                            <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title=""
                                 data-placement="left" data-original-title="Quick actions">
                                <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="ki ki-bold-more-hor"></i>
                                </a>
                                <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
                                    <!--begin::Navigation-->
                                    <ul class="navi navi-hover">
                                        <li class="navi-header font-weight-bold py-4">
                                            <span class="font-size-lg">Choose Label:</span>
                                            <i class="flaticon2-information icon-md text-muted" data-toggle="tooltip"
                                               data-placement="right" title=""
                                               data-original-title="Click to learn more..."></i>
                                        </li>
                                        <li class="navi-separator mb-3 opacity-70"></li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
																		<span class="navi-text">
																			<span
                                                                                class="label label-xl label-inline label-light-success">Customer</span>
																		</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
																		<span class="navi-text">
																			<span
                                                                                class="label label-xl label-inline label-light-danger">Partner</span>
																		</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
																		<span class="navi-text">
																			<span
                                                                                class="label label-xl label-inline label-light-warning">Suplier</span>
																		</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
																		<span class="navi-text">
																			<span
                                                                                class="label label-xl label-inline label-light-primary">Member</span>
																		</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
																		<span class="navi-text">
																			<span
                                                                                class="label label-xl label-inline label-light-dark">Staff</span>
																		</span>
                                            </a>
                                        </li>
                                        <li class="navi-separator mt-3 opacity-70"></li>
                                        <li class="navi-footer py-4">
                                            <a class="btn btn-clean font-weight-bold btn-sm" href="#">
                                                <i class="ki ki-plus icon-sm"></i>Add new</a>
                                        </li>
                                    </ul>
                                    <!--end::Navigation-->
                                </div>
                            </div>
                            <!--end::Dropdown-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::List Widget 3-->
            </div>

            <div class="col-lg-12 col-xxl-4 order-1 order-xxl-2">
                <!--begin::List Widget 8-->
                <div class="card card-custom card-stretch gutter-b " style="box-shadow: none;">
                    <!--begin::Header-->
                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bolder text-dark">Brands</h3>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Item-->
                        <div class="mb-10">
                            <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-45 symbol-light mr-5">
															<span class="symbol-label">
																<img src="{{asset('assets/media/svg/009-boy-4.svg')}}"
                                                                     class="h-50 align-self-center" alt="">
															</span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Text-->
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#"
                                       class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">Top
                                        Authors</a>
                                    <span class="text-muted font-weight-bold">5 day ago</span>
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Desc-->
                            <p class="text-dark-50 m-0 pt-5 font-weight-normal">A brief write up about the top Authors
                                that fits within this section</p>
                            <!--end::Desc-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end: Card-->
                <!--end::List Widget 8-->
            </div>
        </div>
        <!--end::Row-->

        <!--end::Dashboard-->
    </div>
    @include('brandpriers.modal')
@endsection

@section('script')
    @include('brandpriers.dashboard.js')
@endsection
