<?php
###  error displays
error_reporting(E_ALL);
ini_set('display_errors', 1);

###  session
session_start();

###  dependencies
require_once './php/library/config.php';

###  for the customer picture
if (empty($_SESSION['customer-picture']) || (!isset($_SESSION['customer-picture']))) {
  $customerPicture = 'undraw_profile_pic_ic5t.svg';
} else {
  $customerPicture = $_SESSION['customer-picture'];
}

###  initial declaration
$showInformation = false;

### GETs url attributes
$email= filter_input(INPUT_GET, "email", FILTER_VALIDATE_EMAIL);
// check if it match with session, SECURITY REASON
if (sha1($email) === @$_SESSION['email'] && isset($email) && !empty($email)) {
  $showInformation = true;

  // retrive information
  $customerInformation = $db->query('SELECT * FROM customer WHERE email = ?', 
    array($email))->fetchArray();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Abukai testing for my skills">
  <meta name="author" content="Edison Quinones">
  <link rel="apple-touch-icon" sizes="57x57" href="assets/icon/abukai/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="assets/icon/abukai/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="assets/icon/abukai//apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/icon/abukai//apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="assets/icon/abukai//apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="assets/icon/abukai//apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="assets/icon/abukai//apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="assets/icon/abukai//apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/icon/abukai//apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="assets/icon/abukai//android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/icon/abukai//favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="assets/icon/abukai//favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/icon/abukai//favicon-16x16.png">
  <link rel="manifest" href="assets/icon/abukai//manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="assets/icon/abukai//ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">


  <title>Abukai Test -   Customer Information Entry</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <script type="text/javascript">
      
      var BASEURLL = '<?=$baseUrl;?>';
  </script>

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <?php if ($showInformation === true): ?>
            <div class="p-5">
              <?php include_once './php/template/customer-read.php' ?>
            </div>
            <?php else: ?>
              <?php include_once './php/template/customer-form.php' ?>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>

  </div>

<!-- Upload Modal-->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload new picture?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div id="error-area-upload">
            &nbsp;
        </div>
        <div class="modal-body"><input type="file" id="testing-file"> </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal" id="upload-cancel">Cancel</button>
          <button type="button" id="upload-picture-now" class="btn btn-primary btn-user btn-block">Upload</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <!-- <script src="js/sb-admin-2.js"></script> -->
  <!-- <script src="js/calculator.js"></script> -->

  

</body>

</html>