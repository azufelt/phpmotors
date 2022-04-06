<?php
//if user is NOT logged in... use a header function to send them to the main PHP Motors controller
if (!($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 2) {
  header('Location: /phpmotors/');
  exit;
}
?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>


<main class="form-background">
  <section>
    <h1>Add a Car Classification</h1>
    <fieldset>
      <legend></legend>
      <?php
      if (isset($message)) {
        echo $message;
      }
      ?>

      <form method="post" action="/phpmotors/vehicles/index.php">

        <label for="addclassificationName">Classification:<input type="text" id="addclassificationName" name="classificationName" placeholder='ex. " Motorcycle"' maxlength="30" required /><span>*30 Characters Max</span></label>


        <!-- Add the action name - value pair -->
        <!-- <label for="addCarClassification"></label> -->
        <input type="hidden" name="action" value="addCarClassification">

        <!-- <label for="classificationName"></label> -->
        <input class="button" type="submit" name="submit" id="classificationName" value="Add Car">



      </form>
    </fieldset>

  </section>
</main>
<script src="../js/inventory.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>