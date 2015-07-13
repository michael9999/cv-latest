    <?php

    global $current_user;
          get_currentuserinfo();

    $cur_user = $current_user->user_login;

    // Add current user to javascript var
    ?>
    <?php

    //---------------------- CHECKS IF USER IS LOGGED IN, if yes display accordion, if no show subscribe message ---------------

    if (!empty($cur_user)){

    
    ?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


    <style type="text/css">
    .accordion2 {
        width: 280px;
        border-bottom: solid 1px #c4c4c4;
    }
    .accordion2 h3 {
        background: #e9e7e7 url(images/arrow-square.gif) no-repeat right -51px;
        padding: 7px 15px;
        margin: 0;
        font: bold 120%/100% Arial, Helvetica, sans-serif;
        border: solid 1px #c4c4c4;
        border-bottom: none;
        cursor: pointer;
    }
    .accordion2 h3:hover {
        background-color: #e3e2e2;
    }
    .accordion2 h3.active {
        background-position: right 5px;
    }
    .accordion2 p {
        background: #f7f7f7;
        margin: 0;
        padding: 10px 15px 20px;
        border-left: solid 1px #c4c4c4;
        border-right: solid 1px #c4c4c4;
        display: none;
    }
    </style>
    </head>

    <body>


        <p id="s_questions">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi malesuada, ante at feugiat tincidunt, enim massa gravida metus, commodo lacinia massa diam vel eros. Proin eget urna. Nunc fringilla neque vitae odio. Vivamus vitae ligula.</p>



    </body>
    </html>
    <?php
    }

    else {
    echo "you need to register to access this option, registration is free";

    }
	?>