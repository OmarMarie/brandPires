
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

</script>