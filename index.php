<!----------------------- CUM E ARANJAT CODUL? ----------------------->
<!--------- Deocamdata avem 4 chestii: harta, bot, grafic si calendar ----------------------->
<!--------- Fiecare din cele 4 are coduri externe de js, css sau php, care se regasesc si aici ----------------------->
<!--------- Din pacate, nu toate sunt in head, cateva coduri de js sunt jos de tot in pagina ----------------------->
<!--------- Toate linkurile de la fiecare lucru au comentariu deasupra lor ca sa stim de la ce sunt ----------------------->
<!--------- Jos de tot in pagina sunt doar js-urile de la GRAFIC, BOT (CURRENCY SI DRAGGABLE) si CALENDAR ----------------------->
<!--------- Orice cod de PHP se afla in HEAD ----------------------->
<!--------- BODY-UL INCEPE LA LINIA 128 !!!!!!! ----------------------->
<?php
    session_start();

    require_once("connect.php");

    if(isset($_SESSION['email']) && isset($_SESSION['password']))
    {
        $email = $_SESSION['email'] ;
        $password = $_SESSION['password'];

        $stmt = $conexiune->prepare("SELECT * FROM users WHERE email=? AND password=?");
        $stmt->bind_param('ss', $email, $password);

        $stmt->execute();

        $stmt -> store_result();
        $no = $stmt->num_rows;

        if($no > 0){}
        else{
            header("Location: login-register.php");
        }

        $stmt->close();
    }
    
?>

<html>
    <head>
        <title>Business</title>
        <!----------------------- META ----------------------->

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!----------------------- INDEX CSS ----------------------->

        <link rel="stylesheet" href="index.css" type="text/css"/>
        <!------------------------ CSS, JS SI PHP PENTRU GRAFIC ------------------>

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
        <!------------------------ CSS, JS SI PHP PENTRU HARTA ------------------>

        <?php
            $sql = "SELECT * FROM location";
            $result = mysqli_query($conexiune, $sql);
            $locations = array();
            $counter = 0;
            while($row = mysqli_fetch_array($result)) 
            {
                $counter++;
                $locations[] = $row;
            }
        ?>
        <script src="http://maps.googleapis.com/maps/api/js"></script>
        <script>
            var map; 
            var center = new google.maps.LatLng(45.812897, 15.97706);

            function initMap() {

                var options = {
                center: center, 
                zoom: 2, 
                mapTypeId: 'roadmap'
                };
            
                map = new google.maps.Map(document.getElementById('map'), options);

                <?php for ($i = 0; $i < $counter; $i++) //CAUT FIECARE LOCATIE SI COORDONATELE IN BAZA DE DATE
                {
                ?>
                    var position = new google.maps.LatLng(<?php echo json_encode(floatval($locations[$i][1])); echo ','; echo json_encode(floatval($locations[$i][2]));?>);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: position,
                        visible: true
                    });
                    marker.setMap(map);
                <?php
                }
                ?>
            }
        </script>

        <!------------------------ CSS SI JS PENTRU CALENDAR ------------------>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />

        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

        <!------------------------ CSS, JS SI PHP PENTRU BOT SI CURRENCY ------------------>

        <link rel="stylesheet" href="currency.css"/>
        <?php
            $req_url = 'https://v6.exchangerate-api.com/v6/4dcdd9547ccd4ace925fb9c4/latest/EUR';
            $response_json = file_get_contents($req_url);

            $eur = 0;
            $usd = 0;
            $ron = 0;

            if(false !== $response_json) {

                try {
                    $response = json_decode($response_json, true);

                    if($response['result'] == 'success' ) {
                        $eur = $response['conversion_rates']['EUR'];
                        $usd = $response['conversion_rates']['USD'];
                        $ron = $response['conversion_rates']['RON'];
                    }
                }
                catch(Exception $e) {}
            }
        ?>

    </head>

    <body onload="initMap();">

        <div class="bara-sus">
            <div class="add-business">
                Add new business
            </div>
            <div class="add-buton">
                <a href="form.php">+</a>
            </div>
        </div>

        <div class="fundal">
            
        </div>
        
        <div class="about-chart">
            <h2>Here you can see the profit of your business! Be sure to upload the costs and earnings of the business regularly.</h2>
            <div class="grafic">
                <canvas id="myChart" style="background:#222; font-color:white;"></canvas>
            </div>
        </div>

        <div class="about-map">
            <h2>These are your business locations. In the future, we want to recommend you new places to open your type of business.</h2>
            <div id="map">

            </div>
        </div>

        <div class="about-calendar">
            <h2 class="h2">Here you can set up meetings or reminders on the calendar.</h2>
            <div id="calendar">

            </div>
        </div>

        <div id="bot">  <!---ORICE DIV CARE APARTINE CHATULUI CU BOTUL AR FI BINE SA FIE INAUNTRUL DIV-ULUI "BOT" PENTRU CA ALTFEL NU MAI E DRAGGABLE--------------->
            <div class="chat">
                <span class="response">Hi there! I'm here to help you! Type help to see what can I do for you</span>
            </div>

            <input id="input-message" placeholder="Ask Gigi something"/>
        </div>








        <!------------------------ JS PENTRU GRAFIC ------------------>
        
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
                            borderColor:'white',
                            borderWidth:5
                        },

                        {
                            label:'Profit',
                            data:[<?php echo $profit; ?>],
                            fontColor:'white',
                            backgroundColor:'transparent',
                            borderColor:'gold',
                            borderWidth:5
                        },

                        {
                            label:'Earnings',
                            data:[<?php echo $earnings; ?>],
                            fontColor:'white',
                            backgroundColor:'transparent',
                            borderColor:'blue',
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

            <!------------------------ JS PENTRU CALENDAR ------------------>

            <script>
                $(document).ready(function() {
                    var calendar = $('#calendar').fullCalendar({
                        editable:true,
                        header:{
                            left:'prev,next today',
                            center:'title',
                            right:'month,agendaWeek,agendaDay'
                        },
                        events: 'load.php',
                        selectable:true,
                        selectHelper:true,
                        select: function(start, end, allDay)
                        {
                            var title = prompt("Enter Event Title");
                            if(title)
                            {
                                var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                                var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                                $.ajax({
                                    url:"insert.php",
                                    type:"POST",
                                    data:{title:title, start:start, end:end},
                                    success:function()
                                    {
                                        calendar.fullCalendar('refetchEvents');
                                        alert("Added Successfully");
                                    }
                                })
                            }
                        },
                        editable:true,
                        eventResize:function(event)
                        {
                            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                            var title = event.title;
                            var id = event.id;
                            $.ajax({
                                url:"update.php",
                                type:"POST",
                                data:{title:title, start:start, end:end, id:id},
                                success:function(){
                                    calendar.fullCalendar('refetchEvents');
                                    alert('Event Update');
                                }
                            })
                        },

                        eventDrop:function(event)
                        {
                            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                            var title = event.title;
                            var id = event.id;
                            $.ajax({
                                url:"update.php",
                                type:"POST",
                                data:{title:title, start:start, end:end, id:id},
                                success:function()
                                {
                                    calendar.fullCalendar('refetchEvents');
                                    alert("Event Updated");
                                }
                            });
                        },

                        eventClick:function(event)
                        {
                            if(confirm("Are you sure you want to remove it?"))
                            {
                                var id = event.id;
                                $.ajax({
                                    url:"delete.php",
                                    type:"POST",
                                    data:{id:id},
                                    success:function()
                                    {
                                        calendar.fullCalendar('refetchEvents');
                                        alert("Event Removed");
                                    }
                                })
                            }
                        },

                    });
                });
            </script>

            <!------------------------ JS PENTRU BOT SI CURRENCY ------------------>

            <script>
                var usd = <?php echo $usd; ?>;
                var ron = <?php echo $ron; ?>;
                
                $(document).on('keypress',function(e) {
                    function getResponse(msg)
                    {
                        if(data[0] == "help")
                            $(".chat").append("<span class='response'>" + "muie" + "</span>");
                    }

                    function convertExchange(amount, firstSymbol, secondSymbol)
                    {
                        var firstValue, secondValue;

                        switch(firstSymbol.toLowerCase()){
                            case "usd":
                                firstValue = usd;
                                break;
                            case "ron":
                                firstValue = ron;
                                break;
                            case "eur":
                                firstValue = 1;
                                break;
                        }

                        switch(secondSymbol.toLowerCase()){
                            case "usd":
                                secondValue = usd;
                                break;
                            case "ron":
                                secondValue = ron;
                                break;
                            case "eur":
                                secondValue = 1;
                                break;
                        }

                        var res = amount * secondValue / firstValue;
                        setTimeout(function(){
                            $(".chat").append("<span class='response'>" + res + "</span>");
                        }, 1000);
                    }

                    var data = "";
                    if(e.which == 13) {
                        if($("#input-message").val().length > 0)
                        {
                            $(".chat").append("<span class='message'>" + $("#input-message").val() + "</span><br>");
                            var string = $("#input-message").val();
                            var data = string.split(" ");
                            var inputArray = [];

                            for(var i = 0;i < data.length;i++)
                            {
                                if(data[i].length == 0);
                                else
                                    inputArray.push(data[i]);
                            }

                            for(var i = 0;i < inputArray.length;i++)
                            {
                                if(inputArray[0] == "convert")
                                {
                                    // convert 10 USD to RON
                                    convertExchange(inputArray[1], inputArray[2], inputArray[4]);
                                    break;
                                }
                            }

                            $("#input-message").val('');
                            $(".chat").animate({ scrollTop: $(".chat")[0].scrollHeight }, 1000);

                            setTimeout(getResponse, 1000);
                        }
                    }
                });
            </script>

            <!------------------------ JS PENTRU BOT CA SA FIE DRAGGABLE ------------------>
            
            <script>
                dragElement(document.getElementById("bot"));

                function dragElement(elem)
                {
                    var pos1=0, pos2=0, pos3=0, pos4=0;
                    if (document.getElementById("bot"))
                    {
                        document.getElementById("bot").onmousedown = dragMouseDown;
                    }
                    else
                    {
                        elem.onmousedown = dragMouseDown;
                    }
                    function dragMouseDown(e)
                    {
                        e = e || window.event;
                        e.preventDefault();
                        pos3 = e.clientX;
                        pos4 = e.clientY;
                        document.onmouseup = closeDragElement;
                        document.onmousemove = elementDrag;
                    }
                    function elementDrag(e)
                    {
                        e = e || window.event;
                        e.preventDefault();
                        pos1 = pos3 - e.clientX;
                        pos2 = pos4 - e.clientY;
                        pos3 = e.clientX;
                        pos4 = e.clientY;

                        elem.style.top = (elem.offsetTop - pos2) + "px";
                        elem.style.left = (elem.offsetLeft - pos1) + "px";
                    }
                    function closeDragElement()
                    {
                        document.onmouseup = null;
                        document.onmousemove = null;
                    }
                    var input = document.getElementById("input-message");
                    $(input).draggable({
                        cancel:''
                    });
                }   
            </script>
    </body>
</html>