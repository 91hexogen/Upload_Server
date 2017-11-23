<?php

// Automatisches laden von benötigten Klassen

class Model{
    /*function __construct(){
    echo "Die Model Instanz entsteht";
  }*/

    public function getPassOk($mail,$pass){
      $sql = "SELECT T1.id
              FROM tb_user T1, tb_password T2
              WHERE T1.email='{$mail}' AND T2.hash='{$pass}'
              AND T1.id_pass = T2.id
             ";
      return Service::getOne($sql);

    }

    public static function getSalt($mail){
      $sql = "SELECT T2.salt
              FROM tb_user T1, tb_salt T2
              WHERE T1.email = '{$mail}' AND T1.id_pass = T2.id_pass
             ";




      return Service::getOne($sql); //hier gibts das Salt
    }

    public static function setRegister($name,$mail,$pass,$sex){
      $salt ='';//leer
      for($i=1;$i<=10;$i++){
        $salt .= rand(0,9);
      }

      $hash = hash("sha512",$pass.$salt); // Hash erzeugen aus password und salt


      $sql = "INSERT INTO tb_password(hash)
              VALUES ('{$hash}')";
      $id= Service::setExec($sql);


      $sql = "INSERT INTO tb_salt(salt,id_pass)
              VALUES ('{$salt}',{$id})";
      Service::setExec($sql);


      $sql = "INSERT INTO tb_user(name,email,sex,id_pass)
              VALUES ('{$name}','{$mail}','{$sex}',{$id})";
      return Service::setExec($sql); // User - ID

    }

  public static function getUserNameFromId($id){
      $sql = "SELECT name FROM tb_user
              WHERE id={$id}";
              return Service::getOne($sql);
  }



  /*  function getData(){
      // Modellierung der Anfrage
      // Rückgabe der Datenbankergebnisse
      // Server entlasten, nur ein Connect
      return SERVICE::getFetchAll();
    }*/





    /*function __destruct(){
    echo "Ich war die Instanz Model";
  }*/

}// Ende CLass Model


 ?>
