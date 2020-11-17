
<script type="text/javascript">
    $('#datepicker').datepicker({
        format: 'mm-dd-yyyy',
        daysOfWeekDisabled: [0,6],
        multidate: true,
        clearBtn: true,
        todayHighlight: true,
        daysOfWeekHighlighted: [0,6],
    });

    var ctx = $('#myChart');
    if ($("#myChart").length != 0) {
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',
            // The data for our dataset
            data: {
                labels: ['Sun', 'Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat'],
                datasets: [{
                    backgroundColor:'#ffffff8a',
                    borderColor:'#ffffff',
                    pointBackgroundColor:'#ffffff',
                    lineTension:'0.4',
                    label: 'Sales',
                    data: [0, 10, 5, 2, 13 , 15,20 ],

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
        Chart.defaults.global.responsive = true;
    }


    var campaigns_logs_map;
    map_campaigns_logs()
    function map_campaigns_logs()
    {
            eval($("#map_campaigns_logs").attr('marker_code'))
            campaigns_logs_map = new google.maps.Map(document.getElementById('map_campaigns_logs'), {
                zoom: 6,
                center: new google.maps.LatLng(24.079352, 48.0031405),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            var infowindow = new google.maps.InfoWindow();
            var marker, i;
          console.log(locations);
            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: campaigns_logs_map,
                    icon: '{{asset('assets/media/logos/pin.png')}}'
                });
                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(campaigns_logs_map, marker);
                    }
                })(marker, i));
            }

    }


</script>