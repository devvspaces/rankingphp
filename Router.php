<?php
    namespace app;

    use app\Database;
    use app\helpers\UtilHelper as Util;

    class Router
    {

        public array $getRoutes;
        public array $postRoutes;
        public Database $db;

        public function __construct(){
            $this->db = new Database();
        }

        public function get($url, $fn)
        {
            $this->getRoutes[$url] = $fn;
        }

        public function post($url, $fn)
        {
            $this->postRoutes[$url] = $fn;
        }

        public function resolve()
        {
            $url = $_SERVER["REQUEST_URI"] ?? '/';

            if (strpos($url, '?') !== false){
                $url = substr($url, 0, strpos($url, '?'));
            }

            $method = $_SERVER['REQUEST_METHOD'];

            if ($method === 'GET'){
                $fn = $this->getRoutes[$url] ?? null;
            } else{
                $fn = $this->postRoutes[$url] ?? null;
            }

            if ($fn){
                call_user_func($fn, $this);
            } else {
                echo 'Page not found';
            }

        }

        public function renderView($template_name, $context = [])
        {
            foreach($context as $k => $v){
                $$k = $v;
            }

            ob_start();
            include_once __DIR__ . "/views/$template_name.php";
            $content = ob_get_clean();

            include_once __DIR__ . "/views/_layout.php";
        }
    }
    