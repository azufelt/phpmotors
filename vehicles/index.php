<?php
// Create or access a Session
session_start();

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/connections.php';
// Get the PHP Motors model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/main-model.php';
// Get the vehicles model
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/vehicles-model.php';
//Get the functions file
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/functions.php';
//Get the functions file
require_once $_SERVER['DOCUMENT_ROOT'] .
  '/phpmotors/model/uploads-model.php';
//Get the functions file
require_once $_SERVER['DOCUMENT_ROOT'] .
  '/phpmotors/model/reviews-model.php';
//Get the functions file
require_once $_SERVER['DOCUMENT_ROOT'] .
  '/phpmotors/model/accounts-model.php';



// Get the array of classifications
$getCarClassifications = getCarClassifications();


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
  case 'adminAddclassification':
    //Change page title
    $pageTitle = 'Vehicle Classification ';
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
    break;
  case 'vehicle':
    //Change page title
    $pageTitle = 'Add Vehicle ';
    include
      $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
    break;

  case 'addCarClassification':

    // Filter and store the data
    $classificationName = filter_input(INPUT_POST, 'classificationName');

    // Check for missing data
    if (empty($classificationName)) {
      $message = '<p>Please provide information for new car Classification.</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
      exit;
    }
    // Send the data to the model
    //MUST match exact parameters that were defined in the accounts-model page
    $newCarClassification = addCarClassification($classificationName);
    // Check and report the result
    if ($newCarClassification === 1) {
      header('Location: /phpmotors/vehicles/');
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
      exit;
    } else {
      $message = "<p>Please try again.</p>";
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
      exit;
    }
    break;

  case 'addVehicleInventory':
    // Filter and store the data
    $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
    $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
    $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
    $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
    $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
    $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
    $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
    $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_STRING);

    // Check for missing data
    if (empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)) {
      $message = '<p>Please provide information for new vehicle inventory.</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
      exit;
    }
    // Send the data to the model
    //MUST match exact parameters that were defined in the accounts-model page
    $vehicleOutcome = addVehicleInventory($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);
    // Check and report the result
    if ($vehicleOutcome === 1) {
      $message = "<p>Thanks for adding a vehicle to the inventory list. </p>";
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
      exit;
    } else {
      $message = "<p>Please try again.</p>";
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
      exit;
    }
    break;

  case 'admin':
    //Change page title
    $pageTitle = 'Vehicles ';
    if (!($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 2) {
      header('Location: /phpmotors/');
    } elseif (($_SESSION['loggedin']) && $_SESSION['clientData']['clientLevel'] > 1) {
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-man.php';
      exit;
      break;
    }

    // * *********************************** 
    // * Get vehicles by classificationId 
    // * Used for starting Update & Delete process 
    // * ********************************** */ 
  case 'getInventoryItems':
    // Get the classificationId 
    $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
    // Fetch the vehicles by classificationId from the DB 
    $inventoryArray = getInventoryByClassification($classificationId);
    // Convert the array to a JSON object and send it back 
    //**Note the use of echo, not return, to send back the JSON object. */
    echo json_encode($inventoryArray);
    break;

  case 'mod':
    //Change page title
    $pageTitle = 'Update Vehicle ';
    $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
    $invInfo = getInvItemInfo($invId);
    if (count($invInfo) < 1) {
      $message = 'Sorry, no vehicle information could be found.';
    }
    include '../view/vehicle-update.php';
    exit;
    break;

  case 'updateVehicle':

    $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
    $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
    $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
    $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
    $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
    $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
    $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
    $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

    if (
      empty($classificationId) || empty($invMake) || empty($invModel)
      || empty($invDescription) || empty($invImage) || empty($invThumbnail)
      || empty($invPrice) || empty($invStock) || empty($invColor)
    ) {
      $message = '<p>Please complete all information for the vehicle! Double check the classification of the vehicle.</p>';
      include '../view/vehicle-update.php';
      exit;
    }

    $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
    if ($updateResult) {
      $message = "<p class='notice'>Congratulations, the $invMake $invModel was successfully updated.</p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/vehicles/');
      exit;
    } else {
      $message = "<p class='notice'>Error. the $invMake $invModel was not updated.</p>";
      include '../view/vehicle-update.php';
      exit;
    }
    break;

  case 'del':
    //Change page title
    $pageTitle = 'Delete Vehicle ';
    $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
    $invInfo = getInvItemInfo($invId);
    if (count($invInfo) < 1) {
      $message = 'Sorry, no vehicle information could be found.';
    }
    include '../view/vehicle-delete.php';
    exit;
    break;

  case 'deleteVehicle':
    $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
    $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

    $deleteResult = deleteVehicle($invId);
    if ($deleteResult) {
      $message = "<p class='notice'>Congratulations the, $invMake $invModel was	successfully deleted.</p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/vehicles/');
      exit;
    } else {
      $message = "<p class='notice'>Error: $invMake $invModel was not
      deleted.</p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/vehicles/');
      exit;
    }
    break;
  case 'classification':

    $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
    $vehicles = getVehiclesByClassification($classificationName);
    $pageTitle = $classificationName . ' ';
    if (!count($vehicles)) {
      $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
    } else {
      $vehicleDisplay = buildVehiclesDisplay($vehicles);
    }
    // echo $vehicleDisplay;
    // exit;
    include '../view/classification.php';
    break;

  case 'vehicleDetail':
    // Call function to return image info from database
    $invId = filter_input(INPUT_GET, 'vehicleId', FILTER_SANITIZE_NUMBER_INT);
    $thumbnailImages = getAllThumbnails($invId);
    $imageArray = getImages();
    $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
    $vehicleId = filter_input(INPUT_GET, 'vehicleId', FILTER_SANITIZE_STRING);

    $getInfo = getInvItemInfo($vehicleId);
    $pageTitle = $getInfo['invMake'] . ' ' . $getInfo['invModel'] . ' ';
    if (!($vehicleId)) {
      $message = "<p class='notice'>Sorry, no vehicle could be found.</p>";
    } else {
      $price =
        '$' . number_format($getInfo['invPrice'], 2);
      $vehicleName = $getInfo['invMake'];
      $vehicleDisplay = buildVehicleDetail($getInfo, $price, $imageArray);
      $vehicleThumbnailImages = buildThumbnailsDisplay($thumbnailImages, $getInfo);
    }

    //get the list of reviews for this vehicle based on the vehicle ID
    $vehicleReviews = getInvReviews($vehicleId);
    //pass list into a function to build the <li> list of reviews

    //IF no reviews say "be the first to leave a review

    if ($vehicleReviews) {
      $reviewList = buildReviewDisplay($vehicleReviews);
    } else {
      $reviewList = '<p>Be the first to leave a review.</p>';
    }
    // echo ($reviewList);
    include '../view/vehicle-detail.php';
    break;

  default:
    $classificationList = buildClassificationList($getCarClassifications);

    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-man.php';
    break;
}
