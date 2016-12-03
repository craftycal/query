<?php

//Need to change ControllerName to the controllers name
class searchController extends PageController{

  //Contstructor
  public function __construct($dbc){

    // Run the parent Contstructor
    parent::__construct();

    $this->dbc = $dbc;

  }

  public function buildHTML(){

    $this->getSearchedQuestions();
    //Replace templateName with name of file
     echo $this->plates->render('search', $this->data);
  }

  private function getSearchedQuestions(){

    // get the posted term
    $searchTerm = $this->dbc->real_escape_string( $_GET['searchTerm'] );

    // search questions title for term
    $sql = "SELECT questions.question_id, questions.title, questions.date_, user_data.username FROM questions INNER JOIN user_data ON questions.user_id=user_data.user_id WHERE questions.title LIKE % '$searchTerm'";
    // get the sql result
    $result = mysqli_query($this->dbc, $sql);
    // store result as an array
    $this->data['filterQuestions'] = mysqli_fetch_all($result, MYSQLI_ASSOC);

  }



}
