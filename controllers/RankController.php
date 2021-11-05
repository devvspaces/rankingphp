<?php
    namespace app\controllers;

    use app\Router;
    use app\models\Rank;
    use app\helpers\UtilHelper;

    class RankController
    {

        public function login(Router $router){

            // gY7y@#GXXjv1

            if (isset($_SESSION["logged_in"])){
                if (password_verify('green', $_SESSION["logged_in"])){
                    // Redirect to admin
                    header('Location: /admin/ranks');
                    exit;
                }
            }

            $errors = [];
            if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    
                $name = $_POST['name'] ?? '';
                $password = $_POST['password'] ?? '';

                // validate data
                if (!$name){
                    $errors[] = 'Please provide your username';
                }

                if (!$password){
                    $errors[] = 'Please provide your password';
                }


                if (empty($errors)){
                    $hash = '$2y$10$.HL6t3fbKiCSCSd8WE4ui.glUqedWX9AcrF8RvcCtFznRBeuutuv2';

                    if (password_verify($password, $hash) & ($name == 'dmainguy')){
                        // Set session variables
                        $_SESSION["logged_in"] = password_hash('green', PASSWORD_DEFAULT);

                        header('Location: /admin/ranks');
                        exit;
                    } else {
                        $errors[] = 'Invalid username or password';
                    }
                }
                
            }

            // echo password_hash('', PASSWORD_DEFAULT);

            $context = [
                'errors' => $errors
            ];

            $router->renderView('ranks/login', $context);
        }

        public function logout(Router $router){

            // remove all session variables
            session_unset();

            // destroy the session
            session_destroy();

            header('Location: /admin/login');
            exit;
        }

        public function index(Router $router){

            $search = $_GET['search'] ?? '';
            $Ranks = $router->db->getRanks($search);

            $context = [
                'ranks' => $Ranks,
                'search' => $search,
            ];

            $router->renderView('ranks/index', $context);
        }


        public static function checkLogin()
        {
            if (isset($_SESSION["logged_in"])){
                if (password_verify('green', $_SESSION["logged_in"])){
                    return 1;
                }
            }
            // Redirect to logout
            header('Location: /logout');
            exit;
        }

        public function admin(Router $router){

            // Check if the user is logged in
            self::checkLogin();

            $search = $_GET['search'] ?? '';
            $Ranks = $router->db->getRanks($search);

            $context = [
                'ranks' => $Ranks,
                'search' => $search,
            ];

            $router->renderView('ranks/admin', $context);
        }

        public function updateOrder(Router $router){

            $jsonString = $_POST['jsonString'];

            $jsonObj = json_decode($jsonString);

            foreach ($jsonObj as $obj) {
                $Rank = $router->db->getRankById($obj->id);

                $RankData = [
                    'id' => $Rank['id'],
                    'name' => $Rank['name'],
                    'position' => $obj->position,
                    'count' => $obj->count,
                    'movement' => $obj->movement,
                    'imagePath' => $Rank['image'],
                ];

                $Rank = new Rank();
                $Rank->load($RankData);
                $errors = $Rank->save();

                if (!empty($errors)){
                    $message = [];
                    $message['errors'] = $errors;
                    echo json_encode($jsonObj);
                    http_response_code(400);
                    return;
                }
            }

            echo json_encode($jsonObj);
        }

        public function create(Router $router){

            $errors = [];
            $RankData = [
                'name' => '',
                'position' => '',
                'count' => '',
                'movement' => '',
                'image' => '',
            ];

            if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    
                $RankData['name'] = $_POST['name'];
                $RankData['position'] = $_POST['position'] ?? 0;
                $RankData['count'] = $_POST['count'] ?? 0;
                $RankData['movement'] = $_POST['movement'] ?? false;
                $RankData['imageFile'] = $_FILES["image"] ?? null;

                $Rank = new Rank();
                $Rank->load($RankData);
                $errors = $Rank->save();

                if (empty($errors)){
                    header('Location: /admin/ranks');
                    exit;
                }
            }

            $context = [
                'rank' => $RankData,
                'errors' => $errors
            ];

            $router->renderView('ranks/create', $context);
        }

        public function update(Router $router){
            $id = $_GET['id'] ?? null;

            if (!$id){
                // Redirect to list page
                header("location: /");
                exit;
            }

            $Rank = $router->db->getRankById($id);

            $errors = [];
            $RankData = [
                'id' => $Rank['id'],
                'name' => $Rank['name'],
                'position' => $Rank['position'],
                'count' => $Rank['count'],
                'movement' => $Rank['movement'],
                'imagePath' => $Rank['image'],
            ];

            // UtilHelper::dump($RankData);

            if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    
                $RankData['name'] = $_POST['name'];
                // $RankData['position'] = $_POST['position'] ?? 0;
                // $RankData['count'] = $_POST['count'] ?? 0;
                // $RankData['movement'] = $_POST['movement'] ?? false;
                $RankData['imageFile'] = $_FILES["image"] ?? null;
                // $RankData['imagePath'] = $RankData['imagePath'];

                $Rank = new Rank();
                $Rank->load($RankData);
                $errors = $Rank->save();

                if (empty($errors)){
                    header('Location: /admin/ranks');
                    exit;
                }
            }

            $context = [
                'rank' => $RankData,
                'errors' => $errors
            ];

            $router->renderView('ranks/update', $context);
        }

        public function delete(Router $router){
            $id = $_POST['id'] ?? null;

            if ($id){
                $router->db->deleteRank($id);
            }

            // Redirect to list page
            header("Location: /");

            // $router->renderView('Ranks/delete', $context);
        }
    }
    