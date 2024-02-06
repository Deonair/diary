<?php
require_once 'src/dbclass.php';
require_once("src/session.php");


$s = file_get_contents('forms/dstore');
$gn = unserialize($s)

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="css/welkom.css">
  <title>Welcomepage</title>
</head>

<body>
  <!--navbar-->
  <nav class="navbar navbar-dark navbar-expand-md fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="diary.php"><img src="img/diarylogo.png" width="50px" height="62"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="src/uitloggen.php?logout=true"><img src="img/person.png">Logout</a>
          </li>


          <li class="nav-item">
            <a class="nav-link" href="newdiary.php"><img src="img/plus.png">Create Diary</a>
          </li>



        </ul>
      </div>
    </div>

  </nav>
  <br>
  <br>
  <br><br><br>
  <h1>Welcome <?php $gn->vnw(); ?></h1>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-sm">
        <a href="newdiary.php">
          <img src="img/dagboektoevoegen.png" width="175px" height="175px"><br>
          Create Diary
        </a>
      </div>
      <div class="col-sm">
        <a href="library.php">
          <img src="img/library.png" width="175px" height="175px"><br>
          Library
        </a>
      </div>

      <div class="col-sm">
        <a href="newstory.php">
          <img src="img/newstory.png" width="175px" height="175px"><br>
          Create Story
        </a>
      </div>

    </div>
  </div>

  <br>

  <div class="container">
    <div class="row">
      <div class="col-sm">
        <a href="gegevenswijzigen.php">
          <img src="img/gegevenstoepassen.png" width="175px" height="175px"><br>
          Change Data
        </a>
      </div>
      <div class="col-sm">
        <a href="deleteaccount.php">
          <img src="img/accountverwijderen.png" width="175px" height="175px"><br>
          Delete Account
        </a>
      </div>
      <div class="col-sm">
        <a href="diarydelete.php">
          <img src="img/dagboekdelete.png" width="175px" height="175px"><br>
          Delete Diary
        </a>
      </div>

    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</html>