<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Db_infop
 *
 * @author michael
 */
class Db_info {

    private $databaseURL = "localhost";
    private $databaseUName = "wordpressuser";
    private $databasePWord = "KzTUPTFAAKXn5vuQ";
    private $databaseName = "WordPress";

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