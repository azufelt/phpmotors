<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
  header('location: /phpmotors/');
  exit;
}
?><?php

  // Build the classifications option list
  $classificationList = '<select name="classificationId" id="classificationId">';
  $classificationList .= "<option>Choose a Car Classification</option>";
  foreach ($getCarClassifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'";
    if (isset($classificationId)) {
      if ($classification['classificationId'] === $classificationId) {
        $classificationList .= ' selected ';
      }
    } elseif (isset($invInfo['classificationId'])) {
      if ($classification['classificationId'] === $invInfo['classificationId']) {
        $classificationList .= ' selected ';
      }
    }
    $classificationList .= ">$classification[classificationName]</option>";
  }
  $classificationList .= '</select>';

  ?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php';
    ?>

<head>
  <title><?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
            echo "Modify $invInfo[invMake] $invInfo[invModel]";
          } elseif (isset($invMake) && isset($invModel)) {
            echo "Modify $invMake $invModel";
          } ?></title>
</head>
<main class="form-background">
  <section>
    <h1><?php if (isset($invInfo['invMake'])) {
          echo "Delete $invInfo[invMake] $invInfo[invModel]";
        } ?></h1>
    <p>Confirm Vehicle Deletion. The delete is permanent.</p>

    <form method="post" action="/phpmotors/vehicles/index.php">

      <fieldset>
        <legend></legend>
        <label for="classificationId"></label>
        <?php
        if (isset($message)) {
          echo $message;
        }
        echo $classificationList;
        ?>
        <label for="invMake">Vehicle Make</label>
        <input type="text" readonly name="invMake" id="invMake" <?php
                                                                if (isset($invInfo['invMake'])) {
                                                                  echo "value='$invInfo[invMake]'";
                                                                } ?>>

        <label for="invModel">Vehicle Model</label>
        <input type="text" readonly name="invModel" id="invModel" <?php
                                                                  if (isset($invInfo['invModel'])) {
                                                                    echo "value='$invInfo[invModel]'";
                                                                  } ?>>

        <label for="invDescription">Vehicle Description</label>
        <textarea name="invDescription" readonly id="invDescription"><?php
                                                                      if (isset($invInfo['invDescription'])) {
                                                                        echo $invInfo['invDescription'];
                                                                      }
                                                                      ?></textarea>

        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="deleteVehicle">
        <input type="hidden" name="invId" value="<?php if (isset($invInfo['invId'])) {
                                                    echo $invInfo['invId'];
                                                  } ?>">

        <input type="submit" name="submit" value="Delete Vehicle">

      </fieldset>
    </form>
  </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>