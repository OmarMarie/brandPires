<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->

<!-- Mirrored from keenthemes.com/metronic/preview/demo1/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 05 Jun 2020 14:21:59 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8"/>
    <title> BrandPires | Already verified</title>
    <meta name="description" content="Updates and statistics"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="shortcut icon" href="{{ asset('/assets/media/logos/header_logo.png') }}"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>


</head>

<body>
<style>
    .success-container{
        left: 50%;
        top:50%;
        width:600px;
        transform: translate(-50%, -50%);
        position:fixed;
    }
    .modalbox.success {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        background: #fff;
        padding: 25px 25px 15px;
        text-align: center;
    }
    .modalbox.success.animate .icon {
        -webkit-animation: fall-in 0.75s;
        -moz-animation: fall-in 0.75s;
        -o-animation: fall-in 0.75s;
        animation: fall-in 0.75s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    }
    .modalbox.success h1 {
        font-family: 'Montserrat', sans-serif;
    }
    .modalbox.success p {
        font-family: 'Open Sans', sans-serif;
    }
    .modalbox.success .icon {
        position: relative;
        margin: 0 auto;
        margin-top: -75px;
        background: #FFA500;
        height: 100px;
        width: 100px;
        border-radius: 50%;
    }
    .modalbox.success .icon span {
        postion: absolute;
        font-size: 4em;
        color: #fff;
        text-align: center;
        padding-top: 20px;
    }
    .center {
        float: none;
        margin-left: auto;
        margin-right: auto;
        /* stupid browser compat. smh */
    }
    .center .change {
        clearn: both;
        display: block;
        font-size: 10px;
        color: #ccc;
        margin-top: 10px;
    }
    @-webkit-keyframes fall-in {
        0% {
            -ms-transform: scale(3, 3);
            -webkit-transform: scale(3, 3);
            transform: scale(3, 3);
            opacity: 0;
        }
        50% {
            -ms-transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
            opacity: 1;
        }
        60% {
            -ms-transform: scale(1.1, 1.1);
            -webkit-transform: scale(1.1, 1.1);
            transform: scale(1.1, 1.1);
        }
        100% {
            -ms-transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
        }
    }
    @-moz-keyframes fall-in {
        0% {
            -ms-transform: scale(3, 3);
            -webkit-transform: scale(3, 3);
            transform: scale(3, 3);
            opacity: 0;
        }
        50% {
            -ms-transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
            opacity: 1;
        }
        60% {
            -ms-transform: scale(1.1, 1.1);
            -webkit-transform: scale(1.1, 1.1);
            transform: scale(1.1, 1.1);
        }
        100% {
            -ms-transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
        }
    }
    @-o-keyframes fall-in {
        0% {
            -ms-transform: scale(3, 3);
            -webkit-transform: scale(3, 3);
            transform: scale(3, 3);
            opacity: 0;
        }
        50% {
            -ms-transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
            opacity: 1;
        }
        60% {
            -ms-transform: scale(1.1, 1.1);
            -webkit-transform: scale(1.1, 1.1);
            transform: scale(1.1, 1.1);
        }
        100% {
            -ms-transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
        }
    }
    @-webkit-keyframes plunge {
        0% {
            margin-top: -100%;
        }
        100% {
            margin-top: 25%;
        }
    }
    @-moz-keyframes plunge {
        0% {
            margin-top: -100%;
        }
        100% {
            margin-top: 25%;
        }
    }
    @-o-keyframes plunge {
        0% {
            margin-top: -100%;
        }
        100% {
            margin-top: 25%;
        }
    }
    @-moz-keyframes fall-in {
        0% {
            -ms-transform: scale(3, 3);
            -webkit-transform: scale(3, 3);
            transform: scale(3, 3);
            opacity: 0;
        }
        50% {
            -ms-transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
            opacity: 1;
        }
        60% {
            -ms-transform: scale(1.1, 1.1);
            -webkit-transform: scale(1.1, 1.1);
            transform: scale(1.1, 1.1);
        }
        100% {
            -ms-transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
        }
    }
    @-webkit-keyframes fall-in {
        0% {
            -ms-transform: scale(3, 3);
            -webkit-transform: scale(3, 3);
            transform: scale(3, 3);
            opacity: 0;
        }
        50% {
            -ms-transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
            opacity: 1;
        }
        60% {
            -ms-transform: scale(1.1, 1.1);
            -webkit-transform: scale(1.1, 1.1);
            transform: scale(1.1, 1.1);
        }
        100% {
            -ms-transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
        }
    }
    @-o-keyframes fall-in {
        0% {
            -ms-transform: scale(3, 3);
            -webkit-transform: scale(3, 3);
            transform: scale(3, 3);
            opacity: 0;
        }
        50% {
            -ms-transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
            opacity: 1;
        }
        60% {
            -ms-transform: scale(1.1, 1.1);
            -webkit-transform: scale(1.1, 1.1);
            transform: scale(1.1, 1.1);
        }
        100% {
            -ms-transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
        }
    }
    @keyframes fall-in {
        0% {
            -ms-transform: scale(3, 3);
            -webkit-transform: scale(3, 3);
            transform: scale(3, 3);
            opacity: 0;
        }
        50% {
            -ms-transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
            opacity: 1;
        }
        60% {
            -ms-transform: scale(1.1, 1.1);
            -webkit-transform: scale(1.1, 1.1);
            transform: scale(1.1, 1.1);
        }
        100% {
            -ms-transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
        }
    }
    @-moz-keyframes plunge {
        0% {
            margin-top: -100%;
        }
        100% {
            margin-top: 15%;
        }
    }
    @-webkit-keyframes plunge {
        0% {
            margin-top: -100%;
        }
        100% {
            margin-top: 15%;
        }
    }
    @-o-keyframes plunge {
        0% {
            margin-top: -100%;
        }
        100% {
            margin-top: 15%;
        }
    }
    @keyframes plunge {
        0% {
            margin-top: -100%;
        }
        100% {
            margin-top: 15%;
        }
    }

</style>

<div class="success-container">
    <div class="row">
        <div class="modalbox success col-sm-8 col-md-6 col-lg-5 center animate">
            <div class="icon">
                <span class="glyphicon glyphicon-exclamation-sign"></span>
            </div>
            <h1>Already verified!</h1>
            <p>Your email has been Already verified</p>
        </div>
    </div>
</div>


<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1200
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#F3F6F9",
                    "dark": "#212121"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#ECF0F3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#212121",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121"
            }
        },
        "font-family": "Poppins"
    };
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</body>
<!--end::Body -->

<!-- Mirrored from keenthemes.com/metronic/preview/demo1/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 05 Jun 2020 14:25:22 GMT -->
</html>
