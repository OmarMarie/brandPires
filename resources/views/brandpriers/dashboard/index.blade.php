@extends('layouts.main')
@section('content')
    <style>
        .card_info {
            display: inline-block !important;
            height: 140px !important;
            max-width: 22% !important;
            margin-right: 10px;
            margin-bottom: 0px;
            background: white !important;

        }

        .fa-count-chart {
            float: right;
            font-size: 40px;
            font-weight: bold;
        }

        .divs_fas {
            position: absolute;
            left: 4px;
            top: -15px;
            -webkit-box-shadow: 10px 10px 22px 0px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 10px 10px 22px 0px rgba(0, 0, 0, 0.75);
            box-shadow: 10px 10px 22px 0px rgba(0, 0, 0, 0.75);
            border-radius: 5px;
            width: 60px;
            height: 60px;
        }

        .divs_fas i {
            font-size: 30px;
            color: #fff;
            padding-top: 13px;
        }

        .divs_title {
            padding: 10px 5px 10px 30px;
            text-align: right;
            color: #00000070;
            font-weight: bold;
            font-size: 12px;
        }

        .divs_number {
            padding: 10px 5px 10px 30px;
            text-align: right;
            font-weight: bold;
            font-size: 16px;
        }

        .divs_text {
            text-align: left;
            padding: 10px 5px;
            color: #00000070;
        }

        #myChart {
            background: rgb(50, 79, 169);
            background: linear-gradient(207deg, rgba(50, 79, 169, 1) 0%, rgba(57, 128, 199, 0.9724264705882353) 35%, rgba(64, 180, 236, 0.7903536414565826) 100%);
            display: block;
            width: 750px;
            height: 400px;
            padding: 20px 20px;
            border-radius: 5px;
            margin-top: -40px;
        }

        .sub_titel {
            background: #7dd1ff;
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

        .background {
            background: rgb(50, 79, 169);
            background: linear-gradient(160deg, rgba(50, 79, 169, 1) 0%, rgba(57, 128, 199, 0.9724264705882353) 35%, rgba(64, 180, 236, 0.7903536414565826) 100%);
        }

    </style>
    <div class="container animate__animated animate__fadeIn animate__slow">
        <!--begin::Dashboard-->
        <!--begin::Row-->
        <div class="row">
            <div class="col-md-12"
                 style="margin: 20px 0px; text-align: center; box-shadow: 0 0 30px 0 rgba(82, 63, 105, .05); margin-left: 15px;  border-radius: 5px; padding: 0px !important;">
                <div class="card-header border-0  py-5 background" style="text-align: left;">
                    <h3 class="card-title font-weight-bolder text-white">Reports</h3>
                </div>
                <div style="padding: 20px 20px;margin-top: -30px !important;">

                    <div class="col-md-2  card card-custom bg-gray-100 card-stretch gutter-b card_info">
                        <div class="divs_fas" style=" background:#4385f5;">
                            <i class="far fa-copyright"></i>
                        </div>
                        <div class="divs_title">Brands</div>
                        <div class="divs_number">{{$brands}}</div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar"
                                 style="width: {{$percentageBrands}}%; background:#4385f5;"
                                 aria-valuenow="{{ abs($percentageBrands)}}" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                        <div class="divs_text">{{($percentageBrands > 0 ? 'Best' : 'Better')}} then last week
                            ({{abs($percentageBrands)}}%)
                        </div>
                    </div>

                    <div class="col-md-2  card card-custom bg-gray-100 card-stretch gutter-b card_info">
                        <div class="divs_fas" style=" background:#12827c;">
                            <i class="fas fa-volleyball-ball"></i>
                        </div>
                        <div class="divs_title">Campaigns</div>
                        <div class="divs_number">{{$campaigns}}</div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar"
                                 style="width: {{$percentageCampaign}}%; background:#12827c;"
                                 aria-valuenow="{{ abs($percentageCampaign)}}" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                        <div class="divs_text"> {{($percentageCampaign > 0 ? 'Best' : 'Better')}} then last week
                            ({{ abs($percentageCampaign)}}%)
                        </div>
                    </div>

                    {{--<div class="col-md-2  card card-custom bg-gray-100 card-stretch gutter-b card_info">
                        <div class="divs_fas" style=" background:#f6555e;">
                            <i class="fas fa-soap"></i>
                        </div>
                        <div class="divs_title">Bubbles Transfer</div>
                        <div class="divs_number">{{$bubbles_transfer}}</div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar"
                                 style="width: {{$percentageBubblesTransfer}}%; background:#f6555e;"
                                 aria-valuenow="{{ abs($percentageBubblesTransfer)}}" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                        <div class="divs_text"> {{($percentageBubblesTransfer > 0 ? 'Best' : 'Better')}} then last week
                            ({{ abs($percentageBubblesTransfer)}}%)
                        </div>
                    </div>--}}

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
                    </div >

                </div>
            </div>
            <div class="col-md-12"
                 style="margin: 20px 0px; text-align: center; box-shadow: 0 0 30px 0 rgba(82, 63, 105, .05); margin-left: 15px;  border-radius: 5px; padding: 0px !important;">
                <div class="card-header border-0  py-5 background" style="text-align: left;">
                    <h3 class="card-title font-weight-bolder text-white">Campaigns</h3>
                </div>
                <div style="padding: 20px 20px;margin-top: -30px !important;">
                    <div id="map_campaigns_logs"
                         marker_code="var locations =[{{$marker_code}}]">
                    </div>

                </div>
            </div>

            <div class="col-lg-6 col-xxl-6">
                <!--begin::Mixed Widget 1-->
                <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0  py-5 background">
                        <h3 class="card-title font-weight-bolder text-white">Campaigns</h3>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body p-0 position-relative overflow-hidden">
                        <!--begin::Chart-->
                        <div class="card-rounded-bottom background"
                             style="height: 60px; min-height: 60px;">
                        </div>
                        <!--end::Chart-->

                        <!--begin::Stats-->
                        <div class="card-spacer mt-n25">
                            <!--begin::Row-->
                            <div class="row m-0">
                                <div class="col bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7">
                                    <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2"><span
                                                class="fa-count-chart"> {{$activeCampaigns}}</span><i
                                                class="fa fa-check fa-chart" style="color: #ffa800 "></i></span> <a
                                            href="#" class="text-warning font-weight-bold font-size-h6">
                                        Active
                                    </a>
                                </div>
                                <div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
                                    <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2"><span
                                                class="fa-count-chart"> {{$inActiveCampaigns}}</span><i
                                                class="fa fa-pause fa-chart" style="color: #3699ff "></i></span> <a
                                            href="#" class="text-primary font-weight-bold font-size-h6 mt-2">
                                        InActive
                                    </a>
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row m-0">
                                <div class="col bg-light-danger px-6 py-8 rounded-xl mr-7">
                                    <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2"><span
                                                class="fa-count-chart"> {{ $stoppedCampaigns}}</span><i
                                                class="fa fa-phone fa-chart"
                                                style="color: #ec0c24 "></i></span>
                                    <a href="#" class="text-danger font-weight-bold font-size-h6 mt-2">
                                        Stopped
                                    </a>
                                </div>
                                <div class="col bg-light-success px-6 py-8 rounded-xl">
                                    <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2"><span
                                                class="fa-count-chart"> {{$finishedCampaigns}}</span><i
                                                class="fa fa-check fa-chart"
                                                style="color: #1bc5bd "></i></span>
                                    <a href="#" class="text-success font-weight-bold font-size-h6 mt-2">
                                        Finished
                                    </a>
                                </div>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Stats-->
                        <div class="resize-triggers">
                            <div class="expand-trigger">
                                <div style="width: 414px; height: 461px;"></div>
                            </div>
                            <div class="contract-trigger"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 1-->
            </div>
            <div class="col-lg-6 col-xxl-6">
                <!--begin::Mixed Widget 1-->
                <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 py-5 background" style="">
                        <h3 class="card-title font-weight-bolder text-white">Bubbles</h3>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body p-0 position-relative overflow-hidden">
                        <!--begin::Chart-->
                        <div class="card-rounded-bottom background"
                             style="height: 60px; min-height: 60px; ">
                        </div>
                        <!--end::Chart-->

                        <!--begin::Stats-->
                        <div class="card-spacer mt-n25">
                            <!--begin::Row-->
                            <div class="row m-0">
                                <div class="col bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7">
                                    <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2"><span
                                                class="fa-count-chart"> 1000</span><i
                                                class="fa fa-check fa-chart" style="color: #ffa800 "></i></span> <a
                                            href="#" class="text-warning font-weight-bold font-size-h6">
                                        Active
                                    </a>
                                </div>
                                <div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
                                    <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2"><span
                                                class="fa-count-chart"> 1000</span><i
                                                class="fa fa-pause fa-chart" style="color: #3699ff "></i></span> <a
                                            href="#" class="text-primary font-weight-bold font-size-h6 mt-2">
                                        InActive
                                    </a>
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row m-0">
                                <div class="col bg-light-danger px-6 py-8 rounded-xl mr-7">
                                    <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2"><span
                                                class="fa-count-chart"> 1000</span><i class="fa fa-phone fa-chart"
                                                                                      style="color: #ec0c24 "></i></span>
                                    <a href="#" class="text-danger font-weight-bold font-size-h6 mt-2">
                                        Stopped
                                    </a>
                                </div>
                                <div class="col bg-light-success px-6 py-8 rounded-xl">
                                    <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2"><span
                                                class="fa-count-chart"> 1000</span><i class="fa fa-check fa-chart"
                                                                                      style="color: #1bc5bd "></i></span>
                                    <a href="#" class="text-success font-weight-bold font-size-h6 mt-2">
                                        Finished
                                    </a>
                                </div>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Stats-->
                        <div class="resize-triggers">
                            <div class="expand-trigger">
                                <div style="width: 414px; height: 461px;"></div>
                            </div>
                            <div class="contract-trigger"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 1-->
            </div>
            <div class="col-md-12"
                 style=" margin: 30px 0px; text-align: center; box-shadow: 0 0 30px 0 rgba(82, 63, 105, .05); margin-left: 15px;  border-radius: 5px; padding: 20px !important; background: white;  ">
                <div class="row">
                    <div class="col-md-6 ">
                        <div class=" background" style="width:75%; display:block;  color: #fff;
                         font-size: 20px; padding: 25px 0px; border-radius:5px;
                         -webkit-box-shadow: 4px 13px 13px -11px rgba(0,0,0,0.75);
                         -moz-box-shadow: 4px 13px 13px -11px rgba(0,0,0,0.75);
                         box-shadow: 4px 13px 13px -11px rgba(0,0,0,0.75); margin-top: -40px">Sales
                        </div>
                        <div class="row" style="text-align: left; padding: 40px 30px;">
                            <div class="col-md-6 ">
                                <div class="sub_titel"> Date Range</div>
                            </div>
                            <div class="col-md-6">
                                <div style="padding-left: 10px; font-size: 16px;">Total Sales: <span
                                            style="font-weight: bold;"> 500$</span></div>
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
                                                          style="background: #f9b32f !important;"><i
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
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bolder text-dark">Representative</h3>

                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-2">
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
																			<span class="label label-xl label-inline label-light-success">Customer</span>
																		</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
																		<span class="navi-text">
																			<span class="label label-xl label-inline label-light-danger">Partner</span>
																		</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
																		<span class="navi-text">
																			<span class="label label-xl label-inline label-light-warning">Suplier</span>
																		</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
																		<span class="navi-text">
																			<span class="label label-xl label-inline label-light-primary">Member</span>
																		</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
																		<span class="navi-text">
																			<span class="label label-xl label-inline label-light-dark">Staff</span>
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
            {{-- <div class="col-lg-6 col-xxl-4 order-1 order-xxl-2">
                 <!--begin::List Widget 4-->
                 <div class="card card-custom card-stretch gutter-b">
                     <!--begin::Header-->
                     <div class="card-header border-0">
                         <h3 class="card-title font-weight-bolder text-dark">Todo</h3>
                     </div>
                     <!--end::Header-->
                     <!--begin::Body-->
                     <div class="card-body pt-2">
                         <!--begin::Item-->
                         <div class="d-flex align-items-center">
                             <!--begin::Bullet-->
                             <span class="bullet bullet-bar bg-success align-self-stretch"></span>
                             <!--end::Bullet-->
                             <!--begin::Checkbox-->
                             <label class="checkbox checkbox-lg checkbox-light-success checkbox-inline flex-shrink-0 m-0 mx-4">
                                 <input type="checkbox" name="select" value="1">
                                 <span></span>
                             </label>
                             <!--end::Checkbox-->
                             <!--begin::Text-->
                             <div class="d-flex flex-column flex-grow-1">
                                 <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">Create
                                     FireStone Logo</a>
                                 <span class="text-muted font-weight-bold">Due in 2 Days</span>
                             </div>
                             <!--end::Text-->
                             <!--begin::Dropdown-->
                             <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title=""
                                  data-placement="left" data-original-title="Quick actions">
                                 <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                     <i class="ki ki-bold-more-hor"></i>
                                 </a>
                                 <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right" style="">
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
                                                                             <span class="label label-xl label-inline label-light-success">Customer</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-danger">Partner</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-warning">Suplier</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-primary">Member</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-dark">Staff</span>
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
                         <!--end:Item-->
                         <!--begin::Item-->
                         <div class="d-flex align-items-center mt-10">
                             <!--begin::Bullet-->
                             <span class="bullet bullet-bar bg-primary align-self-stretch"></span>
                             <!--end::Bullet-->
                             <!--begin::Checkbox-->
                             <label class="checkbox checkbox-lg checkbox-light-primary checkbox-inline flex-shrink-0 m-0 mx-4">
                                 <input type="checkbox" value="1">
                                 <span></span>
                             </label>
                             <!--end::Checkbox-->
                             <!--begin::Text-->
                             <div class="d-flex flex-column flex-grow-1">
                                 <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">Stakeholder
                                     Meeting</a>
                                 <span class="text-muted font-weight-bold">Due in 3 Days</span>
                             </div>
                             <!--end::Text-->
                             <!--begin::Dropdown-->
                             <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title=""
                                  data-placement="left" data-original-title="Quick actions">
                                 <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                     <i class="ki ki-bold-more-hor"></i>
                                 </a>
                                 <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right" style="">
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
                                                                             <span class="label label-xl label-inline label-light-success">Customer</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-danger">Partner</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-warning">Suplier</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-primary">Member</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-dark">Staff</span>
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
                         <!--begin::Item-->
                         <div class="d-flex align-items-center mt-10">
                             <!--begin::Bullet-->
                             <span class="bullet bullet-bar bg-warning align-self-stretch"></span>
                             <!--end::Bullet-->
                             <!--begin::Checkbox-->
                             <label class="checkbox checkbox-lg checkbox-light-warning checkbox-inline flex-shrink-0 m-0 mx-4">
                                 <input type="checkbox" value="1">
                                 <span></span>
                             </label>
                             <!--end::Checkbox-->
                             <!--begin::Text-->
                             <div class="d-flex flex-column flex-grow-1">
                                 <a href="#"
                                    class="text-dark-75 text-hover-primary font-size-sm font-weight-bold font-size-lg mb-1">Scoping
                                     &amp; Estimations</a>
                                 <span class="text-muted font-weight-bold">Due in 5 Days</span>
                             </div>
                             <!--end::Text-->
                             <!--begin: Dropdown-->
                             <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title=""
                                  data-placement="left" data-original-title="Quick actions">
                                 <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                     <i class="ki ki-bold-more-hor"></i>
                                 </a>
                                 <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right" style="">
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
                                                                             <span class="label label-xl label-inline label-light-success">Customer</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-danger">Partner</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-warning">Suplier</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-primary">Member</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-dark">Staff</span>
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
                         <!--begin::Item-->
                         <div class="d-flex align-items-center mt-10">
                             <!--begin::Bullet-->
                             <span class="bullet bullet-bar bg-info align-self-stretch"></span>
                             <!--end::Bullet-->
                             <!--begin::Checkbox-->
                             <label class="checkbox checkbox-lg checkbox-light-info checkbox-inline flex-shrink-0 m-0 mx-4">
                                 <input type="checkbox" value="1">
                                 <span></span>
                             </label>
                             <!--end::Checkbox-->
                             <!--begin::Text-->
                             <div class="d-flex flex-column flex-grow-1">
                                 <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">Sprint
                                     Showcase</a>
                                 <span class="text-muted font-weight-bold">Due in 1 Day</span>
                             </div>
                             <!--end::Text-->
                             <!--begin::Dropdown-->
                             <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title=""
                                  data-placement="left" data-original-title="Quick actions">
                                 <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                     <i class="ki ki-bold-more-hor"></i>
                                 </a>
                                 <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right" style="">
                                     <!--begin::Navigation-->
                                     <ul class="navi navi-hover py-5">
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-icon">
                                                                             <i class="flaticon2-drop"></i>
                                                                         </span>
                                                 <span class="navi-text">New Group</span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-icon">
                                                                             <i class="flaticon2-list-3"></i>
                                                                         </span>
                                                 <span class="navi-text">Contacts</span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-icon">
                                                                             <i class="flaticon2-rocket-1"></i>
                                                                         </span>
                                                 <span class="navi-text">Groups</span>
                                                 <span class="navi-link-badge">
                                                                             <span class="label label-light-primary label-inline font-weight-bold">new</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-icon">
                                                                             <i class="flaticon2-bell-2"></i>
                                                                         </span>
                                                 <span class="navi-text">Calls</span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-icon">
                                                                             <i class="flaticon2-gear"></i>
                                                                         </span>
                                                 <span class="navi-text">Settings</span>
                                             </a>
                                         </li>
                                         <li class="navi-separator my-3"></li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-icon">
                                                                             <i class="flaticon2-magnifier-tool"></i>
                                                                         </span>
                                                 <span class="navi-text">Help</span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-icon">
                                                                             <i class="flaticon2-bell-2"></i>
                                                                         </span>
                                                 <span class="navi-text">Privacy</span>
                                                 <span class="navi-link-badge">
                                                                             <span class="label label-light-danger label-rounded font-weight-bold">5</span>
                                                                         </span>
                                             </a>
                                         </li>
                                     </ul>
                                     <!--end::Navigation-->
                                 </div>
                             </div>
                             <!--end::Dropdown-->
                         </div>
                         <!--end::Item-->
                         <!--begin::Item-->
                         <div class="d-flex align-items-center mt-10">
                             <!--begin::Bullet-->
                             <span class="bullet bullet-bar bg-danger align-self-stretch"></span>
                             <!--end::Bullet-->
                             <!--begin::Checkbox-->
                             <label class="checkbox checkbox-lg checkbox-light-danger checkbox-inline flex-shrink-0 m-0 mx-4">
                                 <input type="checkbox" value="1">
                                 <span></span>
                             </label>
                             <!--end::Checkbox:-->
                             <!--begin::Title-->
                             <div class="d-flex flex-column flex-grow-1">
                                 <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">Project
                                     Retro</a>
                                 <span class="text-muted font-weight-bold">Due in 12 Days</span>
                             </div>
                             <!--end::Text-->
                             <!--begin: Dropdown-->
                             <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title=""
                                  data-placement="left" data-original-title="Quick actions">
                                 <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                     <i class="ki ki-bold-more-hor"></i>
                                 </a>
                                 <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right" style="">
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
                                                                             <span class="label label-xl label-inline label-light-success">Customer</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-danger">Partner</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-warning">Suplier</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-primary">Member</span>
                                                                         </span>
                                             </a>
                                         </li>
                                         <li class="navi-item">
                                             <a href="#" class="navi-link">
                                                                         <span class="navi-text">
                                                                             <span class="label label-xl label-inline label-light-dark">Staff</span>
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
                 <!--end:List Widget 4-->
             </div>--}}
            <div class="col-lg-12 col-xxl-4 order-1 order-xxl-2">
                <!--begin::List Widget 8-->
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bolder text-dark">Brands</h3>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0">
                        <!--begin::Item-->
                        <div class="mb-10">
                            <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-45 symbol-light mr-5">
															<span class="symbol-label">
																<img src="/metronic/theme/html/demo1/dist/assets/media/svg/misc/006-plurk.svg"
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