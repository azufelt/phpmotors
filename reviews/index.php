<?php
//controller for Reviews

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
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/uploads-model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/accounts-model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/reviews-model.php';


//reviews 'section' gets displayed below car in the vehicles details page, at the bottom. Allowing a logged in user to see a name input with their name sticky and NOT editable, a textarea to write the review, then submit button
//---------- if no reviews exist: display the textarea AND a message inviting client to make a review (<-- Still dispplay message if client is not loggeed in, then include a link to the login page)


// Get the array of classifications
$getCarClassifications = getCarClassifications();


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}


//reviews can be accessed from/display on the admin page, for all client levels
//----------the admin page will display "Manage your reviews"
switch ($action) {

  case 'addReview': //Add a new review
    // Filter and store the data

    $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
    $reviewDate = filter_input(INPUT_POST, 'reviewDate', FILTER_SANITIZE_STRING);
    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
    $clientId = filter_input(INPUT_POST, 'clientId', FILTER_VALIDATE_INT);

    // Check for missing data
    if (empty($reviewText) || empty($reviewDate) || empty($invId) || empty($clientId)) {
      echo $reviewText . $reviewDate . $invId . $clientId;
      $message = '<p>Please provide information to post a review.</p>';
      header('Location: /phpmotors/vehicles/index.php?action=vehicleDetail&vehicleId=' . $invId . '');
      exit;
    }
    // Send the data to the model
    //MUST match exact parameters that were defined in the accounts-model page
    $reviewOutcome = insertReview(
      $reviewText,
      $reviewDate,
      $invId,
      $clientId
    );
    // Check and report the result
    if ($reviewOutcome === 1) {
      $message = "<p>Thanks for adding a review. </p>";
      $_SESSION['message'] = $message;
      header('Location: /phpmotors/vehicles/index.php?action=vehicleDetail&vehicleId=' . $invId . '');
      //deliver to same vehicle detail page, use vehicleID for action
      exit;
    } else {
      $message = "<p>Your review was not able to be posted, please try again.</p>";
      header('Location: /phpmotors/vehicles/index.php?action=vehicleDetail&vehicleId=' . $invId . '');
      exit;
    }
    break;
  case 'modReview': //deliver a view to edit update
    //Change page title!!!
    $pageTitle = 'Reviews';
    //get reviewId from the URL action pass-through
    $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
    //take the review ID and go find the specific review (includes: date, text, clientID, etc)

    //send review Data to a build VIEW function to bind with vehicleID, etc.
    $reviewDisplay = updateReviewbyClient($reviewId);
    $reviewUpdate = $reviewDisplay;

    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/review-edit.php';
    break;


    //switchcase to edit a review
  case 'editReview': //handle the review update
    $pageTitle = 'Reviews ';
    // Filter and store the data
    $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT));
    $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING));

    // Check for missing data
    if (empty($reviewText || empty($reviewId))) {
      echo $reviewText;
      $message = '<p>Field cannot be left blank, please enter a review.</p>';
      $_SESSION['message'] = $message;
      header('Location: /phpmotors/reviews/index.php?action=modReview&reviewId=' . $reviewId);
      exit;
    }
    // Send the data to the model
    //MUST match exact parameters that were defined in the accounts-model page
    $updateReview = updateSpecificReview(
      $reviewId,
      $reviewText
    );
    // Check and report the result
    if ($updateReview === 1) {
      $message = "<p>Your review has been updated! </p>";
      $_SESSION['message'] = $message;
      header('Location: /phpmotors/accounts/');

      //deliver to same Review page, use vehicleID for action
      exit;
    } else {
      $message = "<p>Your review was not able to be updated, please try again.</p>";
      $_SESSION['message'] = $message;
      header('Location: /phpmotors/reviews/index.php?action=modReview&reviewId=' . $reviewId);

      exit;
    }


  case 'delReview': //deliver view to confirm deletion
    $pageTitle = 'Reviews';
    //get reviewId from the URL action pass-through
    $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);

    //take the review ID and go find the specific review (includes: date, text, clientID, etc)
    //send review Data to a build VIEW function to bind with vehicleID, etc.
    $reviewDisplay = deleteReviewDisplay($reviewId);
    $reviewUpdate = $reviewDisplay;

    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/review-delete.php';
    break;
  case 'deleteReview': //delete review

    $pageTitle = 'Delete ';
    // $reviewData = $getSpecificReview($reviewId);
    // Filter and store the data

    $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT));


    $deleteResult = deleteSpecificReview($reviewId);
    if ($deleteResult) {
      $message = "<p class='notice'>Congratulations your review was	successfully deleted.</p>";
      $_SESSION['message'] = $message;
      header('Location: /phpmotors/accounts/');
      exit;
    } else {
      $message = "<p class='notice'>Error: your review was not
      deleted.</p>";
      $_SESSION['message'] = $message;
      header('Location: /phpmotors/reviews/index.php?action=delReview&reviewId=' . $reviewId);
      exit;
    }

    break;
  default:

    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/admin.php';
    exit;

    break;
}
