    <?php

    global $current_user;
          get_currentuserinfo();

    $cur_user = $current_user->user_login;

    // Add current user to javascript var
    ?>
    <?php

    //echo"<html><div id="user" value ="" . $cur_user . //""</div>
    //</html>"

    //---------------------- CHECKS IF USER IS LOGGED IN, if yes display accordion, if no show subscribe message ---------------

    if (!empty($cur_user)){


    //require_once(ABSPATH. "/php/accord-trial-4.php");
    ?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    </head>

    <body>


        <p id="before_you_leave">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi malesuada, ante at feugiat tincidunt, enim massa gravida metus, commodo lacinia massa diam vel eros. Proin eget urna. Nunc fringilla neque vitae odio. Vivamus vitae ligula.</p>


    </body>
    </html>
    <?php
    }

    else {
    echo "you need to register to access this option, registration is free";

    }