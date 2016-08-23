<?php

include("configuration.php");
date_default_timezone_set('America/Denver');
/* Get page and log file names */
$page       = input($_GET['page']) or die('ERROR: Missing page ID');    
$timestampInSeconds = $_SERVER['REQUEST_TIME']; 
$mySqlDateTime= date("Y-m-d H:i:s", $timestampInSeconds);
$sql = 'INSERT INTO '.$tableName.'(`id`, `Section`, `Date`, `IP`) 
VALUES (NULL, \''.$page.'\',\''.$mySqlDateTime.'\', \''.$_SERVER['REMOTE_ADDR'].'\');';
$con->select_db($database);
mysqli_query($con, $sql);

$query='SELECT COUNT( * ) total FROM  '.$tableName.' where section=\''.$page.'\'';
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result, MYSQLI_NUM);
$count = $row[0];

$query='SELECT  count(distinct IP) FROM '.$tableName.' where section=\''.$page.'\'';
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result, MYSQLI_NUM);
$UniaquCount = $row[0];
mysqli_close($con);

/* Get style and extension information */
$style      = input($_GET['style']) or $style = $default_style;
$style_dir  = 'styles/' . $style . '/';
$ext        = input($_GET['ext']) or $ext = $default_ext;

    $count = $count + 1;      
    if ($min_digits > 0) 
        $count = sprintf('%0'.$min_digits.'s',$count);
    
    /* Print out Javascript code and exit */
    echo 'document.write(\'   Vists: \');';
    $len = strlen($count);

    for ($i=0;$i<$len;$i++)
        echo 'document.write(\'<img src="'.$base_url . $style_dir . substr(
           $count,$i,1) . '.' . $ext .'" border="0">\');';    

    echo 'document.write(\'<br>\');';
    echo 'document.write(\'Vistors: \');';
    $len = strlen($UniaquCount);    
    for ($i=0;$i<$len;$i++) 
        echo 'document.write(\'<img src="'.$base_url . $style_dir . substr(
            $UniaquCount,$i,1) . '.' . $ext .'" border="0">\');';    
   exit();
?>
