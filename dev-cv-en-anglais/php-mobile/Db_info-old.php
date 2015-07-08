<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Db_info
 *
 * @author michael
 */
class Db_info {

    private $databaseURL = "localhost:3306";
    private $databaseUName = "usoeur1.topadmin";
    private $databasePWord = "appletree44";
    private $databaseName = "iduk_personalised";

    function get_databaseURL(){
            return $this->databaseURL;
        }
    function get_databaseUName(){
            return $this->databaseUName;
        }
    function get_databasePWord(){
            return $this->databasePWord;
        }
    function get_databaseName(){
            return $this->databaseName;
        }

}
?>
