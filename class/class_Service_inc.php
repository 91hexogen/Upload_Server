<?php
// Datenbankergebnisse als Array liefern

class Service{
    private static $myPDO; // einmalig für alle Objekte

    // Konnektivität zur Datanbank
    private static function connectDB(){
      $host = "localhost"; // domain
      $db_name = "db_archivtect";
      $user = "root"; // Grundeinstellung MySQL Apache
      $pass = ""; // Grundeinstellung MySQL Apache

      SELF::$myPDO = new PDO("mysql:host=".$host,$user,$pass);

      try{
        SELF::$myPDO->query("USE ".$db_name); // Bereitstellung der Datenbank
        SELF::$myPDO->exec('SET NAMES uft8; SET CHARACTER SET UTF8');
      }
      catch(PDOException $e){
          exit("Error: ".$e->getMessage()); // Fehlermeldung zur Konnektivität
      }
    } // End of Service Class

    // Methode zum Anfragen an Datenbanken
    public static function getOne($sql){ //Soll SQL-Code entgegennehmen
        SELF::connectDB(); // Datenbank verbinden
        $res = SELF::$myPDO->query($sql); //DB Anfrage starten
        //$arr = SELF::$myPDO->errorInfo(); // Fehlermeldung SQL
        //echo $arr[2];
        return $res->fetchColumn(); // Man bekommt einen String zurück
    }

    // Methode zum schreiben in Datenbanken
    public static function setExec($sql){
        SELF::connectDB(); // Datenbank verbinden
        SELF::$myPDO->exec($sql); //Ausführen
        return SELF::$myPDO->LastInsertId(); //Aktuelle User ID
    }


    function getFetchAll(){
    return "DB-Ergebnis = Erfolgreich";
    }

}

 ?>
