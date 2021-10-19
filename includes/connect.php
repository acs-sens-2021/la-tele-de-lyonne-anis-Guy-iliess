<?php

const DBHOST = 'localhost';


const DBUSER = 'root';

const DBPASS= '';


const DBNAME = 'yonnetv';



$dsn = 'mysql:dbname='  . DBNAME . ';host=' . DBHOST;


try{

    $db = new PDO($dsn, DBUSER, DBPASS);

 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $db->exec('SET NAMES utf8');
    
}catch(PDOException $e){
   
die($e->getMessage());
}