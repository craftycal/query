<?php

//Need to change ControllerName to the controllers name
class LoginController extends PageController{

  private $usernameMessage;
  private $passwordMessage;
  private $loginMessage;

  //Contstructor
  public function __construct($dbc){

    // Run the parent Contstructor
    parent::__construct();

    $this->dbc = $dbc;

    if( isset($_POST['loginForm']) ) {
      $this->processLoginForm();
    }
  }

  public function buildHTML(){

    $data = [];

    if($this->usernameMessage != '') {
      $data['usernameMessage'] = $this->usernameMessage;
    }

    if($this->passwordMessage != '') {
      $data['passwordMessage'] = $this->passwordMessage;
    }

    if($this->loginMessage != '') {
      $data['loginMessage'] = $this->loginMessage;
    }

    //Replace templateName with name of file
     echo $this->plates->render('login', $data);

  }

  private function processLoginForm() {

    $totalErrors = 0;

    $username = $this->dbc->real_escape_string($_POST['username']);

    if ($username = ''){
      $this->usernameMessage = 'please enter your username';
      $totalErrors ++;
    }

    if ($password = ''){
      $this->passwordMessage = 'please enter your password';
      $totalErrors ++;
    }

    $username = $this->dbc->real_escape_string( $_POST['username']);
    $password = $this->dbc->real_escape_string( $_POST['password']);

    $username_found = false;
    $password_found = false;

    $sql = "SELECT username, password, privilege, user_id FROM user_data WHERE username = '$username' ";
      $result = $this->dbc->query($sql);
      $user_data = $result->fetch_assoc();

    if ( $result && $result->num_rows > 0 ) {
      $username_found = true;
    } else {
      $this->loginMessage = 'username or Password incorrect';
      $totalErrors++;
    }

    if ( password_verify ( $password, $user_data['password'] ) ) {
      $password_found = true;
    } else {
      $this->loginMessage = 'username or Password incorrect';
      $totalErrors++;
    }

    if ($password_found == true && $username_found == true ) {

      $_SESSION['username'] = $username;
      $_SESSION['id'] = $user_data['user_id'];
      $_SESSION['privilege'] = $user_data['privilege'];
      header('Location: ?page=landing');

    }

  }



}
