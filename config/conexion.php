<?php
include 'config.php';
try
{
    $host=$config_bullcard['DB_HOST'];
    $dbname=$config_bullcard['DB_DATABASE'];
    $db_bullcard= new PDO("mysql:host=$host;dbname=$dbname",$config_bullcard['DB_USERNAME'],$config_bullcard['DB_PASSWORD']);
    $db_bullcard->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//new PDO("mysql:host=$hostname;dbname=mysql", $username, $password);
}
catch(PDOException $e)
{
    echo "Error:".$e->getMessage();
}
try
{
    $host_buygest=$config_buygest['DB_HOST'];
    $dbname_buygest=$config_buygest['DB_DATABASE'];
    $db_buygest= new PDO("mysql:host=$host_buygest;dbname=$dbname_buygest",$config_buygest['DB_USERNAME'],$config_buygest['DB_PASSWORD']);
    $db_buygest->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//new PDO("mysql:host=$hostname;dbname=mysql", $username, $password);
}
catch(PDOException $e)
{
    echo "Error:".$e->getMessage();
}
