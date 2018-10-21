<!DOCTYPE HTML>
<html>
<head>
    <meta name = "viewport" content = "width=device-width, height=device-height, initial-scale=1.0, user-scalable=yes">
    <script src= "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script> 
    
    <style>
        * {
            padding: 0;
            margin: 0;
            background: black;
            color: white;
        }
        #myChart {
            width: 100vw;
            height: 100vh;
        }
    </style>

</head>
<body>
    
    <canvas id="myChart"></canvas>
    
    <script>

        var requestUrl = "http://localhost/blight_forecast_chart/index.php?"+ 
            "k1=ABC&" + "k2=NCV&" + "k3=OIE&" + "k4=PED&" + "k5=MDR&" + 
            "v1=12&" + "v2=22&" +"v3=17&" +"v4=19&" +"v5=10";
        console.log(requestUrl);

        var url = new URL(window.location.href);

        var borderColor;
        if(url.searchParams.get("color") == null) {
            borderColor = "rgba(20,175,250,1)";
        } else {
            borderColor = url.searchParams.get("color") ;
        }
        var backgroundColor = borderColor.substring(0,borderColor.length - 3) + ", 0.3)";
        console.log(borderColor + " : " + backgroundColor);

        var xlabel;
        if(url.searchParams.get("xlabel") == null) {
            xlabel = "X - Axis";
        } else {
            xlabel = url.searchParams.get("xlabel");
        }

        var ylabel;
        if(url.searchParams.get("ylabel") == null) {
            ylabel = "Y - Axis";
        } else {
            ylabel = url.searchParams.get("ylabel");
        }

        
        var k1 = url.searchParams.get("k1");
        var k2 = url.searchParams.get("k2");
        var k3 = url.searchParams.get("k3");
        var k4 = url.searchParams.get("k4");
        var k5 = url.searchParams.get("k5");

        var v1 = url.searchParams.get("v1");
        var v2 = url.searchParams.get("v2");
        var v3 = url.searchParams.get("v3");
        var v4 = url.searchParams.get("v4");
        var v5 = url.searchParams.get("v5");


        var labels, temperatures;
        if(k1 == null || k2 == null || k3 == null || k4 == null || k5 == null ||
           v1 == null || v2 == null || v3 == null || v4 == null || v5 == null) {

            labels = new Array('Sun','Mon','Tue','Wed','Thu');
            temperatures = new Array(29,21,27,35,24);
        } else {

            labels = new Array(k1,k2,k3,k4,k5);
            temperatures = new Array(v1,v2,v3,v4,v5);
        }

        var ctx = document.getElementById("myChart").getContext('2d');
        var options = {
            legend: {
                display: false,
                position: 'top',
                labels: {
                    fontColor: 'white'
                }
            },
            maintainAspectRatio: false,
            spanGaps: false,
            elements: {
                line: {
                    tension: 0.000001
                }
            },
            plugins: {
                filler: {
                    propagate: false
                }
            },
            title: {
                text: 'Temperature Forecast',
                display: false,
                fontColor: 'white'
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: xlabel
                    },
                    gridLines: {
                        color: 'rgba(255,255,255,0.2)'
                    },
                    ticks: {
                        autoSkip: false,
                        maxRotation: 0,
                        fontColor: 'white'
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: ylabel
                    },
                    gridLines: {
                        color: 'rgba(255,255,255,0.2)'
                    },
                    ticks: {
                        fontColor: 'white'
                    }
                }],
                pointLabels: {
                    fontColor: 'white' // labels around the edge like 'Running'
                },
                angleLines: {
                    color: 'white' // lines radiating from the center
                }
            }
        };

        var boundary = 'start';
        var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        data: temperatures,
                        label: 'Temperature',
                        fill: boundary
                    }]
                },
                options: options
            });
        Chart.helpers.each(Chart.instances, function(chart) {
                chart.options.elements.line.tension = 0.4;
                chart.update();
            });
    </script>
    
</body>
</html>