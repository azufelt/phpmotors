<?php
//if user is NOT logged in... use a header function to send them to the main PHP Motors controller
if (!($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 2) {
  header('Location: /phpmotors/');
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
    <h1><?php
        if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
          echo "Modify $invInfo[invMake] $invInfo[invModel]";
        } elseif (isset($invMake) && isset($invModel)) {
          echo "Modify$invMake $invModel";
        }
        ?></h1>
    <fieldset>
      <legend></legend>
      <form method="post" action="/phpmotors/vehicles/index.php"><label for="classificationId"></label>
        <?php
        if (isset($message)) {
          echo $message;
        }
        echo $classificationList;
        ?>

        <label for="invMake">Make: <input type="text" id="invMake" name="invMake" <input type="text" name="invMake" id="invMake" required <?php if (isset($invMake)) {
                                                                                                                                            echo "value='$invMake'";
                                                                                                                                          } elseif (isset($invInfo['invMake'])) {
                                                                                                                                            echo "value='$invInfo[invMake]'";
                                                                                                                                          } ?> /></label>

        <label for="invModel">Model: <input type="text" id="invModel" name="invModel" <input type="text" name="invModel" id="invModel" required <?php if (isset($invModel)) {
                                                                                                                                                  echo "value='$invModel'";
                                                                                                                                                } elseif (isset($invInfo['invModel'])) {
                                                                                                                                                  echo "value='$invInfo[invModel]'";
                                                                                                                                                } ?> /></label>

        <label for="invDescription">Vehicle Description:
          <textarea id="invDescription" name="invDescription" rows="5" cols="33"><?php if (isset($invDescription)) {
                                                                                    echo $invDescription;
                                                                                  } elseif (isset($invInfo['invDescription'])) {
                                                                                    echo $invInfo['invDescription'];
                                                                                  } ?></textarea></label>

        <label for="invImage">Image:</label>
        <input type="file" id="invImage" name="invImage" accept="image/png, image/jpg" <?php if (isset($invImage)) {
                                                                                          echo "value='$invImage'";
                                                                                        } elseif (isset($invInfo['invImage'])) {
                                                                                          echo "value='$invInfo[invImage]'";
                                                                                        } ?> />

        <label for="invThumbnail">Thumbnail:</label>
        <input type="file" id="invThumbnail" name="invThumbnail" <?php if (isset($invModel)) {
                                                                    echo "value='$invThumbnail'";
                                                                  } elseif (isset($invInfo['invThumbnail'])) {
                                                                    echo "value='$invInfo[invThumbnail]'";
                                                                  } ?> />
        <!-- ************* -->

        <label for="invPrice">Price:</label>
        <input type="number" id="invPrice" name="invPrice" <?php if (isset($invModel)) {
                                                              echo "value='$invPrice'";
                                                            } elseif (isset($invInfo['invPrice'])) {
                                                              echo "value='$invInfo[invPrice]'";
                                                            } ?> />

        <label for="invStock">Stock:</label>
        <input type="number" id="invStock" name="invStock" min="1" max="10" <?php if (isset($invStock)) {
                                                                              echo "value='$invStock'";
                                                                            } elseif (isset($invInfo['invStock'])) {
                                                                              echo "value='$invInfo[invStock]'";
                                                                            } ?> />

        <label for="invColor">Color:</label>
        <input type="color" id="invColor" name="invColor" value="" <?php if (isset($invColor)) {
                                                                      echo "value='$invColor'";
                                                                    } elseif (isset($invInfo['invColor'])) {
                                                                      echo "value='$invInfo[invColor]'";
                                                                    } ?> />

        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="updateVehicle">
        <input type="hidden" name="invId" value="
<?php if (isset($invInfo['invId'])) {
  echo $invInfo['invId'];
} elseif (isset($invId)) {
  echo $invId;
} ?>
">
        <input type="submit" name="submit" id="updatevehicle" value="Update Vehicle">
      </form>
    </fieldset>
  </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>