<html>
    <head>
        <?php
            require 'connect.php';

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
    </head>
    <body onload="initMap();">
        <div id="map" style="width: 300px; height:300px;">

        </div>
    </body>
</html>