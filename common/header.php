<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="PHP Motors delorean awesome cars " />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="/phpmotors/css/main.css" type="text/css" rel="stylesheet" media="screen">
  <link href="/phpmotors/css/large.css" type="text/css" rel="stylesheet" media="screen">
  <link rel="shortcut icon" href="favicon.ico" />
  <title><?php if (isset($pageTitle)) {
            echo $pageTitle;
          } ?>| PHP Motors</title>
</head>

<body>
  <header>
    <picture>
      <source media="(min-width:465px)" srcset="/phpmotors/images/site/logo-copy.png">
      <img src="/phpmotors/images/site/logo-copy.png" alt="PHP Motos logo" />
    </picture>



    <?php
    if (isset($_SESSION['clientData']['clientFirstname'])) {
      echo '<span><a href="/phpmotors/accounts/">
     ', $_SESSION['clientData']['clientFirstname'],
      '</a><span class="orBar"> | </span><a href="/phpmotors/accounts/index.php?action=logout">  Logout</a></span>';
    }
    if (!isset($_SESSION['clientData']['clientFirstname'])) {
      echo '<a href="/phpmotors/accounts/index.php?action=login">
      <p class="accountLink">My Account</p>
    </a>';
    }
    ?>

    <!-- <a href="/phpmotors/accounts/index.php?action=login">
      <p class="accountLink">My Account</p>
    </a> -->
  </header>
  <nav>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; ?>


  </nav>