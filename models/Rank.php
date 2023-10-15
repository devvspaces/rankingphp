<?php

    namespace app\models;

    use app\Database;
    use app\helpers\UtilHelper;
    

    class Rank {
        
        public ?int $id = null;
        public ?string $name = null;
        public ?string $position = null;
        public ?string $highest = null;
        public ?string $lowest = null;
        public ?float $count = null;
        public ?string $movement = null;
        public ?string $imagePath = null;
        public ?string $detail = null;
        public ?array $imageFile = null;

        public function load($data){
            $this->id = $data['id'] ?? null;
            $this->name = $data['name'];
            $this->position = $data['position'] ?? '';
            $this->highest = $data['highest'] ?? '';
            $this->lowest = $data['lowest'] ?? '';
            $this->count = $data['count'] ?? '';
            $this->movement = $data['movement'] ?? '';
            $this->detail = $data['detail'] ?? '';
            $this->imagePath = $data['imagePath'] ?? '';
            $this->imageFile = $data['imageFile'] ?? null;
        }

        public function save(){
            $errors = [];

            // validate data
            if (!$this->name){
                $errors[] = 'Please provide a name';
            }

            // Create images dir if not created
            if (!is_dir(__DIR__ . '/../public_html/images')){
                mkdir(__DIR__ . '/../public_html/images');
            }

            if (empty($errors)){
                if ($this->imageFile && $this->imageFile['tmp_name']){
                    // If the product already has an image
                    if ($this->imagePath){
                        rmdir(dirname(__DIR__ . '/../public_html/' . $this->imagePath));
                    }

                    $this->imagePath = 'images/' . UtilHelper::getUniqueDir() . '/' . $this->imageFile['name'];

                    // Create dir
                    $relpath = __DIR__ . '/../public_html/' . $this->imagePath;
                    mkdir(dirname($relpath));

                    move_uploaded_file($this->imageFile['tmp_name'], $relpath);
                }
                
                $db = Database::$db;

                if ($this->id){
                    $db->updateRank($this);
                } else {
                    $db->createRank($this);
                }
            }

            return $errors;
        }
    }