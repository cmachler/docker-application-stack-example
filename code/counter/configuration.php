<?php

    // SETUP YOUR COUNTER
        // URL of the folder where script is installed. INCLUDE a trailing "/" !!!
        $base_url = 'http://counter.www.test.local:8080/counter/';        
                
        // database parameters
        $username=getenv('MYSQL_USER');
        $password=getenv('MYSQL_PASSWORD');    
        $servername="mariadb";
        $database=getenv('MYSQL_DATABASE');
        $tableName="countdetail";    
    
    // Optional parameters, if not sure leave with default values
        // Default image style (font)
        $default_style = 'web1';
        
        // Default counter image extension
        $default_ext = 'gif';
        
        // Minimum number of digits shown (zero-padding). Set to 0 to disable.
        $min_digits = 0;        
        
    // Don't change anything below
    
    /* Turn error notices off */
        error_reporting(E_ALL ^ E_NOTICE);
        
    $con = mysqli_connect($servername,$username,$password,$database);
    if (!$con)
         die('Cannot dadd comments at the moment');
      else
         $con->select_db($database) or die( "Unable to select database");
         
    /* This function handles input parameters making sure 
	nothing dangerous is passed in */    
    function input($in) {
    $out = htmlentities(stripslashes($in));
    $out = str_replace(array('/','\\'), '', $out);
    return $out;
    }     
?>
