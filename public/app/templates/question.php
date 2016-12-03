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

        <!-- if the user has requested an edit -->
        <?php if (isset($_GET['editQuestion'])) { ?>
        <form action="index.php?page=question&amp;question_id=<?= $_GET['question_id']; ?>" method="post">

          <!-- description input -->
          <textarea name="description" class="form-control" rows="10"><?= $question['description']; ?></textarea>

          <!-- description error message  -->
          <div class="input-group">
            <!-- submit -->
            <input name="editQuestionForm" type="submit" value="submit" class="btn btn-default">
            <!-- cancel -->
            <a href="index.php?page=question&amp;question_id=<?= $_GET['question_id']; ?>" class="btn btn-default" ><span class="glyphicon glyphicon-remove"></span></a></li>
          </div>

        </form>
        <?php } else { ?>

          <p><?= htmlentities($question['description']) ?></p>

          <?php if( isset($descriptionMessage) ): ?>
            <p><span class="glyphicon glyphicon-info-sign"></span> <?= $descriptionMessage ?></p>
          <?php endif ?>

        <?php } ?>
      </div>
      <div class="panel-body" >
      <!-- display the Edit and Delete dropdown only for the owner or admin-->

    <?php if (isset($_SESSION['username']) && $_SESSION['username'] == $question['username'] || isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin' ) {?>
      <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="glyphicon glyphicon-cog"></span> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
          <?php if (isset($_SESSION['username']) && $_SESSION['username'] == $question['username']) {?>
            <li><a href="<?= $_SERVER['REQUEST_URI'] ?>&amp;editQuestion">Edit</a></li>
          <?php } ?>

          <?php if (isset($_SESSION['username']) && $_SESSION['username'] == $question['username'] || isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin' ) {?>
            <li><a href="<?= $_SERVER['REQUEST_URI'] ?>&amp;deleteQuestion">Delete</a></li>
          <?php } ?>
        </ul>
      </div>
    <?php } ?>

        <div class="pull-right">
          <p><?= $question['username'] ?></p>
          <p class="pull-right"><?= $question['date_'] ?></p>
        </div>
      </div>
    </div><!-- question end -->

    <div class="container"><!-- replies -->
    <!-- foreach to display all replies -->
    <?php foreach($replies as $reply): ?>
      <div class="row">
        <div class="col-sm-11 pull-right">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><?= ($reply['username']) ?></h3>
            </div>
            <div class="panel-body">

              <?php if (isset($_GET['editReply']) && $reply['reply_id'] == $_GET['replyID'] ) { ?>

                <form action="index.php?page=question&amp;question_id=<?= $_GET['question_id']; ?>&replyID=<?= $_GET['replyID'] ?>" method="post">
                  <textarea class="form-control" name="reply" rows="5"><?= $reply['reply']; ?></textarea>

                  <div class="input-group">
                    <!-- submit -->
                    <input name="editReplyForm" type="submit" value="submit" class="btn btn-default">
                    <!-- cancel -->
                    <a href="index.php?page=question&amp;question_id=<?= $_GET['question_id']; ?>" class="btn btn-default" ><span class="glyphicon glyphicon-remove"></span></a></li>
                  </div>
                </form>

              <?php } else { ?>
                <p> <?= (htmlentities($reply['reply'])) ?></p>
              <?php } ?>

              <?php if( isset($editReplyMessage) ): ?>
                <p><span class="glyphicon glyphicon-info-sign"></span><?= $editReplyMessage ?></p>
              <?php endif ?>

            </div>
            <div class="panel-body" >

              <!-- display the Edit and Delete buttons only for the owner -->
              <?php if (isset($_SESSION['username']) && $_SESSION['username'] == $reply['username'] || isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin' ) {?>
              <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="glyphicon glyphicon-cog"></span> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">

                  <?php if (isset($_SESSION['username']) && $_SESSION['username'] == $reply['username']) {?>
                    <li><a href="<?= $_SERVER['REQUEST_URI'] ?>&amp;editReply&amp;replyID=<?=$reply['reply_id']?>">Edit</a></li>
                  <?php } ?>

                  <?php if (isset($_SESSION['username']) && $_SESSION['username'] == $reply['username'] || isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin' ) {?>
                    <li><a href="<?= $_SERVER['REQUEST_URI'] ?>&amp;deleteReply&amp;replyID=<?=$reply['reply_id']?>">Delete</a></li>
                  <?php } ?>

                </ul>
              </div>
              <?php } ?>

              <div class="pull-right">
                <p id="data"><?= ($reply['date_']) ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>

    </div> <!-- end replies -->



    <div class="row">
      <div class="col-sm-12 pull-right">
        <div class="panel panel-default">
          <div class="panel panel-heading">
            <h3 class="panel-title">Your Answer</h3>
          </div>
          <div class="panel-body">
            <form action="index.php?page=question&amp;question_id=<?= $_GET['question_id']; ?>" method="post">
              <textarea class="form-control" name="reply" rows="5"><?= isset($_POST['reply']) ? $_POST['reply'] : '' ?></textarea>

                <?php if( isset($replyMessage) ): ?>
                  <p><span class="glyphicon glyphicon-info-sign"></span> <?= $replyMessage ?> </p>
                <?php endif ?>

              <div class="input-group">
                <input type="submit" name="replySubmit" value="submit" class="btn btn-default">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div> <!-- row end -->
</div> <!-- container end -->
