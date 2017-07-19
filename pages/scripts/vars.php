<?php

/* Vars for Research Portal resource *
 * Coder: Stefano Pirro'
 * Institution: Barts Cancer Institute
 * Details: This page lists all the variables necessary for mySQL database connection and other*/

// connection vars to mySQL database for BoB
$bob_mysql_address='localhost';
$bob_mysql_username='biomart';
$bob_mysql_password='biomart76qmul'; // in next release, the password will be encrypted
$bob_mysql_database='BCNTB';

// tables
$articles_table = "Articles";
$keywords_table = "Keywords";
$articles_keywords_table = "Articles_Keywords";
$ccle_table = "ccle";
$bcntbreturn_table = "bcntbreturn";

// initialising directories
$relative_root_dir = "http://".$_SERVER['SERVER_NAME'].":9003/bcntb_proto/";
$absolute_root_dir = $_SERVER['DOCUMENT_ROOT']."/bcntb_proto/";

?>
