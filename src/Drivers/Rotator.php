<?php namespace GoPhpCaptcha\Drivers
{

    use Exception;
    use Intervention\Image\Drivers\Gd\Driver;
    use Intervention\Image\ImageManager as Image;
    use Intervention\Image\Interfaces\ImageInterface;

    final class Rotator implements CaptchaDriver
    {

        private array $imageFiles;

        private string $sourceFolder = '';

        private string $cacheFolder = '';
        private int $minAngle;
        private int $maxAngle;

        private int $imageSize = 260;

        public function __construct(int $minAngle = 20, int $maxAngle = 340)
        {
            $this->minAngle = $minAngle;
            $this->maxAngle = $maxAngle;
        }

        public function setSourceFolder(string $folder) : void {
            $this->sourceFolder = $folder;
            $this->imageFiles = glob($this->sourceFolder.'/*');
        }
        
        public function setCacheFolder(string $folder) : void {
            $this->cacheFolder = $folder;
        }

        private function cropImage(ImageInterface &$image) : void
        {
            $width = $image->width();
            $height = $image->height();
            $x = max(0, ($width - $this->imageSize) / 2);
            $y = max(0, ($height - $this->imageSize) / 2);
            $image->crop($this->imageSize, $this->imageSize, $x, $y);
        }

        public function build() : array
        {
            if ($this->imageFiles === []) {
                throw new Exception('No images available on the dir "'.$this->sourceFolder.'"');
            }
            $imagePath = $this->imageFiles[array_rand($this->imageFiles)];
            $masterPath = $this->cacheFolder.'/master.jpg';
            $thumbPath = $this->cacheFolder.'/thumb.png';
            if (!file_exists($this->cacheFolder)) {
                mkdir($this->cacheFolder, 0777, true);
            }
            $angle = rand($this->minAngle, $this->maxAngle);
            $gdImg = new Image(new Driver());
            $image = $gdImg->read($imagePath);
            $this->cropImage($image);
            $image->save($masterPath);
            $thumbImg = $gdImg->read($masterPath);
            $thumbImg->rotate($angle);
            $this->cropImage($thumbImg);
            $thumbImg->save($thumbPath);
            $createCricularShape = $this->cutCircularShape($thumbPath, 75);
            if ($createCricularShape === false) {
                throw new Exception("Thumb image circular shape couldn\'t be created", 1);
                return [
                    'status' => 'error',
                    'errorDetail' => 'Thumb image circular shape couldn\'t be created',
                ];                
            }            
            return [
                'status' => 'success',
                'angle' => $angle, 
                'master' => $masterPath, 
                'thumb' => $thumbPath
            ];
        }

        private function cutCircularShape(string $sourcePath, int $circleScale = 10) : bool {
            $outputPath = $sourcePath;
            $image = imagecreatefromstring(file_get_contents($sourcePath));
            $size = min(imagesx($image), imagesy($image));
            $newImage = imagecreatetruecolor($size, $size);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
            imagefill($newImage, 0, 0, $transparent);
            $mask = imagecreatetruecolor($size, $size);
            imagesavealpha($mask, true);
            $clear = imagecolorallocatealpha($mask, 0, 0, 0, 127);
            $solid = imagecolorallocatealpha($mask, 0, 0, 0, 0);
            imagefill($mask, 0, 0, $clear);
            $circleDiameter = $size * max(0, min(1, $circleScale / 100));
            imagefilledellipse($mask, $size / 2, $size / 2, $circleDiameter, $circleDiameter, $solid);
            for ($x = 0; $x < $size; $x++) {
                for ($y = 0; $y < $size; $y++) {
                    if (imagecolorat($mask, $x, $y) === $solid) {
                        imagesetpixel($newImage, $x, $y, imagecolorat($image, $x, $y));
                    }
                }
            }
            $imageCreated = imagepng($newImage, $outputPath);
            imagedestroy($image);
            imagedestroy($newImage);
            imagedestroy($mask);
            return $imageCreated;
        }


        public static function runValidation(array $data) : bool
        {

            $min = $_SESSION['rotatorValue'] - $data['marginError'];
            $max = $_SESSION['rotatorValue'] + $data['marginError'];
            return ($data['captcha_value'] >= $min) && ($data['captcha_value'] <= $max);
        }
    }
    
}