<?php namespace GoPhpCaptcha\Drivers
{
    interface CaptchaDriver
    {
        

        public function build() : array;

        public static function runValidation(array $data) : bool;


    }
    
}