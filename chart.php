<html>
<head>
    <title>Chart</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
    <?php
        require 'connect.php';
        $costs = '';
        $earnings = '';
        $date = '';
        $profit = '';

        $sql = "SELECT * FROM profit ORDER BY date";
        $result = mysqli_query($conexiune, $sql);
        while($row = mysqli_fetch_array($result)) 
        {
            $costs = $costs . '"'. $row['costs'] .'",';
            $earnings = $earnings . '"'. $row['earnings'] .'",';
            $date = $date . '"'. $row['date'] .'",';    
            $profit = $profit . '"'. $row['earnings']-$row['costs'] .'",'; 
        }
        $costs = trim($costs,",");
        $earnings = trim($earnings,",");
        $date = trim($date,",");
        $profit = trim($profit,",");
    ?>
</head>
<body>
    <div class="container">
        <canvas id="myChart" style="background:#222; font-color:white;"></canvas>
    </div>
    <script>
        var myChart = document.getElementById('myChart').getContext('2d');
        var massPopChart = new Chart(myChart, {
            type:'line', //bara, bara orizontala, pie, line, donut, radar, polarArea
            data:{
                labels:[<?php echo $date; ?>],
                datasets:[{
                    label:'Costs',
                    data:[<?php echo $costs; ?>],
                    fontColor:'white',
                    backgroundColor:'transparent',
                    borderColor:'#03dbfc',
                    borderWidth:5
                },

                {
                    label:'Profit',
                    data:[<?php echo $profit; ?>],
                    fontColor:'white',
                    backgroundColor:'transparent',
                    borderColor:'purple',
                    borderWidth:5
                },

                {
                    label:'Earnings',
                    data:[<?php echo $earnings; ?>],
                    fontColor:'white',
                    backgroundColor:'transparent',
                    borderColor:'#04cf69',
                    borderWidth:5
                }]
            },
            options:{
                scales:{
                        yAxes:[{
                            beginAtZero: false,
                            ticks:{
                                fontColor: 'white',
                                fontSize: 18,
                            }
                        }],
                        xAxes:[{
                            autoskip: true,
                            ticks:{
                                fontColor: 'white',
                                fontSize: 18,
                            }
                        }]
                },
                tooltips:{
                    mode:'index'
                },
                legend:{
                    display: true,
                    position: 'top',
                    labels:{
                        fontColor:'white',
                        fontSize:15,
                        fontWeight: 'bold'
                    }
                }
            }
        });
    </script>
</body>
</html>
