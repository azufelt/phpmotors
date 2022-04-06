<?php
//if user is NOT logged in... use a header function to send them to the main PHP Motors controller
if (!($_SESSION['loggedin'])) {
  header('Location: /phpmotors/');
}
?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?><div>
</div>
<main class="form-background">
  <section>
    <h1>Welcome <?php
                echo $_SESSION['clientData']['clientFirstname'];
                echo ' ';
                echo $_SESSION['clientData']['clientLastname']; ?></h1>
  </section>
  <section>
    <h2>You are logged in.</h2>
    <?php
    if (isset($_SESSION['message'])) {
      echo $message = $_SESSION['message'];
    } ?>
    <ul>
      <li>First Name: <?php
                      echo $_SESSION['clientData']['clientFirstname']; ?></li>
      <li>Last Name: <?php
                      echo $_SESSION['clientData']['clientLastname']; ?></li>
      <li>Email: <?php
                  echo $_SESSION['clientData']['clientEmail']; ?></li>

    </ul>
    <h2>Account Management</h2>
    <p> Click here to manage/update account information</p>
    <a class="manbutton button" href="/phpmotors/accounts/index.php?action=modClient">Update My Account Info </a>

    <?php
    if ($_SESSION['clientData']['clientLevel'] > 1) {
      echo '<h2>Vehicle Management</h2>
      <p> Click here to manage vehicle inventory</p>
      <p>
      <a class="manbutton button" href="/phpmotors/vehicles/">Vehicle Management</a></p>';
    }
    ?>
    <?php if ($_SESSION['loggedin']) {
      if (isset($reviewList)) {
        echo $reviewList;
      }
    } ?>

  </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>