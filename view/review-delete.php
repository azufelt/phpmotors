<?php
if (!$_SESSION['loggedin']) {
  header('Location: /phpmotors/');
  exit;
}

?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

<main class="form-background">
  <h1>Delete Review:</h1>
  <?php
  if (isset($_SESSION['message'])) {
    echo $message = $_SESSION['message'];
  } ?>
  <section>
    <!-- delete the review -->
    <?php if (isset($reviewUpdate)) {
      echo $reviewUpdate;
    }  ?>
  </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>