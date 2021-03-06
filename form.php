<?php
session_start();
?>
<html>
    <head>
        <title>Form</title>
        <link rel="stylesheet" href="form.css" type="text/css"/>
        <script src="http://maps.googleapis.com/maps/api/js"></script>
        <script>
            
            var map; 
            var marker = false; 

            function initMap() {
                var centerOfMap = new google.maps.LatLng(52.519325, 13.392709);

                var options = {
                    center: centerOfMap, 
                    zoom: 7, 
                    mapTypeId: 'roadmap'
                };
            
                map = new google.maps.Map(document.getElementById('map'), options);
            
                google.maps.event.addListener(map, 'click', function(event) {                
                    var clickedLocation = event.latLng;
                    if(marker === false)
                    {
                        marker = new google.maps.Marker({
                            position: clickedLocation,
                            map: map,
                            draggable: true 
                        });
                        google.maps.event.addListener(marker, 'dragend', function(event){
                            markerLocation();
                        });
                    } 
                    else
                    {
                        marker.setPosition(clickedLocation);
                    }
                    markerLocation();
                });
            }
                    
            function markerLocation(){
                var currentLocation = marker.getPosition();
                document.getElementById('lat').value = currentLocation.lat();
                document.getElementById('lng').value = currentLocation.lng(); 
            }
            google.maps.event.addDomListener(window, 'load', initMap);
        </script>
    </head>
    <body>
        <!--
            1. TIPUL AFACERII 
            2. NUMELE AFACERII
            3. LOCATIA
            4. NUMAR DE ANGAJATI
            5. SALARIU MEDIU / ANGAJAT *???*
            6. EXCEL CU PROFITURI / .CSV 
        --> 
        <div class="container">
            <h2>Let's add your business to our website!</h2>
            <form action="import.php" method="POST" id="import_excel_form" enctype="multipart/form-data">
            <span id="message"></span>
                    <div class="left-form">
                        <label>Business Type</label><br>
                        <input class="input" name='type' type="text" placeholder="Restaurant, Shop..." required></input><br>
                        <label>Business Name</label><br>
                        <input class="input" name='name' type="text" required></input><br>
                        <label>Type the number of employees</label><br>
                        <input class="input" name='number_empl' type="text" required></input><br>
                        <label>Type a medium salary per employee</label><br>
                        <input class="input" name='salary' type="text" required></input><br>
                        <label>A .xlsx/.csv file with your monthly costs/earnings</label><br>
                        <input class="input" type="file" name="import_excel" value="Choose file" required></input><br>
                    </div>
                    <div class="right-form">
                        <a class="input">Select your business location</a>
                        <div id="map">
                        
                        </div>
                        <input type='hidden' name='lat' id='lat'>  
                        <input type='hidden' name='lng' id='lng'>
                    </div>
                    <input type="submit" value="Add business" name="import" id="import"></input>
            </form>
        </div>
    </body>
</html>
<script>
$(document).ready(function(){
  $('#import_excel_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"import.php",
      method:"POST",
      data:new FormData(this),
      contentType:false,
      cache:false,
      processData:false,
      beforeSend:function(){
        $('#import').attr('disabled', 'disabled');
        $('#import').val('Importing...');
      },
      success:function(data)
      {
        $('#message').html(data);
        $('#import_excel_form')[0].reset();
        $('#import').attr('disabled', false);
        $('#import').val('Import');
      }
    })
  });
});
</script>
