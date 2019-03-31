<?php
session_start();
header('Content-type: application/json');

// error displays
// error_reporting(E_ALL);
ini_set('display_errors', 0);

// message
$error = false;
$errorCode = 0;
$imageDefault = 'undraw_profile_pic_ic5t.svg';
$message = '';
$newFileName = '';
$messageFileSuccess = 'File is successfully uploaded';
$messageFileNotUpload = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';

  if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK)
  {
    // get details of the uploaded file
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    // sanitize file-name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    // check if file has one of the following extensions
    $allowedfileExtensions = array('jpg', 'jpeg');

    if($check !== false ) {
      if (in_array($fileExtension, $allowedfileExtensions))  {
        // directory in which the uploaded file will be moved
        $uploadFileDir = '../uploaded-pictures/';
        $dest_path = $uploadFileDir . $newFileName;

        // if(move_uploaded_file($fileTmpPath, $dest_path)) 
        // {
        //   $message ='File is successfully uploaded.';
        // }
        if (imagejpeg(imagecreatefromjpeg($fileTmpPath), $dest_path)) {
          $_SESSION['customer-picture'] = $newFileName;
          $message = $messageFileSuccess;
        } else {
          $_SESSION['customer-picture'] = $imageDefault;
          $message = $messageFileNotUpload;
          $error = true;
        }
      }
      else
      {
        $_SESSION['customer-picture'] = $imageDefault;
        $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
        $errorCode = 111;
        $error = true;
      }
    } else {
      $_SESSION['customer-picture'] = $imageDefault;
      $message = 'file is not an image or it is too large';
      $errorCode = 222;
      $error = true;
    }
  }
  else
  {
    $message = 'There is some error in the file upload. Please check the following error.<br>';
    $errorCode = $_FILES['file']['error'];
    $error = true;
    // $_SESSION['customer-picture'] = $imageDefault;
  }

// display
echo json_encode([
  "error" => $error,
  "newFileName" => $newFileName,
  "errorCode" => $errorCode,
  "message" => $message
]);
