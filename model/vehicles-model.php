<?php
/*
* Vehicle Controller
*/

// Get the functions library
require_once '../library/functions.php';

// Main PHP Motors Model
function getCarClassifications()
{
  // Create a connection object from the phpmotors connection function
  $db = phpmotorsConnect();
  // The SQL statement to be used with the database 
  $sql = 'SELECT classificationId, classificationName FROM carclassification ORDER BY classificationName ASC';
  // The next line creates the prepared statement using the phpmotors connection      
  $stmt = $db->prepare($sql);
  // The next line runs the prepared statement 
  $stmt->execute();
  // The next line gets the data from the database and 
  // stores it as an array in the $classifications variable 
  $classifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // The next line closes the interaction with the database 
  $stmt->closeCursor();
  // The next line sends the array of data back to where the function 
  // was called (this should be the controller) 
  return $classifications;
}

//function to add Vehicle Classification
function addCarClassification($classificationName)
{
  // Create a connection object using the phpmotors connection function
  $db = phpmotorsConnect();
  // The SQL statement
  $sql = 'INSERT INTO carclassification 
                (classificationName)
            VALUES (:classificationName)';
  // Create the prepared statement using the phpmotors connection
  $stmt = $db->prepare($sql);
  // The next line replaces the placeholders in the SQL
  // statement with the actual values in the variables
  // and tells the database the type of data it is
  $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
  // Insert the data
  $stmt->execute();
  // Ask how many rows changed as a result of our insert
  $rowsChanged = $stmt->rowCount();
  // Close the database interaction
  $stmt->closeCursor();
  // Return the indication of success (rows changed)
  return $rowsChanged;
}

//function to add vehicle to inventory
function addVehicleInventory(
  $invMake,
  $invModel,
  $invDescription,
  $invImage,
  $invThumbnail,
  $invPrice,
  $invStock,
  $invColor,
  $classificationId
) {
  // Create a connection object using the phpmotors connection function
  $db = phpmotorsConnect();
  // The SQL statement
  $sql = 'INSERT INTO inventory 
                (invMake, invModel,invDescription, invImage, invThumbnail,
  invPrice, invStock, invColor, classificationId)
            VALUES (:invMake, :invModel, :invDescription, :invImage, :invThumbnail, :invPrice, :invStock, :invColor, :classificationId)';
  // Create the prepared statement using the phpmotors connection
  $stmt = $db->prepare($sql);
  // The next four lines replace the placeholders in the SQL
  // statement with the actual values in the variables
  // and tells the database the type of data it is
  $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
  $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
  $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
  $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
  $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
  $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
  $stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
  $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
  $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);
  // Insert the data
  $stmt->execute();
  // Ask how many rows changed as a result of our insert
  $rowsChanged = $stmt->rowCount();
  // Close the database interaction
  $stmt->closeCursor();
  // Return the indication of success (rows changed)
  return $rowsChanged;
}


// Get vehicles by classificationId 
function getInventoryByClassification($classificationId)
{
  $db = phpmotorsConnect();
  $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
  $stmt->execute();
  $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $inventory;
}


// Get vehicle information by invId
function getInvItemInfo($invId)
{
  $db = phpmotorsConnect();
  $sql = 'SELECT * FROM inventory WHERE invId = :invId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
  $stmt->execute();
  $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $invInfo;
}


// Update a vehicle
function updateVehicle(
  $invMake,
  $invModel,
  $invDescription,
  $invImage,
  $invThumbnail,
  $invPrice,
  $invStock,
  $invColor,
  $classificationId,
  $invId
) {
  $db = phpmotorsConnect();
  $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, invDescription = :invDescription, invImage = :invImage, invThumbnail = :invThumbnail, invPrice = :invPrice, invStock = :invStock, invColor = :invColor, classificationId = :classificationId WHERE invId = :invId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
  $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
  $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
  $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
  $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
  $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
  $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
  $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
  $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// Delete a vehicle
function deleteVehicle($invId)
{
  $db = phpmotorsConnect();
  $sql = 'DELETE FROM inventory WHERE invId = :invId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}


//Get a list of vehicles based on the classification
function getVehiclesByClassification($classificationName)
{
  $db = phpmotorsConnect();
  $sql = 'SELECT i.invId, i.invMake, i.invModel, i.invDescription, i.invPrice, i.invStock, i.invColor, i.classificationId, img.imgPath FROM inventory i INNER JOIN images img ON i.invId = img.invId  WHERE i.classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName) AND img.imgPath LIKE "%tn%" AND img.imgPrimary = 1';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
  $stmt->execute();
  $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $vehicles;
}

//function to obtain information about all vehicles in inventory
// Get information for all vehicles
function getVehicles()
{
  $db = phpmotorsConnect();
  $sql = 'SELECT invId, invMake, invModel FROM inventory';
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $invInfo;
}
