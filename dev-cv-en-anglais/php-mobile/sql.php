<?php
$link = mysql_connect('localhost', 'usoeur1.topadmin', 'appletree44')
    or die('Could not connect: ' . mysql_error());
echo 'Connected successfully';
echo $link;
?>