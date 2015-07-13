<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * BUILDS QUERY AND THEN PERFORMS IT
 * EACH FUNCTION IS CORRESPONDS TO A PARTICULAR QUERY
 *
 * @author michael
 */

include("Db_Connect.php");

class Perform_Query {
    
public $open_db;
public $new_connection;
public $user;
public $password;
public $result;
public $row;
public $name;
public $surname;
public $id;
public $linkarray;
public $link;
public $nbRow;
public $backButton;
public $forwardButton;
public $backButtonStatus;
public $forwardButtonStatus;

public function Login_Check($user, $password)

{

// SET QUERY ELEMENTS

$this->row = $row;
$this->user = $user;
$this->password = $password;
$this->result = $result;
//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);


// PERFORM QUERY

            $query = "SELECT* FROM login WHERE Login = sha1('$this->user')
                        AND Password = sha1('$this->password')";
            $result = mysql_query($query)
            or die ("Query did not run");
            $this->row=mysql_fetch_array($result, MYSQL_ASSOC);
            $numrows1 = mysql_num_rows($result);
            //echo $result['Surname'];
            //or die ("row count failed");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

            if ($numrows1 =="1") {

                //$this->result = "OK";
                $this->row['result'] = "OK";
                //echo $this->row['Surname'];
            }

            else {

                //$this->result ="NO";

                $this->row['result'] = "NO";

            }

            /*while($row = mysql_fetch_array($result)){


             }*/
             return $this->row;
             
        }


public function Delete_Link($link1)

{

// SET QUERY ELEMENTS

//$this->link_name = $link_name;
//$this->link_address = $link_address;
$this->link1 = $link1;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "DELETE from links WHERE (id = '$this->link1')";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

$string = "link deleted";





echo $string;






}



public function Session_Start($name, $surname)

{

// SET QUERY ELEMENTS

$this->name = $name;
$this->surname = $surname;
$this->user = $user;
$this->password = $password;
$this->result = $result;
//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);


// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "INSERT into session (Name, Surname, Status) values ('$this->name', '$this->surname', 'in')";
            $result = mysql_query($query)
            or die ("Query did not run");
            //$numrows1 = mysql_num_rows($result);
            //or die ("row count failed");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

            /*if ($numrows1 =="1") {

                $this->result = "OK";

            }

            else {

                $this->result ="NO";

            }

            /*while($row = mysql_fetch_array($result)){


             }
             return $this->result;*/

        }



public function Add_Link($user1, $link_name, $link_address)

{

// SET QUERY ELEMENTS

$this->link_name = $link_name;
$this->link_address = $link_address;
$this->user1 = $user1;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);


// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "INSERT into links (user, name, link) values ('$this->user1', '$this->link_name', '$this->link_address')";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");
            $this->result2 = "Your link has been added";
            echo $this->result2;
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

            /*if ($numrows1 =="1") {

                $this->result2 = "Link added successfully";
                return $this->result2;
            }

            else {

                $this->result2 = "NO";
                return $this->result2;
            }

            
             return $this->result2;

        }*/







}


public function Select_All_Link($user1)

{

// SET QUERY ELEMENTS

//$this->link_name = $link_name;
//$this->link_address = $link_address;
$this->user1 = $user1;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "SELECT * from links WHERE (user = '$this->user1') LIMIT 0 , 30";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

            $string = "<table class='link_table'><tr><th>Link</th><th>Delete</th><th>Update</th></tr>";

if (mysql_num_rows($result) > 0){
  while($row = mysql_fetch_object($result)){

    //echo $row->id;
    //echo $row->user;
    //echo $row->link;

    $string .= "<tr class='test' id='".$row->id."'><td><div id='".$row->id."'><a href=".$row->link." id='".$row->id."'>".$row->name."</a></div></td>";
  //  $string .= "<td><a href='.$row->link_address' id='".$row->id."'>".$row->link_name."</a></td>";
    //$string .= "<td><a href='#' id='".$row->entry_id."'>".$row->comments."</a></td>";
     //$string .= "<td><a href='#' id='".$row->entry_id."'>".$row->total."</a></td>";

    //$string .= "<td>".$row->Name."</td>";
    //$string .= "<td>".$row->Description."</td>";
   // $string .= "<tr><td><div id='id'><a href='form.html?id=".$row->id."' id='id_target'>".$row->name."</a></div></td>";


   // Delete

   //$string .= "<tr><td><div id='id'><a href='javascript:void(0);' class ='dynamic' id='".$row->id."'>".$row->name."</a></div></td>";

   $string .= "<td><div id='id'><form name='form-delete' id='form-delete' action='http://wpc4000.amenworld.com/iduk2/joomla-overview/delete.html' method='post'><input type='hidden' name='id2' id='id2' value='".$row->id."'><input type='submit' class='link_button_delete' id='delete' value='delete'></form></td></div>";

   // PRINTS OUT UPDATE BUTTON

   $string .="<td><div id='id-update'><form name='form-update' id='form-update' action='http://wpc4000.amenworld.com/iduk2/joomla-overview/delete.html' method='post'><input type='submit' id='update' class='link_button' value='Update'></form></div></td></tr>";

   //$string .= "<td><div id='".$row->entry_id."'><a href='#' name='".$row->date."' id='".$row->task_number."' class ='update_button' value='".$row->entry_id."'> Update </a></div></td></tr>";

   //$string .= "<tr><td><div id='id'><a href='javascript:void(0);' class ='dynamic".$row->id."' id='".$row->id."'>".$row->name."</a></div></td>";


   // $string .= "<tr><td><div id ='form'><form action ='Search2.php' method='post' id='form2'>

             //   <input type = 'hidden' name='id' id='id' value =".$row->id.">

               // <input type = 'submit' name='submit' id='submit1' value ='select'></form></div></td>";
    //$string .= "<tr><td><div id='test2'><a href='#' id='id'>".$row->id."</a></div></td>";

    //$string .= $row->phone."</a>";
    //$string .= "<br/>\n";







  }

$string .= "</table>";

}

//echo $string;

return $string;




}


public function retrieveLinks($user1, $nbRow)

{

// SET QUERY ELEMENTS

//$this->link_name = $link_name;
//$this->link_address = $link_address;
$this->user1 = $user1;
$this->nbRow = $nbRow;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

// if $this->nbRow is not set give it a value of 0

if (!isset($this->nbRow)) {$this->nbRow = 0;};

// CHECK IF THERE ARE ENOUGH ROWS FOR BACK BUTTON

$query3 = "SELECT * from links WHERE (user = '$this->user1')";
            $result3 = mysql_query($query3)
            or die ("Sorry, an error has occurred, please try again later.");


            $numrows3 = mysql_num_rows($result3)
            or die ("could not count rows");

if ($this->nbRow >= $numrows3){

$this->nbRow = $this->nbRow - 10;

}


//---------------------- END



//CHECK IF THERE IS A START COUNTER

//$this->nbRowstart = $_POST['id'];

//if ($this->nbRow < 0) {$this->nbRow = 10;}

//if (!isset($this->nbRow)) {$this->nbRow = 0;}



//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE

//LIMIT " . $start . ", 10";

           // $query = "SELECT * from links WHERE (user = '$this->user1') LIMIT 0 , 30";
//
// THIS QUERY ONLY SELECTS THE NUMBER OF ROWS DEFINED BY nbRow

            //$query = "SELECT * from links WHERE (user = '$this->user1') ORDER BY name asc LIMIT " . $this->nbRow . ", 10";
            $query = "SELECT * from links WHERE (user = '$this->user1') ORDER BY id desc LIMIT " . $this->nbRow . ", 10";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");

// 2ND QUERY SELECTS THE TOTAL NUMBER OF ROWS, needed for forward and back buttons

            $query2 = "SELECT * from links WHERE (user = '$this->user1')";
            $result2 = mysql_query($query2)
            or die ("Sorry, an error has occurred, please try again later.");

// CHECK IF NO ROWS WERE RETURNED

            if($result2==null){

            $errorMessage = array();

            $errorMessage['error'] = "no rows";

            return $errorMessage;

            }


            $numrows = mysql_num_rows($result2)
            or die ("could not count rows");

// SET UP "BACK" AND "FORWARD" BUTTONS TO SEE RESULTS
// 1ST IF SETS UP BACK BUTTON
            if ($this->nbRow > 0)
            {

           // $this->nbRow = $this->nbRow - 10;

// BUILD BACK BUTTON VALUE FOR ARRAY

            $this->backButton = $this->nbRow - 10;
            $this->backButtonStatus = "live";

            }

            else{

            $this->backButtonStatus = "inactive";


            }


// IF THERE ARE TEN ROWS MORE THAN THE NUMBER ALREADY IN nbRows then increment by 10

            if($numrows > ($this->nbRow + 10))
            {

            //$this->nbRow = $this->nbRow + 10;

// BUILD FORWARD BUTTON VALUE FOR ARRAY

            //$this->forwardButton = ($this->nbRow + 10) - $this->backButton;
            $this->forwardButton = $this->nbRow + 10;
            //$this->forwardButton = $this->nbRow;

            $this->forwardButtonStatus = "live";
//$string .="<div id='arrow'><a href='' id='" . ($start +10) . "'>Next</a><BR>\n</div>";

            }

            else{

            $this->forwardButtonStatus = "inactive";
            

            }



            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND



// WORKS BUT ONLY RETURNS ONE ROW TO FLASH
/*$categories = array();

while ($obj = mysql_fetch_array($result))
{
        $categories['id'] = $obj['id'];
        $categories['user'] = $obj['user'];
        $categories['name'] = $obj['name'];
        $categories['link'] = $obj['link'];
}*/

// END WORKS

// NEW TRIAL WITH COUNTER

$categories = array();

$i = "1";

while ($obj = mysql_fetch_array($result))
{
        //$categories[$i] = $obj['id'];
        $categories[$i]['id'] = $obj['id'];
        $categories[$i]['user'] = $obj['user'];
        $categories[$i]['name'] = $obj['name'];
        $categories[$i]['link'] = $obj['link'];
        $categories[$i]['saveBtn'] = "saveBtn";
        $categories[$i]['editBtn'] = "editBtn";
        $categories[$i]['textF'] = "textF";
        $categories[$i]['textG'] = "textG";

        //ADD INDICATOR OF NUMBER OF ROWS TO ARRAY

        $categories[$i]['nbRow'] = $this->nbRow;

        // FORWARD BUTTON

        $categories[$i]['forwardButton'] = $this->forwardButton;
        $categories[$i]['forwardButtonStatus'] = $this->forwardButtonStatus;

        // BACKWARD BUTTON

        $categories[$i]['backButton'] = $this->backButton;
        $categories[$i]['backButtonStatus'] = $this->backButtonStatus;

        //$categories[$i]['textG'] = "textG";

        $i++;
}


// END NEW TRIAL






/*$categories = array();
while ($obj = mysql_fetch_array($result))
{*/

/*$transport(array(id=> $obj['id'],
                 user=> $obj['user'],
                 name=> $obj['name'],
                 link=> $obj['link']
*/
/*$num=mysql_numrows($result);

 for ($i = 0; $i < $obj; $i++){

 $categories[$i]['id'] = $obj['id'];
 $categories[$i]['username'] = $obj['user'];
 $categories[$i]['name1'] = $obj['name'];
 $categories[$i]['link1'] = $obj['link'];
               //  )
           //);
 }*/
//}
        







/*            $string = "<table class='link_table'><tr><th>Link</th><th>Delete</th><th>Update</th></tr>";

if (mysql_num_rows($result) > 0){
  while($row = mysql_fetch_object($result)){

    //echo $row->id;
    //echo $row->user;
    //echo $row->link;

    $string .= "<tr class='test' id='".$row->id."'><td><div id='".$row->id."'><a href=".$row->link." id='".$row->id."'>".$row->name."</a></div></td>";
  //  $string .= "<td><a href='.$row->link_address' id='".$row->id."'>".$row->link_name."</a></td>";
    //$string .= "<td><a href='#' id='".$row->entry_id."'>".$row->comments."</a></td>";
     //$string .= "<td><a href='#' id='".$row->entry_id."'>".$row->total."</a></td>";

    //$string .= "<td>".$row->Name."</td>";
    //$string .= "<td>".$row->Description."</td>";
   // $string .= "<tr><td><div id='id'><a href='form.html?id=".$row->id."' id='id_target'>".$row->name."</a></div></td>";


   // Delete

   //$string .= "<tr><td><div id='id'><a href='javascript:void(0);' class ='dynamic' id='".$row->id."'>".$row->name."</a></div></td>";

   $string .= "<td><div id='id'><form name='form-delete' id='form-delete' action='http://wpc4000.amenworld.com/iduk2/joomla-overview/delete.html' method='post'><input type='hidden' name='id2' id='id2' value='".$row->id."'><input type='submit' class='link_button_delete' id='delete' value='delete'></form></td></div>";

   // PRINTS OUT UPDATE BUTTON

   $string .="<td><div id='id-update'><form name='form-update' id='form-update' action='http://wpc4000.amenworld.com/iduk2/joomla-overview/delete.html' method='post'><input type='submit' id='update' class='link_button' value='Update'></form></div></td></tr>";

   //$string .= "<td><div id='".$row->entry_id."'><a href='#' name='".$row->date."' id='".$row->task_number."' class ='update_button' value='".$row->entry_id."'> Update </a></div></td></tr>";

   //$string .= "<tr><td><div id='id'><a href='javascript:void(0);' class ='dynamic".$row->id."' id='".$row->id."'>".$row->name."</a></div></td>";


   // $string .= "<tr><td><div id ='form'><form action ='Search2.php' method='post' id='form2'>

             //   <input type = 'hidden' name='id' id='id' value =".$row->id.">

               // <input type = 'submit' name='submit' id='submit1' value ='select'></form></div></td>";
    //$string .= "<tr><td><div id='test2'><a href='#' id='id'>".$row->id."</a></div></td>";

    //$string .= $row->phone."</a>";
    //$string .= "<br/>\n";







  }

$string .= "</table>";

}*/

//echo $string;

//return $string;

//return $result;

return $categories;

//return $transport;

//return $this->user1;

}

//-------------------------------------------------

public function saveAllLinks($id, $name, $link)

{

// SET QUERY ELEMENTS

$this->id = $id;
$this->name = $name;
$this->link = $link;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "UPDATE links SET name = '$this->name', link = '$this->link'
                      WHERE id = '$this->id'";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");

// END QUERY


//$response['message'] = "Update completed successfully";
//$response = array();

$response = "complete";

return $response;



}








//------------------------------------------------



public function Select_All_Link2($user1)

{

// SET QUERY ELEMENTS

//$this->link_name = $link_name;
//$this->link_address = $link_address;
$this->user1 = $user1;

//$this->new_connection = $new_connection;

//echo "ok to here 3";

$this->new_connection = new Db_Connect();

//echo "ok to here4";

$this->open_db = $this->new_connection->initDB();

//echo "ok to here5";

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "SELECT * from links WHERE (user = '$this->user1') LIMIT 0 , 30";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

            $body = "";
	//$sql = mysql_query("SELECT id, firstname, sign_up_date FROM myMembers WHERE email_activated='1' ORDER BY id ASC LIMIT 10");

	while($row = mysql_fetch_array($result)){

		$id = $row["id"];
		$linkname = $row["name"];
		$link = $row["link"];
		//$sign_up_date = strftime("%b %d, %y", strtotime($sign_up_date));
		$body .= '<u><font color="#0000CC"><a href="' . $link . '" target="_blank">' . $linkname . '</a></font></u>    |    <font color="#FF0000">' . $id . '</font>      |      <font color="#9B9B9B">' . $sign_up_date . '</font><br /><br />';

    }
    //echo "returnBody=$body";

//echo $body;

//echo "ok to here5";

//echo $body;

    //echo "returnBody=$body";

    echo "returnBody=" . $body;

    mysql_close();
    exit();






}


public function deleteThisLink($id, $name, $link)

{

// SET QUERY ELEMENTS

$this->id = $id;
$this->name = $name;
$this->link = $link;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE
//Delete from customer_info where customer_id=’1’;

            $query = "DELETE from links
                      WHERE id = '$this->id'";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");

// END QUERY


//$response['message'] = "Update completed successfully";
//$response = array();

$response = "entry deleted";

return $response;



}


// ADD LINKS

public function addLinkNow($user, $name, $link)

{

// SET QUERY ELEMENTS

$this->user = $user;
//$this->id = $id;
$this->name = $name;
$this->link = $link;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE
//Delete from customer_info where customer_id=’1’;

            $query = "INSERT into links (user, name, link)
                      VALUES ('$this->user', '$this->name', '$this->link')";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");

// END QUERY


//$response['message'] = "Update completed successfully";
//$response = array();

$response = "entry deleted";

return $response;



}


// END ADD LINKS




}



?>
