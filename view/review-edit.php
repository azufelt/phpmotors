<?php
if (!$_SESSION['loggedin']) {
  header('Location: /phpmotors/');
  exit;
}

?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

<main class="form-background">
  <h1>Edit/Update Review:
  </h1>
  <?php
  if (isset($_SESSION['message'])) {
    echo $message = $_SESSION['message'];
  } ?>
  <section>
    <!-- dynamically populate the: 
        ·Type of Vehicle they are editing/reviewing
        · date review was made
        · textarea for editing the review
        · submit button to update the review-->
    <?php if (isset($reviewUpdate)) {
      echo $reviewUpdate;
    }  ?>
  </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>