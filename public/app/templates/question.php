<?php
  $this->layout('master', [
    'title'=>'view a question',
    'desc'=>'view and answer another users question'
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
  <div class="row">

<!-- question -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><?= $question['title'] ?></h3>
      </div>
      <div class="panel-body">
        <p><?= $question['description'] ?></p>
      </div>

      <?php if (isset($_SESSION['username']) && $_SESSION['username'] == $question['username']) {?>

      <div class="panel-body" >
        <div class="btn-group btn-group-sm" role="group" aria-label="...">
          <button type="button" class="btn btn-default">edit</button>
          <button type="button" class="btn btn-default">delete</button>
        </div>

      <?php } ?>

        <div class="pull-right">
          <p class="pull-right"><?= $question['date_'] ?></p>
        </div>
      </div>
    </div>

<!-- question end -->

<!-- replys -->
    <div class="container">

<!-- post -->
      <div class="row">
        <div class="col-sm-11 pull-right">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Username</h3>
            </div>
            <div class="panel-body">
              <p>Reply goes here</p>
            </div>

              <div class="panel-body" >
                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                  <button type="button" class="btn btn-default">edit</button>
                  <button type="button" class="btn btn-default">delete</button>
              </div>

              <div class="pull-right">
                <p id="data">00/00/00</p>
              </div>
            </div>
          </div>
          </div>

      </div>
<!-- post end -->

    </div> <!-- end replys -->



<div class="row">
  <div class="col-sm-12 pull-right">
    <div class="panel panel-default">
      <div class="panel panel-heading">
        <h3 class="panel-title">Your Answer</h3>
      </div>
      <div class="panel-body">

        <form action="index.php?page=question&question_id=<?= $item['question_id'] ?>" method="post">
          <textarea class="form-control" name="comment" rows="5"></textarea>

            <?php if( isset($commentMessage) ): ?>
              <p><span class="glyphicon glyphicon-info-sign"></span> <?= $commentMessage ?> </p>
            <?php endif ?>

          <div class="input-group">
            <input type="submit" name="comment" value="submit" class="btn btn-default">
          </div>
        </form>

      </div>
    </div>
  </div>
</div>



</div> <!-- row end -->
</div> <!-- container end -->
