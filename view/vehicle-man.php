<?php
//if user is NOT logged in... use a header function to send them to the main PHP Motors controller
if (!($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 2) {
  header('Location: /phpmotors/');
  exit;
}
if (isset($_SESSION['message'])) {
  $message = $_SESSION['message'];
}


?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

<main>
  <h1>Add or Update a Vehicle</h1>
  <div class="horizontalFlex">
    <a class="manbutton button" href="/phpmotors/vehicles/index.php?action=adminAddclassification">Add Classification</a>
    <a class="manbutton button" href="/phpmotors/vehicles/index.php?action=vehicle">Add Vehicle</a>
  </div>
  <?php
  if (isset($message)) {
    echo $message;
  }
  if (isset($classificationList)) {
    echo '<h2>Vehicles By Classification</h2>';
    echo $classificationList;
  }
  ?>
  <noscript>
    <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
  </noscript>
  <table id="inventoryDisplay"></table>



  </form>
</main>
<script src="../js/inventory.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?><?php unset($_SESSION['message']); ?>