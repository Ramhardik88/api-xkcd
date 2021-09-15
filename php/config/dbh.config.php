<?php

$serverName ="localhost";
$dbUsername ="root";
$dbPassword ="";
$dbName ="rtcamp_xkcd";


$conn = mysqli_connect($serverName,$dbUsername,$dbPassword,$dbName);

if(!$conn){
    die("Connecton failed:  ". mysqli_connect_error());
}

