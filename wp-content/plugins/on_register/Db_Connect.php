<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Db_Connect
 *
 * CONNECTS TO DATABASE AND CORRECT TABLE
 *
 *
 *
 * @author michael
 */

//include("Db_info.php");

class Db_Connect {



    function initDB(){

/* Get Sectors from session */
            //echo "ok initDB";
            $Db_info2 = new Db_info();
            $databaseURL = $Db_info2->get_databaseURL();
            $databaseUName = $Db_info2->get_databaseUName();
            $databasePWord = $Db_info2->get_databasePWord();
            $databaseName = $Db_info2->get_databaseName();



            $connection = mysql_connect($databaseURL, $databaseUName, $databasePWord)
                or die ("Error while connecting to localhost 1".mysql_error());
            $db = mysql_select_db($databaseName, $connection)
                or die ("Error while connecting to database 2".mysql_error());

             mysql_set_charset('utf8', $connection);

            // SELECTS DATA FROM sectors table

            /*

            $query = "SELECT * FROM Sectors";
            $result = mysql_query($query);
            while($row = mysql_fetch_array($result)){
                    $rowArray[$rowID] = $row['Sector'];
                    $rowID = $rowID +1;
                }

                //Update the session with the sectors.
            $_SESSION['sectors']=$rowArray;

            mysql_close($connection);

             */
        }
    //$databaseURL = $_SESSION['databaseURL'];
    //$databaseUName = $_SESSION['databaseUName'];
    //$databasePWord = $_SESSION['databasePWord'];
    //$databaseName = $_SESSION['databaseName'];

    //$connection = mysql_connect($databaseURL, $databaseUName, $databasePWord);
        //or die ("Error while connecting to host");
   // $db = mysql_select_db($databaseName, $connection);
        //or die ("Error while connecting to database");
    //return $connection;
}

/*
DB Closing method.
Pass the connection variable
obtained through initDB().
*/
function closeDB($connection){
    mysql_close($connection);
}
//}
?>
