<?php
  $this->layout('master', [
    'title'=>'ask',
    'desc'=>'ask a new question'
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
        <li class="active"><a href="?page=ask">ask <span class="glyphicon glyphicon-plus"></span></a></li>

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
      <h3 class="panel-title">new query</h3>
    </div>
    <div class="panel-body">

      <form action="?page=ask" method="post">
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">question heading</span>
          <input name="title" type="text" class="form-control" aria-describedby="basic-addon1">
        </div>
          <?php if( isset($titleMessage) ): ?>
            <p><span class="glyphicon glyphicon-info-sign"></span> <?= $titleMessage ?> </p>
          <?php endif ?>
<br>
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">description</span>
          <textarea name="description" class="form-control" rows="10"></textarea>
        </div>
          <?php if( isset($descriptionMessage) ): ?>
            <p><span class="glyphicon glyphicon-info-sign"></span> <?= $descriptionMessage ?> </p>
          <?php endif ?>
<br>
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">tags</span>
          <input name="tags" type="text" value="" data-role="tagsinput" class="form-control" >
        </div>
<br>
        <div class="input-group">
          <input name="askForm" type="submit" value="submit" class="btn btn-default" aria-describedby="basic-addon1">
        </div>
      </form>

    </div>
  </div>

</div>
