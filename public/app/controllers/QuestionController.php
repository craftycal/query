<?php

//Need to change ControllerName to the controllers name
class QuestionController extends PageController{

  private $commentMessage;

  //Contstructor
  public function __construct($dbc){

    // Run the parent Contstructor
    parent::__construct();

    $this->dbc = $dbc;

    $this->getQuestionData();

    if( isset($_POST['comment']) ) {
      $this->processCommentForm();
    }
  }

  public function buildHTML(){

    $data = [];

    if($this->commentMessage != '') {
      $data['commentMessage'] = $this->commentMessage;
    }

     echo $this->plates->render('question', $this->data);
  }


  private function getQuestionData(){

    // filter the id
    $questionID = $this->dbc->real_escape_string( $_GET['question_id'] );

    // get the question data
    $sql = "SELECT questions.question_id, questions.description, questions.title, questions.date_, userData.username FROM questions INNER JOIN userData ON questions.owner_id=userData.user_id WHERE questions.question_id = '$questionID'";

    // run the query
    $result = $this->dbc->query($sql);

    // if there was no result redirect to 404 page
    if (!$result || $result->num_rows == 0) {
      header('Location:?page=error');
    } else {
      // else success
      $this->data['question'] = $result->fetch_assoc();
    }

    // //  get the replys
    // $sql = "SELECT replys.reply, replys.date_, userData.username  FROM replys INNER JOIN userData ON userData.user_id = replys.owner_id WHERE replys.qusetion_id = '$questionID'";
    //
    // // run the query
    // $result = $this->dbc->query($sql);
    //
    // // put the resulting data in to associative array
    // $this->data['allReplys'] = $result->fetch_all(MYSQLI_ASSOC);



  }


  private function processCommentForm(){

    $totalErrors = 0;

    // if (!isset($_SESSION['id'])) {
    //   $this->commentMessage = 'you must be logged in to post a comment';
    //   $totalErrors++;
    // }
    //
    // if ( $_POST['comment'] == '' ) {
    //   $this->commentMessage = 'please enter your comment';
    //   $totalErrors++;
    // } elseif ( strlen ( $_POST['comment'] < 20) ){
    //   $this->commentMessage = 'your comment seems A little small could you elaborate';
    //   $totalErrors++;
    // } elseif ( strlen ( $_POST['comment'] > 500) ){
    //   $this->commentMessage = 'sorry maximum post of 500 characters';
    //   $totalErrors++;
    // }
    //
    // $refineComment = $this->dbc->real_escape_string( $_POST['comment'] );
    // $ownerID = $this->dbc->real_escape_string( $_SESSION['id'] );
    // $questionID = $this->dbc->real_escape_string( $_GET['question_id'] );

    if ($totalErrors == 0 ) {

      $sql = "INSERT INTO replys (owner_id, qusetion_id, reply) VALUES ('$ownerID', '$questionID', '$refineComment')";
      $result = $this->dbc->query($sql);
    }


  }



}
