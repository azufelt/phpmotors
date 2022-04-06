<?php
/*
* Reviews Model
*/

// Get the functions library
require_once '../library/functions.php';

function insertReview(
  //insert a review
  $reviewText,
  $reviewDate,
  $invId,
  $clientId
) {
  // Create a connection object using the phpmotors connection function
  $db = phpmotorsConnect();
  // The SQL statement
  $sql = 'INSERT INTO reviews 
                (reviewText,reviewDate, invId,
  clientId)
            VALUES (:reviewText, :reviewDate, :invId, :clientId)';
  // Create the prepared statement using the phpmotors connection
  $stmt = $db->prepare($sql);
  // The next four lines replace the placeholders in the SQL
  // statement with the actual values in the variables
  // and tells the database the type of data it is
  // $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
  $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
  $stmt->bindValue(':reviewDate', $reviewDate, PDO::PARAM_STR);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
  $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
  // Insert the data
  $stmt->execute();
  // Ask how many rows changed as a result of our insert
  $rowsChanged = $stmt->rowCount();
  // Close the database interaction
  $stmt->closeCursor();
  // Return the indication of success (rows changed)
  return $rowsChanged;
}
function getInvReviews($invId)
{ //get reviews for a specific vehicle Id
  $db = phpmotorsConnect();
  $sql = 'SELECT * FROM reviews WHERE invId = :invId ORDER BY reviewDate desc';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
  $stmt->execute();
  $reviewInfo = $stmt->fetchALL(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $reviewInfo;
}
function getReviewsByClient($clientId)
{ //get reviews written by a specific client
  $db = phpmotorsConnect();
  $sql = ' SELECT * FROM reviews WHERE clientId = :clientId ORDER BY reviewDate desc';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
  $stmt->execute();
  $clientReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $clientReviews;
}
function getSpecificReview($reviewId)
{ //get specific review
  $db = phpmotorsConnect();
  $sql = ' SELECT * FROM reviews WHERE reviewId = :reviewId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
  $stmt->execute();
  $specificReview = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $specificReview;
}
function updateSpecificReview($reviewId, $reviewText)
{ //update specific review

  $db = phpmotorsConnect();
  $sql = 'UPDATE reviews SET reviewId = :reviewId, reviewText = :reviewText WHERE reviewId = :reviewId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
  $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);

  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
function deleteSpecificReview($reviewId)
{ //delete specific review
  $db = phpmotorsConnect();
  $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
