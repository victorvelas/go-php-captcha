<?php 

ini_set('display_errors', 1);

use GoPhpCaptcha\Drivers\Rotator;
include '../vendor/autoload.php';
include 'sessionManager.php';



echo json_encode([
    'status' => Rotator::runValidation(['marginError' => 3, 'captcha_value' => $_POST['captcha_value']]),
    'expectedValue' => $_SESSION['rotatorValue'],
    'setledValue' => $_POST['captcha_value'],
]);
