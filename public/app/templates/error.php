<?php
  $this->layout('master', [
    'title'=>'404',
    'desc'=>'a problem occured'
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
      <h3 class="panel-title">404</h3>
    </div>
    <div class="panel-body">

      <p>
        Sorry the page you are looking for could not be found.
      </p>

    </div>
  </div>

</div>
