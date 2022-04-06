<?php
//Get the functions file
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/functions.php';

if (isset($getCarClassifications)) {
  echo navList($getCarClassifications);
}
