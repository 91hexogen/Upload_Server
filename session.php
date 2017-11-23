<?php

//Session anlegen

echo "Sessiontest";
session_start(); //startet Session
echo "<br>";
echo "<br>";
echo "Meine Session-ID:".session_id(); //vom Server bereitgestellt

     //$_SESSION['user'] = "Otto";
if(isset($_SESSION['user'])){
    // $_SESSION['user'] = "angemeldet!";
    echo "<br>Angemeldet?: ".$_SESSION['user'];
}else{
    echo "<br>User abgemeldet!";
}

echo ini_get("session.gc_maxlifetime");

//echo "<br>Angemeldet?:".$_SESSION['user'];


?>
