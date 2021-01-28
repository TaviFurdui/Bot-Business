<?php

    require_once("auth.php");
?>

<html>
    <head>
        <link rel="stylesheet" href="login-register.css">

        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>Sign Up</title>
    </head>

    <body>
        <div class="welcome">
            <div class="text">
                <h1>Welcome to our website!</h1> 
                <h2>Bot Gigi will surely help you see the big picture of your business!</h2>
                <a id="link" href="">Why would you use this website?</a>
            </div>
        </div>

        <div class="charts">
            <div class="chart-text">
                <h2>You can add all your business data about earnings and costs, and we will show you some charts regarding your profit!</h2>
            </div>
            <div class="chart-image">
                <img src="chart.png">
            </div>
        </div>

        <div class="events">
            <div class="event-image">
                <img src="cardfinal.png">
            </div>
            <div class="event-text">
                <h2>Also, you can save your businesses locations, set up meetings in our calendar and ask our bot to convert some currencies!</h2>
            </div>
        </div>

        <div class="container">
            <div class="login">
                <div class="head">
                    <p>Welcome back,</p><br>
                    <span>please login to your account!</span>
                </div>
                <div class="inputs">
                    <form method="post">
                        <span>Email</span>
                        <span><i class="fas fa-envelope"></i><input type="email" placeholder="Type your email" name="email"></span>

                        <span>Password</span>
                        <span><i class="fas fa-lock"></i><input type="password" placeholder="Type your password" name="password"></span>

                        <!-- <span class="forget">Forgot your password?</span> -->

                        <div style="width: 100%; text-align: center">
                            <button class="btn-login" name="login">Login</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="between">
                
            </div>

            <div class="register">
                <div class="head">
                    <p>Hello there,</p><br>
                    <span>please sign up to start working!</span>
                </div>
                <div class="inputs">
                    <form method="post">
                        <span>Username</span>
                        <span><i class="fas fa-user-alt"></i><input type="text" placeholder="Type your username" name="username"></span>

                        <span>Email</span>
                        <span><i class="fas fa-envelope"></i><input type="email" placeholder="Type your email" name="email"></span>

                        <span>Password</span>
                        <span><i class="fas fa-lock"></i><input type="password" placeholder="Type your password" name="password"></span>

                        <div style="width: 100%; text-align: center">
                            <button class="btn-login" name="sign-up">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $('#link').mousedown(function(){
                timeout = setInterval(function(){
                    window.scrollBy(0,25); // May need to be -1 to go down
                }, 0); // Play around with this number. May go too fast
                
                return false;
            });

            $(document).mouseup(function(){
                clearInterval(timeout);
                return false;
            });
        </script>
    </body>
</html>