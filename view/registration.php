<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>


<main class="form-background">
  <section>
    <h1>Register an Account</h1>
    <fieldset>
      <legend></legend>
      <?php
      if (isset($message)) {
        echo $message;
      }
      ?>


      <form method="post" action="/phpmotors/accounts/index.php">
        <label for="clientFirstname">First name:</label>
        <input type="text" id="clientFirstname" name="clientFirstname" placeholder="John" <?php if (isset($clientFirstname)) {
                                                                                            echo "value='$clientFirstname'";
                                                                                          }  ?> required />
        <label for="clientLastname">Last name:</label>
        <input type="text" id="clientLastname" name="clientLastname" placeholder="Doe" <?php if (isset($clientLastname)) {
                                                                                          echo "value='$clientLastname'";
                                                                                        }  ?> required />
        <label for="clientEmail">Email:</label>
        <input type="email" id="clientEmail" name="clientEmail" placeholder="johndoe@email.com" <?php if (isset($clientEmail)) {
                                                                                                  echo "value='$clientEmail'";
                                                                                                }  ?> required />
        <label for="clientPassword">Password:</label>
        <input type="password" id="clientPassword" name="clientPassword" placeholder="Password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required />
        <p>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character.</p>

        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="registerUser">

        <input type="submit" name="submit" id="regbtn" value="Register">
      </form>
    </fieldset>
  </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>