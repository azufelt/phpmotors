<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

<main>
  <h1 class="pageTitle"><?php echo $classificationName; ?> vehicles</h1>
  <?php if (isset($message)) {
    echo $message;
  }
  ?>
  <?php if (isset($vehicleDisplay)) {
    echo $vehicleDisplay;
  } ?>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?><?php unset($_SESSION['message']); ?>