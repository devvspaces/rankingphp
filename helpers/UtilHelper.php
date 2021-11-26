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

        public static function write_php_ini($array, $file)
        {
            // Get the file path
            // $imagePath = __DIR__ . "/public/images/$file";

            $res = array();
            foreach($array as $key => $val)
            {
                if(is_array($val))
                {
                    $res[] = "[$key]";
                    foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
                }
                else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
            }
            self::safefilerewrite($file, "[site]" . implode("\r\n", $res));
        }

        public static function safefilerewrite($fileName, $dataToSave)
        {    if ($fp = fopen($fileName, 'w'))
            {
                $startTime = microtime(TRUE);
                do
                {            $canWrite = flock($fp, LOCK_EX);
                // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
                if(!$canWrite) usleep(round(rand(0, 100)*1000));
                } while ((!$canWrite)and((microtime(TRUE)-$startTime) < 5));

                //file was locked so now we can store information
                if ($canWrite)
                {            fwrite($fp, $dataToSave);
                    flock($fp, LOCK_UN);
                }
                fclose($fp);
            }

        }
    }