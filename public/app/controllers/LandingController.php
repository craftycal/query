<?php

//Need to change ControllerName to the controllers name
class LandingController extends PageController{

  //Contstructor
  public function __construct($dbc){

    // Run the parent Contstructor
    parent::__construct();

    $this->dbc = $dbc;

  }

  public function buildHTML(){



     echo $this->plates->render('landing');

  }

  // private function getQuestions(){
  //
  //   $sql = "SELECT question, date, owner_id FROM questions";
  //     $result = $this->dbc->query($sql);
  //     $questionsData = $result->fetch_assoc();
  //     $id = $questionsData('owner_id');
  //
  //   $sql = "SELECT username FROM userData WHERE user_id = '$id' ";
  //     $result = $this->dbc->query($sql);
  //     $questionsData = $result->fetch_assoc();
  //
  //
  // }



}
