<?php 
ini_set('display_errors', 1);

use GoPhpCaptcha\Drivers\Rotator;

include '../vendor/autoload.php';
include 'sessionManager.php';

$captchaRotator = new Rotator(20, 340);
$captchaRotator->setSourceFolder('../tests/backgrounds');
$captchaRotator->setCacheFolder('../.caches');
$images = $captchaRotator->build();


$_SESSION['rotatorValue'] = $images['angle'];

function renderImage(string $src, string $alt) : string {
    return <<<HTML
    <div class="demo-content">
        <div class="display-flex">
            <img src="{$src}" alt="{$alt}" width="250px" class="margin-auto" />
        </div>
    </div>
    HTML;
}


ob_start();
?>
    <h2>Demo 😺</h2>
    <div class="demo-container">
        <div class="demo-box">
            <h3>Original Image</h3>
            <?= renderImage($images['master'], 'Original Image'); ?>
        </div>
        <div class="demo-box">
            <h3>Shaped rotated image in <?= $images['angle'] ?>°</h3>
            <?= renderImage($images['thumb'], 'Rotated Image'); ?>
        </div>
    </div>
    <section class="">
        <div class="demo-container">
            <div class="demo-box">
                <div id="rotate-wrap"></div>
            </div>
        </div>
        <h1><?= $_SESSION['rotatorValue'] ?></h1>
    </section>
<?php 
$data['content'] = ob_get_contents();
ob_end_clean();


ob_start();
?>
<script type="text/javascript" src="../tests/assets/js/rotator.js"></script>
<?php
$data['js'] = ob_get_contents();
ob_end_clean();

include 'layouts/web.php';



