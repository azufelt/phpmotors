<?php
if (!$_SESSION['loggedin']) {
  header('Location: /phpmotors/');
  exit;
}

?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>


<main class="form-background">
  <h1> <?php if (isset($clientFirstname)) {
          echo $clientFirstname;
        } elseif (isset($_SESSION['clientData']['clientFirstname'])) {
          echo $_SESSION['clientData']['clientFirstname'];
        }
        ?>'s Account Information </h1>
  <section>
    <h2>Update Account Info</h2>
    <fieldset>
      <legend></legend>
      <?php
      if (isset($message)) {
        echo $message;
      }
      // echo '<pre>' . print_r($_SESSION, true) . '</pre>';
      ?>


      <form method="post" action="/phpmotors/accounts/index.php">
        <label for="clientFirstname">First name:</label>
        <input type="text" id="clientFirstname" name="clientFirstname" placeholder="John" <?php if (isset($clientFirstname)) {
                                                                                            echo "value='$clientFirstname'";
                                                                                          } elseif (isset($_SESSION['clientData']['clientFirstname'])) {
                                                                                            echo "value='" . $_SESSION['clientData']['clientFirstname'] . "'";
                                                                                          }
                                                                                          ?> required />


        <!-- ************* -->

        <label for="clientLastname">Last name:</label>
        <input type="text" id="clientLastname" name="clientLastname" placeholder="Doe" <?php if (isset($clientLastname)) {
                                                                                          echo "value='$clientLastname'";
                                                                                        } elseif (isset($_SESSION['clientData']['clientLastname'])) {
                                                                                          echo "value='" . $_SESSION['clientData']['clientLastname'] . "'";
                                                                                        } ?> required />
        <label for="clientEmail">Email:</label>
        <input type="email" id="clientEmail" name="clientEmail" placeholder="johndoe@email.com" <?php if (isset($clientEmail)) {
                                                                                                  echo "value='$clientEmail'";
                                                                                                } elseif (isset($_SESSION['clientData']['clientEmail'])) {
                                                                                                  echo "value='" . $_SESSION['clientData']['clientEmail'] . "'";
                                                                                                } ?> required />
        <input type="hidden" name="action" value="updateClient">
        <input type="hidden" name="clientId" value="
<?php if (isset($clientInfo['clientId'])) {
  echo $clientInfo['clientId'];
} elseif (isset($_SESSION['clientData']['clientId'])) {
  echo $_SESSION['clientData']['clientId'];
} ?>
">
        <input type="submit" name="submit" id="updateClient" value="Update Account">
      </form>
    </fieldset>
    <h2> Change Password</h2>
    <fieldset>

      <legend></legend>
      <form method="post" action="/phpmotors/accounts/index.php">
        <label for="clientPassword">Password:</label>
        <input type="password" id="clientPassword" name="clientPassword" placeholder="Password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required />
        <p>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character.</p>

        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="updatePassword">
        <input type="hidden" name="clientId" value="
<?php if (isset($clientInfo['clientId'])) {
  echo $clientInfo['clientId'];
} elseif (isset($_SESSION['clientData']['clientId'])) {
  echo
  $_SESSION['clientData']['clientId'];
} ?>
">
        <input type="submit" name="submit" id="updatePassword" value="Update Password">
      </form>
    </fieldset>
  </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>