<?php
session_start();
define('BASE','http://localhost/ly/');

$config['dbname']='g1';
$config['host']='localhost';
$config['dbuser']='root';
$config['dbpass']='';


try{
    $pdo=new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'],$config['dbuser'],$config['dbpass']);
}catch(PDOException $e){
    echo "erro! ".$e->getMessage();
}
