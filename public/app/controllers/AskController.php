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

    print_r ($data);

     echo $this->plates->render('ask', $data);
  }

  private function proccessAskForm(){

    $totalErrors = 0;

    if ( $_POST['title'] = '' ){
      $this->titleMessage = 'whats your question';
      $totalErrors ++;
    } elseif ( strlen( $_POST['title'] ) > 100 ) {
      $this->titleMessage = 'sorry you have exceeded the maximum charecters allowed: '.strlen($title).'/100';
      $totalErrors ++;
    }

    if ( $_POST['description'] = '' ){
      $this->descriptionMessage = 'please provide more details to help others better answer your query';
      $totalErrors ++;
    } elseif ( strlen( $_POST['description'] ) > 500 ) {
      $this->descriptionMessage = 'sorry you have exceeded the maximum charecters allowed: '.strlen($description).'/500';
      $totalErrors ++;
    }

    // $title = $this->dbc->real_escape_string( $_POST['title'] );
    // $description = $this->dbc->real_escape_string( $_POST['description'] );
    //
    // $sql = "SELECT title FROM questions WHERE '$title' = 	question";
    // $result = $this->dbc->query($sql);
    // $userData = $result->fetch_assoc();
    //
    // if( $result->num_rows > 0 ) {
    //
    //   if ($title == $userData['question']){
    //     $this->titleMessage = 'sorry this question has already been asked';
    //     $totalErrors++;
    //   }
    // }
    //
    // if ( $totalErrors == 0 ){
    //
    //     $sql = "INSERT INTO questions (question, description) VALUES ('$title', '$description'";
    //
    //     $result = $this->dbc->query($sql);
    //
    //     header('Location: ?page=landing');
    // }




  }

}
