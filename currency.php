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

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="currency.css"/>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="bot">
            <div class="chat">
                <span class="response">Hi there! I'm here to help you! Type help to see what can I do for you</span>
            </div>

            <input id="input-message" placeholder="Ask Gigi something"/>
        </div>
    </body>
</html>

<!-- 
1 euro = 4 lei
10 dolari in lei

euro = 1.2 dolari
euro = 4.8 lei

1 euro .......... 1.2 dolari
1 euro .......... 4.8 lei
----------------------------
10 dolari in lei?

1.2 dolari ............ 4.8 lei 
10 dolari  ............ x 
-->

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