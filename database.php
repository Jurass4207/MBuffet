
<?php 
    $host = 'localhost';
    $dbuser = 'ciai_dbst';
    $dbpassword = '000000';
    $dbname = 'cbb111206';
    $link = mysqli_connect($host, $dbuser, $dbpassword, $dbname);
    if($link){
        mysqli_query($link,'SET NAMES utf8');
    }
    else{
        echo "Unconnected! </br>" . mysqli_connect_error();
    }
?>