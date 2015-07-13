<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 *
 *
 */

include("Perform_Query.php");

$user="michael345435";
$password="smuts";

echo "OK up to here1";

$connection = new Perform_Query();

echo "OK up to here2";

$go_query = $connection->Login_Check($user, $password);

echo "OK up to here3";

echo $go_query;




?>
