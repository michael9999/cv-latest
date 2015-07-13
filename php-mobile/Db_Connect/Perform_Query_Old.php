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




}



?>
