@extends('layouts.main')

@section('content')
    <style>
        #myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
            max-width: 300px;
            max-height: 200px;
        }

        #myImg:hover {
            opacity: 0.7;
        }

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 10000000; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.5); /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 100%;
            max-width: 1000px;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            font-weight: bold;
            max-width: 700px;
            text-align: center;
            color: #000;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content, #caption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {
                -webkit-transform: scale(0)
            }
            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }
            to {
                transform: scale(1)
            }
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            background: #fff;
            padding: 5px;
            border-radius: 30px;
            right: 35px;
            color: #f10010;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bb0002;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }
    </style>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-header-title" >Attachments</div>
                <div class="card-toolbar" style="float: right">
                    <a id="add" class="btn btn-danger"> <i class="fa fa-edit"> </i> Edit Attachments</a>
                </div>

            </div>
            <input type="hidden" id="brand_id" name="brand_id" value="{{ $brand_id }}">
            <div class="col-md-12">
                <label class="" style="padding: 10px 0px 0px 19px;"> Brand Name : <b
                            style="color:#ffa800;">{{$attachments->brand_name}}</b> </label>
            </div>
            <div class="card-body">
                @if(isset($attachments))
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label style=" display: block !important;">Contract</label>
                            @if(strstr($attachments->commercial_registration ,'pdf'))
                                <a href="{{asset('/attachments/brand/'.$attachments->contract.'')}}"
                                   target="_blank">
                                    @endif
                                    <img class="{{!strstr($attachments->contract ,'pdf') ? "myImg":"" }}"
                                         id="myImg"
                                         @if(!strstr($attachments->contract ,'pdf'))
                                         src="{{asset('/attachments/brand/'.$attachments->contract.'')}}"
                                         @else
                                         src="{{asset('/assets/images/default/pdf.png')}}"
                                         @endif alt="Commercial Registration"/>
                                    @if(strstr($attachments->contract ,'pdf'))
                                </a>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label style=" display: block !important;">Ad Approval</label>
                            @if(strstr($attachments->ad_approval ,'pdf'))
                                <a href="{{asset('/attachments/brand/'.$attachments->ad_approval.'')}}"
                                   target="_blank">
                                    @endif
                                    <img class="{{!strstr($attachments->ad_approval ,'pdf') ? "myImg":"" }}" id="myImg"
                                         @if(!strstr($attachments->ad_approval ,'pdf'))
                                         src="{{asset('/attachments/brand/'.$attachments->ad_approval.'')}}"
                                         @else
                                         src="{{asset('/assets/images/default/pdf.png')}}"
                                         @endif alt="ad_approval"/>
                                    @if(strstr($attachments->ad_approval ,'pdf'))
                                </a>
                            @endif
                        </div>

                    </div>
                @endif
            </div>
        </div>
        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div id="caption"></div>
        </div>
        @include('brandpriers.modal')


    </div>
@endsection

@section('script')
    @include('brandpriers.brandAttachments.brandAttachmentsJs')
@endsection
