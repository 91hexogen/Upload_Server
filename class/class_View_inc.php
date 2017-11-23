<?php

class View{
  private $template;
  private $output;
  const TEMPL = "templ/"; // Konstane


  function setTemplate($thema){
    $this->template = $thema;
  }

  function setLayout($data){
    ob_start(); // Eröffnet Puffer auf Server
    include_once(SELF::TEMPL."header.php");
    include_once(SELF::TEMPL.$this->template.".php");
    include_once(SELF::TEMPL."footer.php");

    $this->output = ob_get_contents();
    ob_end_clean(); // Puffer löschen

  }

  function toDisplay(){
    echo $this->output;
  }

}



 ?>
