<?php

//Need to change ControllerName to the controllers name
class RegisterController extends PageController{

  private $usernameMessage;
  private $emailMessage;
  private $passwordMessage;

  //Contstructor
  public function __construct($dbc){

    // Run the parent Contstructor
    parent::__construct();

    $this->dbc = $dbc;

    if( isset($_POST['regForm']) ) {
      $this->processRegistrationForm();
    }
  }

  public function buildHTML(){

    $data = [];

    if($this->usernameMessage != '') {
      $data['usernameMessage'] = $this->usernameMessage;
    }

    if($this->emailMessage != '') {
      $data['emailMessage'] = $this->emailMessage;
    }

    if($this->passwordMessage != '') {
      $data['passwordMessage'] = $this->passwordMessage;
    }

    //Replace templateName with name of file
     echo $this->plates->render('register', $data);

  }

  private function processRegistrationForm() {

    $totalErrors = 0;

    if( $_POST['username'] == '' ) {
			$this->usernameMessage = 'please provide a username';
			$totalErrors++;
		} elseif (strlen($_POST['username']) < 4 ){
      $this->usernameMessage = 'sorry username must be over 4 characters';
			$totalErrors++;
    } elseif (strlen($_POST['username']) > 20 ){
      $this->usernameMessage = 'sorry username must be under 20 characters';
			$totalErrors++;
    }elseif ( !preg_match('/^[A-Za-z0-9_.-]{4,20}$/', $_POST['username'])){
      $this->usernameMessage = 'sorry usernames must only consist of a-z A-Z 0-9_.';
			$totalErrors++;
    }

    if( $_POST['email'] == '' ) {
			$this->emailMessage = 'please provide your email address';
			$totalErrors++;
		} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $this->emailMessage = 'sorry the email address you provide is invalid';
      $totalErrors++;
    }

    if( $_POST['password'] == '' ) {
      $this->passwordMessage = 'please enter a password';
      $totalErrors++;
    } elseif (strlen($_POST['password']) < 8 ){
      $this->passwordMessage = 'a password must be a minimum of 8 characters';
			$totalErrors++;
    }

    $refineUsername = $this->dbc->real_escape_string( $_POST['username'] );
    $refineEmail = $this->dbc->real_escape_string( $_POST['email'] );

    $sql = "SELECT username, email FROM userData WHERE '$refineEmail' = email OR '$refineUsername' = username";
    $result = $this->dbc->query($sql);
    $userData = $result->fetch_assoc();

    if( $result->num_rows > 0 ) {

      if ($refineUsername == $userData['username']){
        $this->usernameMessage = 'sorry that username is already in uses';
        $totalErrors++;
      }

      if ($refineEmail == $userData['email']){
        $this->emailMessage = 'sorry thet email address is already registered';
        $totalErrors++;
      }
		}

    if ($totalErrors == 0){

      $hash = password_hash( $_POST['password'], PASSWORD_BCRYPT );

      $sql = "INSERT INTO userData (username, email, password) VALUES ('$refineUsername', '$refineEmail', '$hash')";
      $result = $this->dbc->query($sql);

      header('Location: ?page=landing');
    }

  }
}
