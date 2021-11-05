<?php

    namespace app\helpers;

    class UtilHelper
    {
        public static function dump($val){
            echo "<pre>";
            var_dump($val);
            echo "</pre>";
        }
        
        public static function randomString($n){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
            $randStr = '';
        
            for ($i = 0; $i < $n; $i++){
                $index = rand(0, strlen($characters)-1);
                $character = $characters[$index];
                $randStr .= $character;
            }
        
            return $randStr;
        }
        
        public static function getUniqueDir(){
            $uniqueName = self::randomString(8);
            $imagePath = __DIR__ . "/public/images/$uniqueName";
        
            // check if dir exists
            if (is_dir($imagePath)){
                return self::getUniqueDir();
            } else {
                return $uniqueName;
            }
        }
    }