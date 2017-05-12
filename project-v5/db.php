<?php
session_start();
$host = "localhost";
$user = "marcka14";
$pwd = "Be1VdnELNw";
$db = "marcka14_db";
$mysqli = new mysqli($host, $user, $pwd, $db);

try{
    $conn = new PDO("mysql:host=$host;dbname=$db;", $user, $pwd);
} catch(PDOException $e){
    die( "Connection to database failed!: " . $e->getMessage());
}
?>