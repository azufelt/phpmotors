<?php
//if user is NOT logged in... use a header function to send them to the main PHP Motors controller
if (!($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 2) {
  header('Location: /phpmotors/');
  exit;
}
?><?php

  //Build the select list
  $classificationList = '<label for="classificationId"></label><select name="classificationId" id="classificationId"><option value="">Choose Car Classification</option>';

  foreach ($getCarClassifications as $carclassification) {
    $classificationList .= "<option value='$carclassification[classificationId]'";
    if (isset($classificationId)) {
      if ($carclassification['classificationId'] === $classificationId) {
        $classificationList .= ' selected ';
      }
    }
    $classificationList .= ">$carclassification[classificationName]</option>";
  }
  $classificationList .= '</select>';

  ?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php';
    ?>
<main class="form-background">
  <section>
    <h1>Add a Vehicle</h1>
    <fieldset>
      <legend></legend>
      <form method="post" action="/phpmotors/vehicles/index.php"><label for="classificationId"></label>
        <?php
        if (isset($message)) {
          echo $message;
        }
        echo $classificationList;
        ?>

        <label for="invMake">Make: <input type="text" id="invMake" name="invMake" <?php if (isset($invMake)) {
                                                                                    echo "value='$invMake'";
                                                                                  }  ?> required></label>

        <label for="invModel">Model: <input type="text" id="invModel" name="invModel" <?php if (isset($invModel)) {
                                                                                        echo "value='$invModel'";
                                                                                      }  ?> required /></label>

        <label for="invDescription">Vehicle Description:
          <textarea id="invDescription" name="invDescription" rows="5" cols="33" required><?php if (isset($invDescription)) {
                                                                                            echo $invDescription;
                                                                                          }  ?></textarea></label>

        <label for="invImage">Image:</label>
        <input type="file" id="invImage" name="invImage" accept="image/png, image/jpeg" <?php if (isset($invImage)) {
                                                                                          echo "value='$invImage'";
                                                                                        }  ?> required />

        <label for="invThumbnail">Thumbnail:</label>
        <input type="file" id="invThumbnail" name="invThumbnail" <?php if (isset($invThumbnail)) {
                                                                    echo "value='$invThumbnail'";
                                                                  }  ?> required />

        <label for="invPrice">Price:</label>
        <input type="number" id="invPrice" name="invPrice" <?php if (isset($invPrice)) {
                                                              echo "value='$invPrice'";
                                                            }  ?> required />

        <label for="invStock">Stock:</label>
        <input type="number" id="invStock" name="invStock" min="1" max="10" <?php if (isset($invStock)) {
                                                                              echo "value='$invStock'";
                                                                            }  ?> required />

        <label for="invColor">Color:</label>
        <input type="color" id="invColor" name="invColor" value="" <?php if (isset($invColor)) {
                                                                      echo "value='$invColor'";
                                                                    }  ?> required />

        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="addVehicleInventory">

        <input type="submit" name="submit" id="addvehicle" value="Add Vehicle">
      </form>
    </fieldset>
  </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>