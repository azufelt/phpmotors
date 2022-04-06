<?php

/*
* Accounts Controller
*/
// Create or access a Session
session_start();


require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/connections.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/main-model.php';
// Get the accounts model
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/accounts-model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/reviews-model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/vehicles-model.php';
// // Get the array of classifications
$getCarClassifications = getClassifications();
// $navList = navList($getCarClassifications);
//Change page title
$pageTitle = 'Accounts ';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
  case 'login':
    //Change page title
    $pageTitle = 'Login ';
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
    break;

  case 'register':
    //Change page title
    $pageTitle = 'User Registration ';
    include
      $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/registration.php';
    break;

  case 'userLogin':
    // Filter and store the data
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));

    $clientEmail = checkEmail($clientEmail);
    $checkPassword = checkPassword($clientPassword);

    if (empty($clientEmail) || empty($checkPassword)) {
      $message = '<p>
    Please provide information for all empty form fields.
      </p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
      exit;
    }
    // A valid password exists, proceed with the login process
    // Query the client data based on the email address
    $clientData = getClient($clientEmail);
    // Compare the password just submitted against
    // the hashed password for the matching client
    $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
    // If the hashes don't match create an error
    // and return to the login view
    if (!$hashCheck) {
      $message = '<p class="notice">Please check your password and try again.</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
      exit;
    }
    // A valid user exists, log them in
    $_SESSION['loggedin'] = TRUE;
    // Remove the password from the array
    // the array_pop function removes the last
    // element from an array
    array_pop($clientData);
    // Store the array into the session
    $_SESSION['clientData'] = $clientData;
    // Send them to the admin view
    header('Location: /phpmotors/accounts/');
    exit;
    break;

  case 'registerUser':
    //Change page title
    $pageTitle = 'User Registration ';
    // echo 'You are in the register case statement.';

    // Filter and store the data
    $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
    $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));

    $clientEmail = checkEmail($clientEmail);
    $checkPassword = checkPassword($clientPassword);

    // Check for existing email address
    $existingEmail = checkExistingEmail($clientEmail);

    // Check for existing email address in the table
    if ($existingEmail) {
      $_SESSION['message'] = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
      header('Location: /phpmotors/accounts/?action=login');
      exit;
    }

    // Check for missing data
    if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
      $message = '<p>Please provide information for all empty form fields.</p>';
      include '../view/registration.php';
      exit;
    }
    // Send the data to the model
    //MUST match exact parameters that were defined in the accounts-model page
    // Hash the checked password
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

    $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
    // Check and report the result
    if ($regOutcome === 1) {
      setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
      $_SESSION['message'] = "<p>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
      header('Location: /phpmotors/accounts/?action=login');
      exit;
    } else {
      $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
      include '../view/registration.php';
      exit;
    }
    break;



  case 'logout':
    //Change page title
    $pageTitle = 'Home ';
    if (isset($_SESSION['loggedin'])) {
      setcookie(session_name(), '', 100);
      unset($_SESSION["clientData"]);
      session_destroy();
      header('Location: /phpmotors/');
    }
    break;

  case 'modClient':
    //Change page title
    $pageTitle = 'Accounts ';
    include '../view/client-update.php';
    exit;
    break;

  case 'updateClient':
    // echo 'You are in the update user case statement.';
    //Change page title
    $pageTitle = 'Accounts ';
    // Filter and store the data
    $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
    $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientId = filter_input(INPUT_POST, 'clientId', FILTER_VALIDATE_INT);

    $clientEmail = checkEmail($clientEmail);
    // Check for existing email address
    $existingEmail = checkExistingEmail($clientEmail);

    // Check for existing email address in the table
    if ($existingEmail) {
      $message = '<p class="notice">That email address already exists.</p>';
      include '../view/client-update.php';
      exit;
    }

    // Check for missing data
    if (
      empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)
    ) {
      $message = '<p>Please provide information for all empty form fields.</p>';
      include '../view/client-update.php';
      exit;
    }

    // Send the data to the model
    //MUST match exact parameters that were defined in the accounts-model page

    $updateClientInfo = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);
    // Check and report the result
    if ($updateClientInfo) {

      $clientData = getClientInfo($clientId);
      $_SESSION['clientData'] = $clientData;

      $message = "<p class='notice'>Congratulations $clientFirstname, your account was successfully updated.</p>";
      $_SESSION['message'] = $message;
      header('Location: /phpmotors/accounts/');
      exit;
    } else {
      $message = "<p>Sorry $clientFirstname, but the update failed. Please try again.</p>";
      include '../view/client-update.php';
      exit;
    }
    break;



  case 'updatePassword':
    //Change page title
    $pageTitle = 'Accounts ';
    // Filter and store the data
    $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_VALIDATE_INT));
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
    $checkPassword = checkPassword($clientPassword);

    if (empty($checkPassword)) {
      $message = '<p>
    Please provide information for all empty form fields.
      </p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
      exit;
    }
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

    $passwordUpdate = passwordUpdate($clientId, $hashedPassword);

    // If the hashes don't match create an error
    // and return to the login view
    if ($passwordUpdate) {
      $clientData = getClientInfo($clientId);
      $_SESSION['clientData'] = $clientData;
      $message = "<p class='notify'>Congratulations, your password was updated.</p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/accounts/');
      exit;
    } else {
      $message = '<p class="notice">Error, password was not updated.</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/admin.php';
      exit;
    }

    break;


  default:
    //get client ID from session for whoever is logged in
    $clientId = $_SESSION['clientData']['clientId'];
    //get the list of reviews for this client based on the client ID
    $clientReviewList = getReviewsByClient($clientId);
    //pass list into a function to build the <li> list of reviews
    $listOfReviews = buildReviewDisplaybyClient($clientReviewList);
    //IF no reviews say "be thee first to leave a review
    if (empty($listOfReviews)) {
      $reviewList = "<p>Go ahead and leave a review, it's fun!</p>";
    } else {
      $reviewList = $listOfReviews;
    }

    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/admin.php';
    break;
}
