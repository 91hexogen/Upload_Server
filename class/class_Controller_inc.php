<?php

// Automatisches laden von benötigten Klassen

class Controller {
  private $request;
  private $tpl = "start"; //Starttemplates
  const UPATH = "upload/"; //Upload Path
  private $data = "";//
  // Initialisierung - Erster Aufruf in dem Programm
  // Der Constructor wird aufgerufen vom Controller
  function __construct(){
    session_start();

      $this->request = $_REQUEST;// Eingang
      // Test auf query string name
      switch(key($this->request)){
          case 'mail' ; case 'pass': $this->setLogin();
            break;
          case 'logout': $this->setLogout();
            break;
          case 'register': $this->tpl = "register";
            break;
          case 'savereg':$this->setRegister();
            break;
          case 'upload':$this->setUpload();
            break;
          default: ;
      }

      //$data = Model::getData();
      //$data = "";
      $view = new View(); // Rückgabe an Screen
      $view->setTemplate($this->tpl); //Login
      $view->setLayout($this->data);
      $view->toDisplay();
  }// End of Constructor


  private function setRegister(){
      $data = Model::setRegister(
        $this->request['rname'],
        $this->request['rmail'],
        $this->request['rpass'],
        $this->request['rsex']);
        if ($data !=0) {
          $this->tpl = "register_ok";//Fehlerseite
        }else{
          $this->tpl = "register_no";//Fehlerseite
        }
        //echo "erfolgreich:".$data;
  }


  // LOGIN
  private function setLogin(){
      //$salt = "133713371337";
      $salt = Model::getSalt($this->request['mail']);
      $hash = hash('sha512',$this->request['pass'].$salt);
      $data = Model::getPassOk($this->request['mail'],$hash);
      if($data){ // ID muss vorhanden sein // User vorhanden
        $_SESSION['user']=$data; // Session ID
        $this->tpl = "user_upload";
      };
  }
      //echo hash('sha512',$this->request['pass'].$salt);

      //echo $data;
      /*
      if($this->request['mail'] == "test@test.de" && $this->request['pass'] == "123"){
        $_SESSION['user']="true"; //Session anlegen
        echo $_SESSION['user'];
      }*/


 // LOGOUT
  private function setLogout(){
      session_destroy();
      header("Location: index.php");
  }

  public function getUserName(){
    $data = Model::getUserNameFromId($_SESSION['user']);
    return $data;
  }

  private function setUpload(){
    $datei = $_FILES['userfile']['name'];
    $uploadfile = SELF::UPATH.$datei;

    //MIME Type erkennen
    $zugelassen = array('image/jpeg','image/jpg','image/png','image/gif','application/pdf');
    if(!in_array($_FILES['userfile']['type'],$zugelassen)){
      $this->data = "Ihre Dateiformat ist nicht zugelassen!";
    }

    if($this->data == ""){
    // Upload starten
    if(move_uploaded_file($_FILES['userfile']['tmp_name'],$uploadfile)){
        $this->data = "Upload erfolgreich!";
    }else{
        $data = "Upload ist fehlgeschlagen!";
        switch ($_FILES['userfile']['error']) {
          case 1:$this->data = "Server lässt diese Größe nicht zu!";
            break;
          case 2:$this->data = "Datei zu ist groß!";
            break;
          case 3:$this->data = "Upload unvollständig!";
            break;
          case 4:$this->data = "Keine Datei vorhanden!";
            break;
          case 6:$this->data = "Keine temporäres Verzeichnis!";
            break;
          case 7:$this->data = "Schreibschutz Zielverzeichnis!";
            break;
          case 8:$this->data = "Eine PHP-Erweiterung verhindert das Speichern!";
            break;
            default: ;
          }
      }
    }
    $this->tpl = "user_upload"; //TMPL wird gesetzt
    }


}


 ?>
