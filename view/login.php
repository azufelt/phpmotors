<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
<main class="form-background">
  <section>
    <h1>Account Login</h1>
    <fieldset>
      <legend></legend>
      <?php
      if (isset($message)) {
        echo $message;
      }
      ?>
      <form action="/phpmotors/accounts/" method="post">
        <label for="clientEmail">Username:</label>
        <input type="text" id="clientEmail" name="clientEmail" size="40" placeholder="email" <?php if (isset($clientFirstname)) {
                                                                                                echo "value='$clientFirstname'";
                                                                                              }  ?> required /><br />
        <label for="clientPassword">Password:</label>
        <input type="password" id="clientPassword" name="clientPassword" size="40" placeholder="password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required />
        <p>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character.</p>

        <input type="hidden" name="action" value="userLogin">
        <input type="submit" value="Login" />

      </form>
      <p>Need an Account? <a href="/phpmotors/accounts/index.php?action=register">Sign-up</a>
      </p>
    </fieldset>
  </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>