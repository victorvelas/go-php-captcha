<?php 
ini_set('display_errors', 1);
use GoPhpCaptcha\Drivers\Rotator;

include '../vendor/autoload.php';

$captchaRotator = new Rotator(100, 200);
$captchaRotator->setSourceFolder('../tests/backgrounds');
$captchaRotator->setCacheFolder('../.caches');
$images = $captchaRotator->build();


function renderImage(string $src, string $alt) : string {
    return <<<HTML
    <div class="demo-content">
        <div class="display-flex">
            <img src="{$src}" alt="{$alt}" width="250px" class="margin-auto" />
        </div>
    </div>
    HTML;
}

$content = '';
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
<?php 
$data['content'] = ob_get_contents();
ob_end_clean();
include 'layouts/web.php';



