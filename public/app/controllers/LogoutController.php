<?php

//Need to change ControllerName to the controllers name
class LogoutController extends PageController{

  //Contstructor
  public function __construct($dbc){

    // Run the parent Contstructor
    parent::__construct();

    $this->dbc = $dbc;

    if(isset($_SESSION['username'])){
      $this->processLogOut();
    }
  }

  public function buildHTML(){

     echo $this->plates->render('logout', $this->data);

  }

  private function processLogOut() {

    session_unset();
    session_destroy();

    header('Location: ?page=landing');
  }

}
