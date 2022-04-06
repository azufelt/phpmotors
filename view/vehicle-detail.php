<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

<main>
  <h1 class="pageTitle"><?php echo $getInfo['invMake'] . " " . $getInfo['invModel']; ?> </h1>
  <div class="details-wrapper">
    <?php if (isset($message)) {
      echo $message;
    }
    ?>
    <?php if (isset($vehicleDisplay)) {
      echo $vehicleDisplay;
    } ?>
    <?php if (isset($vehicleThumbnailImages)) {
      echo $vehicleThumbnailImages;
    } ?>

    <div class="reviewForm">
      <?php if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
      }
      ?>
      <h2>Customer Reviews:</h2>
      <?php if (isset($_SESSION['loggedin'])) {
        //display vehilce name
        //screen name box that is sticky and cannot be edited
        //textarea for the review
        //button, submit, then show a confirmation 

        echo '<h3>Review the ' . $getInfo['invMake'] . " " . $getInfo['invModel'] . '</h3>';
        $firstLetterName = substr($_SESSION['clientData']['clientFirstname'], 0, 1);
        echo '<fieldset>
  <legend></legend>
   <form method="post" action="/phpmotors/reviews/index.php">
 <label for="clientReview">Screen Name: 
  <input class="clientReview" type="text" id="clientReview" name="clientReview" value="' . $firstLetterName . ($_SESSION['clientData']['clientLastname']) . '">
  </label>
  <label for="reviewText">Review:
    <textarea id="reviewText" name="reviewText" rows="5" cols="33" required> </textarea></label>

        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="addReview">
        <input type="hidden" name="reviewDate" value="' . date("Y-m-d H:i:s") . '">
        <input type="hidden" name="clientId" value="' . $_SESSION['clientData']['clientId'] . '">
        <input type="hidden" name="invId" value="' . $getInfo['invId'] . '">
        <input type="submit" name="submit" value="Leave Review">
  </form>
</fieldset>';
      } else {
        echo '<p>You must <a href="/phpmotors/accounts/index.php?action=login">login</a> to write a review</p>';
      }
      // <!--display reviews below, if none display be the first-->
      if (isset($reviewList)) {
        echo $reviewList;
      }
      ?>


    </div>
  </div>
</main>