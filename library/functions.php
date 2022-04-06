<?php
/*
* Function Tasks
*/
function checkEmail($clientEmail)
{
  $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
  return $valEmail;
}

// Check the password for a minimum of 8 characters,
// at least one 1 capital letter, at least 1 number and
// at least 1 special character
function checkPassword($clientPassword)
{
  $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
  return preg_match($pattern, $clientPassword);
}

//Add Nav to all pages
function navList($getCarClassifications)
{
  // Build a navigation bar using the $classifications array
  $navList = '<ul>';
  $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
  foreach ($getCarClassifications as $classification) {
    $navList .= "
  <li>
  <a href='/phpmotors/vehicles/?action=classification&classificationName="
      . urlencode($classification['classificationName']) .
      "' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a></li>";
  }
  $navList .= '</ul>';
  return $navList;
}
// Build the classifications select list 
function buildClassificationList($getCarClassifications)
{
  $classificationList = '<select name="classificationId" id="classificationList">';
  $classificationList .= "<option>Choose a Classification</option>";
  foreach ($getCarClassifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
  }
  $classificationList .= '</select>';
  return $classificationList;
}

//build a display of vehicles within an unordered list
function buildVehiclesDisplay($vehicles)
{
  $dv = '<ul id="inv-display">';
  foreach ($vehicles as $vehicle) {
    $dv .= '<li>';
    //make the image clickable to get detailed information about the specific vehicle.
    $dv .= "<a href='/phpmotors/vehicles/index.php?action=vehicleDetail&vehicleId="
      . urlencode($vehicle['invId']) .
      "'><img src='$vehicle[imgPath]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'></a>";
    $dv .= '<hr>';
    $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
    // $dv .= "c$vehicle[invPrice]</span>";
    $dv .=
      '$' . number_format($vehicle['invPrice'], 0);
    $dv .= '</li>';
  }
  $dv .= '</ul>';
  return $dv;
}

function buildVehicleDetail($getInfo, $price, $imageArray)
{
  $dv = '<div id="detail-display">';
  foreach ($imageArray as $image) {
    if ($image['invId'] == $getInfo['invId'] && $image['imgPrimary'] == 1 && !(strpos($image['imgName'], '-tn') > 0)) {
      $dv .= "<div class='imageBox'><img src='$image[imgPath]' alt='Image of $getInfo[invMake] $getInfo[invModel] on phpmotors.com'>";
    }
  }


  $dv .= '<hr></div>';
  $dv .= '<div>';
  $dv .= '<h2>Vehicle Summary</h2>';
  $dv .= '<ul>';
  $dv .= "<li>Make:<span>$getInfo[invMake]</span></li>";
  $dv .= "<li>Model:<span>$getInfo[invModel]</span></li>";
  $dv .= "<li>Price:<span>$price</span></li>";
  $dv .= "<li>Color:<span>$getInfo[invColor]</span></li>";
  $dv .= "<li>In Stock:<span>$getInfo[invStock]</span></li>";
  $dv .= "<li>Description:<span></span></li>";
  $dv .= "<li><span></span>$getInfo[invDescription]</li>";
  $dv .= '</ul>';
  $dv .= '</div>';
  $dv .= '</div>';
  return $dv;
}

/* * ********************************
*  Functions for working with images
* ********************************* */
// Adds "-tn" designation to file name
function makeThumbnailName($image)
{
  $i = strrpos($image, '.');
  $image_name = substr($image, 0, $i);
  $ext = substr($image, $i);
  $image = $image_name . '-tn' . $ext;
  return $image;
}
// Build images display for image management view
function buildImageDisplay($imageArray)
{
  $id = '<ul id="image-display">';
  foreach ($imageArray as $image) {
    $id .= '<li>';
    $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
    $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
    $id .= '</li>';
  }
  $id .= '</ul>';
  return $id;
}
// Build the vehicles select list
function buildVehiclesSelect($vehicles)
{
  $prodList = '<select name="invId" id="invId">';
  $prodList .= "<option>Choose a Vehicle</option>";
  foreach ($vehicles as $vehicle) {
    $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
  }
  $prodList .= '</select>';
  return $prodList;
}
// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name)
{
  // Gets the paths, full and local directory
  global $image_dir, $image_dir_path;
  if (isset($_FILES[$name])) {
    // Gets the actual file name
    $filename = $_FILES[$name]['name'];
    if (empty($filename)) {
      return;
    }
    // Get the file from the temp folder on the server
    $source = $_FILES[$name]['tmp_name'];
    // Sets the new path - images folder in this directory
    $target = $image_dir_path . '/' . $filename;
    // Moves the file to the target folder
    move_uploaded_file($source, $target);
    // Send file for further processing
    processImage($image_dir_path, $filename);
    // Sets the path for the image for Database storage
    $filepath = $image_dir . '/' . $filename;
    // Returns the path where the file is stored
    return $filepath;
  }
}


// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename)
{
  // Set up the variables
  $dir = $dir . '/';

  // Set up the image path
  $image_path = $dir . $filename;

  // Set up the thumbnail image path
  $image_path_tn = $dir . makeThumbnailName($filename);

  // Create a thumbnail image that's a maximum of 200 pixels square
  resizeImage($image_path, $image_path_tn, 200, 200);

  // Resize original to a maximum of 500 pixels square
  resizeImage($image_path, $image_path, 500, 500);
}


// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height)
{

  // Get image type
  $image_info = getimagesize($old_image_path);
  $image_type = $image_info[2];

  // Set up the function names
  switch ($image_type) {
    case IMAGETYPE_JPEG:
      $image_from_file = 'imagecreatefromjpeg';
      $image_to_file = 'imagejpeg';
      break;
    case IMAGETYPE_GIF:
      $image_from_file = 'imagecreatefromgif';
      $image_to_file = 'imagegif';
      break;
    case IMAGETYPE_PNG:
      $image_from_file = 'imagecreatefrompng';
      $image_to_file = 'imagepng';
      break;
    default:
      return;
  } // ends the swith

  // Get the old image and its height and width
  $old_image = $image_from_file($old_image_path);
  $old_width = imagesx($old_image);
  $old_height = imagesy($old_image);

  // Calculate height and width ratios
  $width_ratio = $old_width / $max_width;
  $height_ratio = $old_height / $max_height;

  // If image is larger than specified ratio, create the new image
  if ($width_ratio > 1 || $height_ratio > 1) {

    // Calculate height and width for the new image
    $ratio = max($width_ratio, $height_ratio);
    $new_height = round($old_height / $ratio);
    $new_width = round($old_width / $ratio);

    // Create the new image
    $new_image = imagecreatetruecolor($new_width, $new_height);

    // Set transparency according to image type
    if ($image_type == IMAGETYPE_GIF) {
      $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
      imagecolortransparent($new_image, $alpha);
    }

    if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
      imagealphablending($new_image, false);
      imagesavealpha($new_image, true);
    }

    // Copy old image to new image - this resizes the image
    $new_x = 0;
    $new_y = 0;
    $old_x = 0;
    $old_y = 0;
    imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

    // Write the new image to a new file
    $image_to_file($new_image, $new_image_path);
    // Free any memory associated with the new image
    imagedestroy($new_image);
  } else {
    // Write the old image to a new file
    $image_to_file($old_image, $new_image_path);
  }
  // Free any memory associated with the old image
  imagedestroy($old_image);
} // ends resizeImage function

// Build images display for image management view
function buildThumbnailsDisplay($thumbnailImages, $getInfo)
{
  $id = '<ul id="image-display" class="car-detail">';
  foreach ($thumbnailImages as $image) {
    $id .= '<li>';
    $id .= "<img src='$image[imgPath]'  alt='$getInfo[invMake] $getInfo[invModel] image on PHP Motors.com'>";
    $id .= '</li>';
  }
  $id .= '</ul>';
  return $id;
}

function buildReviewDisplay($vehicleReviews)
{

  $id = '<ul id="review-list" class="review-list">';
  foreach ($vehicleReviews as $review) {
    $clientId = $review['clientId'];
    // echo ($clientId);
    $clientReviewList = getClientInfo($clientId);
    // var_dump($clientReviewList);
    $firstName =
      $clientReviewList['clientFirstname'];
    $lastName =
      $clientReviewList['clientLastname'];
    $screenName = substr($firstName, 0, 1) . $lastName;
    $date = date('j F, Y', strtotime($review['reviewDate']));
    $id .= '<li>';
    $id .= '<h3>' . $screenName . '</h3>';
    $id .= '<em class="reviewDate">Wrote on ' . $date . ':</em>';
    $id .= '<p>' . $review['reviewText'] . '</p>';
    $id .= '</li>';
  }
  $id .= '</ul>';
  return $id;
}

function buildReviewDisplaybyClient($clientReviewList)
{

  $id = '<ul id="review-list" class="review-list">';
  foreach ($clientReviewList as $review) {
    $invId = $review['invId'];
    $clientId = $review['clientId'];
    $reviewId = $review['reviewId'];

    $vehicleReviewList =
      getInvItemInfo($invId);
    $clientData = getClientInfo($clientId);
    // var_dump($clientReviewList);

    $date = date('j F, Y', strtotime($review['reviewDate']));
    $id .= '<li>';

    $id .= '<h3>' . $vehicleReviewList['invMake'] . " " . $vehicleReviewList['invModel'] . '</h3>';
    $id .= '<em class="reviewDate">Reviewed on ' . $date . ':</em>';
    $id .= '<div>
    <a href="/phpmotors/reviews/index.php?action=modReview&reviewId='
      . urlencode($reviewId) . '">Edit</a>
     | 
     <a href="/phpmotors/reviews/index.php?action=delReview&reviewId='
      . urlencode($reviewId) . '">Delete</a>';
    $id .= '</div></li>';
  }
  $id .= '</ul>';
  return $id;
}

function updateReviewbyClient($reviewId)
{

  $reviewData = getSpecificReview($reviewId);
  //we have the entire review data
  $reviewId = $reviewData['reviewId'];
  // //get the vehicleID from review Data, and pull in the vehicleInfo
  $invId = $reviewData['invId'];
  $date = $reviewData['reviewDate'];
  $vehicleReviewList = getInvItemInfo($invId);

  $date = date('j F, Y', strtotime($reviewData['reviewDate']));
  $id = '<fieldset>
  <legend></legend>
  <form method="post" action= "/phpmotors/reviews/index.php">
  
  <h3>' . $vehicleReviewList['invMake'] . ' ' . $vehicleReviewList['invModel'] . ' Review</h3>
  <em class="reviewDate">Reviewed on ' . $date . ':</em>
  <label for="reviewText">Review:</label>
  <textarea id="reviewText" name="reviewText" rows="5" cols="33" required>' . $reviewData['reviewText'] . '</textarea>
  <input type="hidden" name="action" value="editReview">
  <input type="hidden" name="reviewId" value="' . $reviewData['reviewId'] . '">
  <input type="hidden" name="invId"  value="' . $vehicleReviewList['invId'] . '">
  <input type="submit" name="submit" id="updateReview" value="Update Review">
  
  </form></fieldset>';
  return $id;
}

function deleteReviewDisplay($reviewId)
{

  $reviewData = getSpecificReview($reviewId);
  // var_dump($reviewData);
  //we have the entire review data
  $reviewId = $reviewData['reviewId'];
  // //get the vehicleID from review Data, and pull in the vehicleInfo
  $invId = $reviewData['invId'];
  $date = $reviewData['reviewDate'];
  $vehicleReviewList = getInvItemInfo($invId);

  $date = date('j F, Y', strtotime($reviewData['reviewDate']));
  $id = '<p class="warning">Warning: Deletes cannot be undone! Are you sure you want to delete this review?</p>
  <fieldset>
  <legend></legend>
  <form method="post" action= "/phpmotors/reviews/index.php">
  
  <h3>' . $vehicleReviewList['invMake'] . ' ' . $vehicleReviewList['invModel'] . ' Review</h3>
  <em class="reviewDate">Reviewed on ' . $date . ':</em>
  <label for="deleteReview">Review:</label>
  <p id="reviewText">
      ' . $reviewData['reviewText'] . '</p>
  <input type="hidden" name="action" value="deleteReview">
  <input type="hidden" name="reviewId" value="' . $reviewData['reviewId'] . '">
  <input type="hidden" name="invId"  value="' . $vehicleReviewList['invId'] . '">
  <input type="submit" name="submit" id="deleteReview" value="Delete Review">
  
  </form></fieldset>';
  return $id;
}
