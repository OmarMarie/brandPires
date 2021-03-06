<script type="text/javascript">
    $('#kt_datepicker_5').datepicker({
        format: 'M - yyyy',
        viewMode: "months",
        minViewMode: "months",
        daysOfWeekDisabled: [0, 6],
        clearBtn: true,
        todayHighlight: true,
        daysOfWeekHighlighted: [0, 6],
    });

    $('#add').on('click', function () {

        $.ajax({
            url: ' {{route('reportPlayers', app()->getLocale())}}',
            method: 'get',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Players');
                $('#modal').modal('show');
            }
        });
    });


    var ctx = $('#myChart');
    if ($("#myChart").length != 0) {
        $.ajax({
            url: ' {{route('reportSales', app()->getLocale())}}',
            method: 'get',
            success: function (data) {
                var i;
                var month = new Array();
                var value = new Array();
                for (i = 0; i < data.sales.length; ++i) {
                    month[i] = data.sales[i].month
                    value[i] = data.sales[i].value
                }
                var date = new Date();
                var year = date.getFullYear();
                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'line',
                    // The data for our dataset
                    data: {
                        labels: month,
                        datasets: [{
                            backgroundColor: '#ffffff8a',
                            borderColor: '#ffffff',
                            pointBackgroundColor: '#ffffff',
                            lineTension: '0.4',
                            label: 'Sales - ' + year,
                            data: value,

                        }],
                    },


                    // Configuration options go here
                    options: {
                        legend: {
                            labels: {
                                fontColor: "#ffffff",
                            }
                        },
                        responsive: true,
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                        scales: {
                            xAxes: [{
                                ticks: {
                                    fontColor: "#ffffff",
                                },
                                display: true,
                            }],
                            yAxes: [{
                                ticks: {
                                    fontColor: "#ffffff",
                                },
                                display: true,
                            }]
                        }
                    }
                });
            }
        });


        Chart.defaults.global.responsive = true;
    }

    var ctx2 = $('#campaignsChart');
    var campaignsChart = new Chart(ctx2, {
        type: 'bar',

        data: {
            labels: ['Active', 'InActive', 'Stopped', 'Finished'],
            datasets: [{
                label: 'Campaigns',
                data: [{{$activeCampaigns}}, {{$inActiveCampaigns}}, {{ $stoppedCampaigns}}, {{$finishedCampaigns}},0],
                backgroundColor: [
                    'rgba(0, 0, 0, 0.2)',
                    'rgba(0, 0, 0, 0.2)',
                    'rgba(0, 0, 0, 0.2)',
                    'rgba(0, 0, 0, 0.2)',

                ],
                borderColor: [
                    'rgba(0, 0, 0, 1)',
                    'rgba(0, 0, 0, 1)',
                    'rgba(0, 0, 0, 1)',
                    'rgba(0, 0, 0, 1)',

                ],
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    barPercentage: 0.1,
                    gridLines: {
                        offsetGridLines: true
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctx3 = $('#bubblesChart');
    var bubblesChart = new Chart(ctx3, {
        type: 'bar',

        data: {
            labels: ['Available','Fished', 'Replacement', 'Recovery'],
            datasets: [{
                label: 'Bubbles',
                data: [1000,500,300 ,200 ,0],
                backgroundColor: [
                    'rgba(0, 0, 0, 0.2)',
                    'rgba(0, 0, 0, 0.2)',
                    'rgba(0, 0, 0, 0.2)',
                    'rgba(0, 0, 0, 0.2)',

                ],
                borderColor: [
                    'rgba(0, 0, 0, 1)',
                    'rgba(0, 0, 0, 1)',
                    'rgba(0, 0, 0, 1)',
                    'rgba(0, 0, 0, 1)',

                ],
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    barPercentage: 0.1,
                }]
            }
        }
    });

    prev_infowindow = false;
    var campaigns_logs_map;
    map_campaigns_logs()

    function map_campaigns_logs() {
        eval($("#map_campaigns_logs").attr('marker_code'))
        campaigns_logs_map = new google.maps.Map(document.getElementById('map_campaigns_logs'), {
            zoom: 6,
            center: new google.maps.LatLng(24.079352, 48.0031405),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: [
                {
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#1a2537"
                        }
                    ]
                },
                {
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "color": "#212121"
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                },
                {
                    "featureType": "administrative.country",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#9e9e9e"
                        }
                    ]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "administrative.locality",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#bdbdbd"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#181818"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#616161"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "color": "#1b1b1b"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#2c2c2c"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#8a8a8a"
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#373737"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#3c3c3c"
                        }
                    ]
                },
                {
                    "featureType": "road.highway.controlled_access",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#4e4e4e"
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#616161"
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#000000"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#3d3d3d"
                        }
                    ]
                }
            ],
        });
        var infowindow = new google.maps.InfoWindow();
        var marker, i;

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: campaigns_logs_map,
                icon: '{{asset('assets/media/logos/pin.png')}}'
            });
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                if (prev_infowindow) {
                    prev_infowindow.close();
                    alert(1);
                }

                return function () {
                    $.ajax({
                        url: '/{{(app()->getLocale())}}/map/' + locations[i][1] + '/' + locations[i][2],
                        method: 'get',
                        success: function (data) {
                            infowindow = new google.maps.InfoWindow({
                                content: data,
                                maxWidth: 1000,
                                maxHeight: 300,
                            });
                            prev_infowindow = infowindow;
                        }
                    });
                    setTimeout(function () {
                        infowindow.open(campaigns_logs_map, marker)
                    }, 200);

                }
            })(marker, i));
        }

    }


</script>
