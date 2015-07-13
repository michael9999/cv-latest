<?php
// Create connection
$con=mysqli_connect("localhost","sw2c_eglio22","koO0CeQr7GJXc9GYo","sw2c_cv_app");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  
//$result = mysqli_query($con,"SELECT * FROM ns_questions");

$result = mysqli_query($con,"SELECT* from ns_questions WHERE (user = 'client') AND (link_section='start') ORDER BY quest_nb");


//SELECT* from ns_questions WHERE (user = '$this->user') AND (link_section='start') ORDER BY quest_nb

$response = "<h1>";

/*while($row = mysqli_fetch_array($result))
  {
  echo $row['link'] . " " . $row['link_name'];
  echo "<br />";
  }*/

while($row = mysqli_fetch_array($result))
  {
  $response .= $row['link'] . " " . $row['link_name'] . "<br />";
  }

echo $response;

mysqli_close($con);
?>