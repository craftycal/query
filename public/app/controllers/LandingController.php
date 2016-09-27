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
    $questionsData = $this->getQuestions();

    // data as an array
		$data = [];

		$data['allQuestions'] = $questionsData;

    echo $this->plates->render('landing', $data);
  }

  private function getQuestions(){

    // get the questions
    $sql = "SELECT question_id, title, date_, owner_id FROM questions";
      // get the sql result
      $result = mysqli_query($this->dbc, $sql);
      // store result as an array
      $questionsData = mysqli_fetch_assoc($result);

    return $questionsData;
  }
}
