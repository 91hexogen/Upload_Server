<?php

$host = "localhost"; // domain
$db_name = "db_archivtect";
$user = "root"; // Grundeinstellung MySQL Apache
$pass = ""; // Grundeinstellung MySQL Apache

// Erstellen der Instanz von PDO-Objekt
// PDO = Schnittstelle für Datenbanken

$myPDO = new PDO("mysql:host=".$host,$user,$pass);
try{
    $myPDO->exec('CREATE DATABASE IF NOT EXISTS '.$db_name);
}
catch(PDOException $e){
    exit("Error: ".$e->getMessage()); // Fehlermeldung zur Konnektivität
}
$myPDO->query("USE ".$db_name); // Bereitstellung der Datenbank

$sql = 'SET NAMES uft8; SET CHARACTER SET UTF8';

$myPDO->exec($sql);

$sqlArr[] = 'CREATE TABLE IF NOT EXISTS tb_password(
            id INT(11) AUTO_INCREMENT UNIQUE PRIMARY KEY,
            hash CHAR(128)
            )';


$sqlArr[] = 'CREATE TABLE IF NOT EXISTS tb_user(
            id INT(11) AUTO_INCREMENT UNIQUE PRIMARY KEY,
            name VARCHAR(40),
            email VARCHAR(256) UNIQUE,
            sex CHAR(1),
            id_pass INT(11),
            FOREIGN KEY (id_pass) REFERENCES tb_password(id)
            )';


$sqlArr[] = 'CREATE TABLE IF NOT EXISTS tb_salt(
            id INT(11) AUTO_INCREMENT UNIQUE PRIMARY KEY,
            salt CHAR(255),
            id_pass INT,
            FOREIGN KEY (id_pass) REFERENCES tb_password(id)

            )';


foreach ($sqlArr as $sql) {
    $myPDO->exec($sql);
    // Überprüfung SQL Konformität vom letzten SQL
    $arr = $myPDO->errorInfo();// Fehlermeldung SQL
    echo $arr[2]; //
}



echo "Datenbank angelegt";
 ?>
