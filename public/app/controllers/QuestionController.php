<?php

//Need to change ControllerName to the controllers name
class QuestionController extends PageController{

  private $replyMessage;
  private $descriptionMessage;
  private $editReplyMessage;

  //Contstructor
  public function __construct($dbc){

    // Run the parent Contstructor
    parent::__construct();

    $this->dbc = $dbc;

    $this->getQuestionData();

    if( isset($_POST['replySubmit']) ) {
      $this->processReplyForm();
    }

    if( isset($_GET['deleteReply']) ) {
      $this->deleteReply();
    }

    if( isset($_GET['deleteQuestion']) ) {
      $this->deleteQuestion();
    }

    if (isset($_POST['editQuestionForm'])){
        $this->editQuestion();
    }

    if (isset($_POST['editReplyForm'])){
        $this->editReply();
    }
  }

  public function buildHTML(){


     echo $this->plates->render('question', $this->data);

  }


  private function getQuestionData(){

    // filter the id
    $questionID = $this->dbc->real_escape_string( $_GET['question_id'] );

    // get the question data
    $sql = "SELECT questions.question_id, questions.description, questions.title, questions.date_, user_data.username FROM questions INNER JOIN user_data ON questions.owner_id=user_data.user_id WHERE questions.question_id = '$questionID'";

    // run the query
    $result = $this->dbc->query($sql);

    // if there was no result redirect to 404 page
    if (!$result || $result->num_rows == 0) {
      header('Location:?page=error');
    } else {
      // else success
      $this->data['question'] = $result->fetch_assoc();
    }

    //  get the replies
    $sql = "SELECT replies.reply, replies.date_, replies.reply_id, user_data.username   FROM replies INNER JOIN user_data ON user_data.user_id = replies.owner_id WHERE replies.qusetion_id = '$questionID'";

    // run the query
    $result = $this->dbc->query($sql);

    // put the resulting data in to associative array
    $this->data['replies'] = mysqli_fetch_all($result, MYSQLI_ASSOC);

  }


  private function processReplyForm(){

    $totalErrors = 0;

    // if logged in continue validation
    if (isset($_SESSION['id'])) {

      // validate the reply
      // has a reply been entered
      if ( $_POST['reply'] == '' ) {

        $this->data['replyMessage'] = 'please enter your reply';
        $totalErrors++;
      } elseif ( strlen ( $_POST['reply'] > 500) ){

        $this->data['replyMessage'] = 'sorry maximum post of 500 characters. '.strlen($_POST['reply']).'/500';
        $totalErrors++;
      }

      // escape and special characters
      $refinereply = $this->dbc->real_escape_string( $_POST['reply'] );
      $ownerID = $this->dbc->real_escape_string( $_SESSION['id'] );
      $questionID = $this->dbc->real_escape_string( $_GET['question_id'] );


      if ($totalErrors == 0 ) {

        $sql = "INSERT INTO replies (owner_id, qusetion_id, reply) VALUES ('$ownerID', '$questionID', '$refinereply')";
        $result = $this->dbc->query($sql);

        header('Location: index.php?page=question&question_id='.$_GET['question_id']);
      }

    } else {
      // if not logged in error +
      $this->data['replyMessage'] = 'you must be logged in to post a reply';
      $totalErrors++;
    }
  }

  private function deleteReply() {

    // is the user logged in
    if (isset($_SESSION['id'])) {

      // get the reply id, user id of the relpy owner and id of the logged in user
      $replyID = $this->dbc->real_escape_string ( $_GET['replyID']);
      $userID = $this->dbc->real_escape_string( $_SESSION['id']);

      // check to see if the logged in user is the owner of the comment or is an admin
      if ( isset( $userID ) && ($_SESSION['privilege'] == 'member')) {

        // delete the reply
        $sql = "DELETE FROM replies WHERE reply_id = '$replyID' AND owner_id = $userID";
        $result = $this->dbc->query($sql);
        header('Location: index.php?page=question&question_id='.$_GET['question_id']);

      } else if ($_SESSION['privilege'] == 'admin'){

        // delete the question
        $sql = "DELETE FROM replies WHERE reply_id = '$replyID' ";
        $result = $this->dbc->query($sql);
        header('Location: index.php?page=question&question_id='.$_GET['question_id']);
      }
    }
  }

  private function deleteQuestion() {

    if (isset($_SESSION['id'])) {

      $questionID = $this->dbc->real_escape_string ( $_GET['question_id']);
      $userID = $this->dbc->real_escape_string( $_SESSION['id']);

      if ( isset( $userID ) && ($_SESSION['privilege'] == 'member')) {

        // delete the question
        $sql = "DELETE FROM questions WHERE question_id = '$questionID' AND owner_id = $userID";
        $result = $this->dbc->query($sql);
        header('Location: index.php?page=landing');

      } else if ($_SESSION['privilege'] == 'admin'){

          // delete the question
          $sql = "DELETE FROM questions WHERE question_id = '$questionID' ";
          $result = $this->dbc->query($sql);
          header('Location: index.php?page=landing');
        }
      }
    }


  private function editQuestion() {

    $totalErrors = 0;

    if ( $_POST['description'] == '' ){
      $this->data['descriptionMessage'] = 'please provide more details to help others better answer your query';
      $totalErrors ++;

    } elseif ( strlen( $_POST['description'] ) > 1000 ) {
      $this->data['descriptionMessage'] = "sorry you have exceeded the maximum charecters allowed: ".strlen($_POST['description'])."/1000";
      $totalErrors ++;

    }

    if ( $totalErrors == 0 ){

      $questionID = $this->dbc->real_escape_string($_GET['question_id']);
      $userID = $this->dbc->real_escape_string( $_SESSION['id']);
      $description = $this->dbc->real_escape_string($_POST['description']);

      $sql = "UPDATE questions SET description = '$description' WHERE question_id = $questionID AND owner_id = $userID";
      $result = $this->dbc->query($sql);
      header('Location: index.php?page=question&question_id='.$_GET['question_id']);
    }
  }

  private function editReply() {

    $totalErrors = 0;

    // validate the reply
    if ( $_POST['reply'] == '' ) {
      $this->data['editReplyMessage'] = 'please enter your reply';
      $totalErrors++;
    } elseif ( strlen ( $_POST['reply'] > 500) ){
      $this->data['editReplyMessage'] = 'sorry maximum post of 500 characters. '.strlen( $_POST['reply'] ).'/500';
      $totalErrors++;
    }

    if ($totalErrors == 0 ) {

      // escape and special characters
      $refineReply = $this->dbc->real_escape_string( $_POST['reply'] );
      $replyID = $this->dbc->real_escape_string ( $_GET['replyID']);
      $userID = $this->dbc->real_escape_string( $_SESSION['id']);

      $sql = "UPDATE replies SET reply = '$refineReply' WHERE reply_id = $replyID AND owner_id = $userID ";
      $result = $this->dbc->query($sql);


      header('Location: index.php?page=question&question_id='.$_GET['question_id']);
    }
  }
}
