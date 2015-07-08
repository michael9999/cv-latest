<?php
/*
Plugin Name: On register plugin
Plugin URI: http://google.com
Description: Sets up links for user when he registers
Version: 1.0
Author: Michael Smuts
Author URI: http://www.google.com
License: A "Slug" license name e.g. GPL2
*/
?><?php

include_once('Perform_Query.php');
include_once('Db_Connect.php');
include_once('Db_info.php');

new cv_anglais_add_links;

class cv_anglais_add_links{

public $user_id;
public $user_info;

// include files


        // constructor

        function cv_anglais_add_links(){

            $this->__construct();

        }
        // sets up hook and declares which function should run

        function __construct(){

            add_action( 'user_register', array( &$this, 'cv_anglais_NS_questions' ) );

            //add hook for delete function

            add_action( 'delete_user', array( &$this, 'cv_anglais_delete_questions' ) );

//cv_anglais_delete_questions

        }

        function cv_anglais_NS_questions($user_id){

            // include scripts

            //include("Perform_Query.php");
            //include("Db_Connect.php");
            //include("Db_info.php");

            // get new users details

            $this->user_id = $user_id;

            $this->user_info = get_userdata($this->user_id);
            /*$user_info->user_login;
            $user_info->user_level;
            $user_info->ID;*/

            // set up connection to add links

            $connection2 = new Perform_Query()
            or die("connection3 failed");

            // perform query

            $query_ns_questions = $connection2->Add_Ns_Questions($this->user_info->user_login, "", "");

        }


            function cv_anglais_delete_questions($user_id){

            // include scripts

            //include("Perform_Query.php");
            //include("Db_Connect.php");
            //include("Db_info.php");

            // get new users details

            $this->user_id = $user_id;

            $this->user_info = get_userdata($this->user_id);
            /*$user_info->user_login;
            $user_info->user_level;
            $user_info->ID;*/

            // set up connection to add links

            $connection3 = new Perform_Query()
            or die("connection3 failed");

            // perform query

            $query_ns_questions = $connection3->Delete_Ns_Questions($this->user_info->user_login);

        }


}

// adds options to 1st class
?>