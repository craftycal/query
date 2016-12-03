<?php
  $this->layout('master', [
    'title'=>'register',
    'desc'=>'register a new accout with query'
  ]);
?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="?page=landing">query <span class="glyphicon glyphicon-home"></span></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">search</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="?page=ask">ask <span class="glyphicon glyphicon-plus"></span></a></li>

        <?php if(isset($_SESSION['username'])){ ?>
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                 <?= ($_SESSION['username']); ?> <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="?page=logout">logout</a></li>
              </ul>
            </li>
        <?php } else { ?>
          <li><a href="?page=login">login</a></li>
          <li><a href="?page=register">register</a></li>
        <?php } ?>

      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<div class="container">

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">register</h3>
    </div>
    <div class="panel-body">

      <form action="?page=register" method="post">
<!--  username  -->
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon">username</span>
          <input type="text" name="username" class="form-control" aria-describedby="basic-addon1" value="<?= isset($_POST['username']) ? $_POST['username'] : '' ?>">
        </div>
          <?php if( isset($usernameMessage) ): ?>
            <p><span class="glyphicon glyphicon-info-sign"></span> <?= $usernameMessage ?> </p>
          <?php endif ?>
<br> <!--  Email  -->
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon">email</span>
          <input type="text" name="email" class="form-control" aria-describedby="basic-addon1" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
        </div>
          <?php if( isset($emailMessage) ): ?>
            <p><span class="glyphicon glyphicon-info-sign"></span> <?= $emailMessage ?> </p>
          <?php endif ?>
<br> <!--  Password  -->
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon">password</span>
          <input type="password" name="password" class="form-control" aria-describedby="basic-addon1">
        </div>
          <?php if( isset($passwordMessage) ): ?>
            <p><span class="glyphicon glyphicon-info-sign"></span> <?= $passwordMessage ?></p>
          </div>
          <?php endif ?>
<br>
        <div class="input-group">
          <input type="submit" name="regForm" value="submit" class="btn btn-default">
        </div>
      </form>
    </div>
  </div>
</div>
