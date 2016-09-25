<?php

//Need to change ControllerName to the controllers name
class QuestionController extends PageController{

  //Contstructor
  public function __construct($dbc){

    // Run the parent Contstructor
    parent::__construct();

    $this->dbc = $dbc;

    //Call your functions
  }

  public function buildHTML(){
    //Replace templateName with name of file
     echo $this->plates->render('question', $this->data);
  }



}
