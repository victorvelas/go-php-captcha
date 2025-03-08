<?php namespace GoPhpCaptcha\Drivers
{

    use Exception;
    use Intervention\Image\Drivers\Gd\Driver;
    use Intervention\Image\Drivers\Gd\Modifiers\ResizeCanvasModifier;
    use Intervention\Image\Geometry\Circle;
    use Intervention\Image\Geometry\Ellipse;
    use Intervention\Image\Geometry\Factories\CircleFactory;
    use Intervention\Image\Geometry\Factories\Drawable;
    use Intervention\Image\Geometry\Factories\EllipseFactory;
    use Intervention\Image\ImageManager as Image;


    final class Rotator implements CaptchaDriver
    {

        private array $imageFiles;

        private string $sourceFolder = '';

        private string $cacheFolder = '';
        private int $minAngle;
        private int $maxAngle;

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

        public function build() : array
        {
            if ($this->imageFiles === []) {
                throw new Exception("No images available");
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
            $image->save($masterPath);

            /* $cropSize = 150;
            $x = ($image->width() - $cropSize) / 2;
            $y = ($image->height() - $cropSize) / 2;
            $image->crop($cropSize, $cropSize, $x, $y); */


            return [
                'angle' => $angle, 
                'master' => $masterPath, 
                'thumb' => $thumbPath
            ];
        }
    }
    
}