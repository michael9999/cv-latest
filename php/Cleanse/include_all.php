<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 */


include ("Cleanse.php");
include ("Cleanse_int.php");

$to_clean = array("michael1" =>"O''reilly", "Michael2" =>"mi<html><br>");
$cleansed = array();

echo "ok to here";

$new_obj = new Cleanse_int();

echo "<br> <br> ok 2";

$clean_data = $new_obj->send_cleanse($to_clean);


echo "test <br> <br>";

echo $clean_data["Michael2"];

?>
