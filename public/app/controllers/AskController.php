<?php

//Need to change ControllerName to the controllers name
class AskController extends PageController{

  private $titleMessage;
  private $descriptionMessage;

  //Contstructor
  public function __construct($dbc){

    // Run the parent Contstructor
    parent::__construct();

    $this->dbc = $dbc;

    if (isset($_POST['askForm'])){
        $this->proccessAskForm();
    }
  }

  public function buildHTML(){

    $data = [];

    if($this->titleMessage != '') {
      $data['titleMessage'] = $this->titleMessage;
    }

    if($this->descriptionMessage != '') {
      $data['descriptionMessage'] = $this->descriptionMessage;
    }

     echo $this->plates->render('ask', $data);
  }

  private function proccessAskForm(){

    $totalErrors = 0;

    if ( $_POST['title'] == '' ){
      $this->titleMessage = 'whats your question';
      $totalErrors ++;
    } elseif ( strlen( $_POST['title'] ) > 100 ) {
      $this->titleMessage = "sorry you have exceeded the maximum charecters allowed: ".strlen($_POST['title'])."/100";
      $totalErrors ++;
    }

    if ( $_POST['description'] == '' ){
      $this->descriptionMessage = 'please provide more details to help others better answer your query';
      $totalErrors ++;
    } elseif ( strlen( $_POST['description'] ) > 1000 ) {
      $this->descriptionMessage = "sorry you have exceeded the maximum charecters allowed: ".strlen($_POST['description'])."/1000";
      $totalErrors ++;
    }

    $title = $this->dbc->real_escape_string( $_POST['title'] );
    $description = $this->dbc->real_escape_string( $_POST['description'] );

    $sql = "SELECT title FROM questions WHERE '$title' = 	question";
    $result = $this->dbc->query($sql);
    $questionData[] = $result->fetch_assoc();

    if( $result == false ) {

      if ($title == $questionData['question']){
        $this->titleMessage = 'sorry this question has already been asked';
        $totalErrors++;
      }
    }

    if ( $totalErrors == 0 ){


        // $sql = "INSERT INTO questions (title, description) VALUES ('$title', '$description'";
        //
        // $result = $this->dbc->query($sql);
        //
        // header('Location: ?page=landing');

    }




  }

}
