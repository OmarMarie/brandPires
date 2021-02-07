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
            <input type="hidden" id="company_id" name="company_id" value="{{ $company_id }}">
            <div class="">
                <label class="" style="padding: 10px 0px 0px 19px;"> Company Name : <b style="color:#ffa800;">{{$companyName}}</b> </label>
            </div>
            <div class="card-body">
                @if(isset($attachments))
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label style=" display: block !important;">Commercial Registration</label>
                            @if(strstr($attachments->commercial_registration ,'pdf'))
                                <a href="{{asset('/attachments/company/'.$attachments->commercial_registration.'')}}"
                                   target="_blank">
                                    @endif
                                    <img class="{{!strstr($attachments->commercial_registration ,'pdf') ? "myImg":"" }}"
                                         id="myImg"
                                         @if(!strstr($attachments->commercial_registration ,'pdf'))
                                         src="{{asset('/attachments/company/'.$attachments->commercial_registration.'')}}"
                                         @else
                                         src="{{asset('/assets/images/default/pdf.png')}}"
                                         @endif alt="Commercial Registration"/>
                                    @if(strstr($attachments->commercial_registration ,'pdf'))
                                </a>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label style=" display: block !important;">Identity</label>
                            @if(strstr($attachments->Identity ,'pdf'))
                                <a href="{{asset('/attachments/company/'.$attachments->Identity.'')}}"
                                   target="_blank">
                                    @endif
                                    <img class="{{!strstr($attachments->Identity ,'pdf') ? "myImg":"" }}" id="myImg"
                                         @if(!strstr($attachments->Identity ,'pdf'))
                                         src="{{asset('/attachments/company/'.$attachments->Identity.'')}}"
                                         @else
                                         src="{{asset('/assets/images/default/pdf.png')}}"
                                         @endif alt="Identity"/>
                                    @if(strstr($attachments->Identity ,'pdf'))
                                </a>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label style=" display: block !important;">Bank Account</label>
                            @if(strstr($attachments->bank_account ,'pdf'))
                                <a href="{{asset('/attachments/company/'.$attachments->bank_account.'')}}"
                                   target="_blank">
                                    @endif
                                    <img class="{{!strstr($attachments->bank_account ,'pdf') ? "myImg":"" }}" id="myImg"
                                         @if(!strstr($attachments->bank_account ,'pdf'))
                                         src="{{asset('/attachments/company/'.$attachments->bank_account.'')}}"
                                         @else
                                         src="{{asset('/assets/images/default/pdf.png')}}"
                                         @endif alt="Bank Account"/>
                                    @if(strstr($attachments->bank_account ,'pdf'))
                                </a>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label style=" display: block !important;">Agreement Privacy and Policy</label>
                            @if(strstr($attachments->privacy_policy ,'pdf'))
                                <a href="{{asset('/attachments/company/'.$attachments->privacy_policy.'')}}"
                                   target="_blank">
                                    @endif
                                    <img class="{{!strstr($attachments->privacy_policy ,'pdf') ? "myImg":"" }}" id="myImg"
                                         @if(!strstr($attachments->privacy_policy ,'pdf'))
                                         src="{{asset('/attachments/company/'.$attachments->privacy_policy.'')}}"
                                         @else
                                         src="{{asset('/assets/images/default/pdf.png')}}"
                                         @endif alt="Agreement Privacy and Policy"/>
                                    @if(strstr($attachments->privacy_policy ,'pdf'))
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
    @include('brandpriers.companyAttachments.companyAttachmentsJs')
@endsection
