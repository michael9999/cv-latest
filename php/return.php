<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// GET CURRENT USER //

//require_once("http://wpc4000.amenworld.com/word2/wp-load.php");


//global $current_user;
  //    get_currentuserinfo();

//$customer = $current_user->user_login;
//$_POST['user_current'];

echo "<form>
<input type='checkbox' name='vehicle1' id='box1' value='Bike' /> I have a bike<br />
<input type='checkbox' name='vehicle2' id='box2' value='Car' />" . $_POST['user_current'] . " I have a car
</form>";



//$test = "this a value";
//echo $customer;

?>
