<?php
ini_set('display_errors', 1);
use GoPhpCaptcha\Drivers\Rotator;

include 'vendor/autoload.php';

$captchaRotator = new Rotator();
$captchaRotator->setSourceFolder('tests/backgrounds');
$captchaRotator->setCacheFolder('./.caches');
$captchaRotator->build();