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

    // this = the result of the function
    $this->getQuestions();

    echo $this->plates->render('landing', $this->data);
  }

  private function getQuestions(){

    // get the questions
    $sql = "SELECT questions.question_id, questions.title, questions.date_, userData.username FROM questions INNER JOIN userData ON questions.owner_id=userData.user_id";
      // get the sql result
      $result = mysqli_query($this->dbc, $sql);
      // store result as an array
      $this->data['allQuestions'] = mysqli_fetch_all($result, MYSQLI_ASSOC);






  }
}
