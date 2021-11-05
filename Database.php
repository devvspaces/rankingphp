<?php

    namespace app;

    use PDO;
    use app\models\Rank;

    class Database
    {
        public \PDO $pdo;
        public static $db;

        public function __construct(){
            $this->pdo = new PDO("mysql:host=localhost;port=3306;dbname=u888620740_rank_crud", "black23", "Testpass123");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // black23 Testpass123

            self::$db = $this;
        }

        public function getRanks($search=''){
            if ($search){
                $statement = $this->pdo->prepare("SELECT * FROM rank WHERE name LIKE :name ORDER BY position");
                $statement->bindValue(':name', "%$search%");
            } else {
                $statement = $this->pdo->prepare("SELECT * FROM rank ORDER BY position");
            }

            $statement->execute();
            $rank = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $rank;
        }

        public function getRankById($id){
            $statement = $this->pdo->prepare("SELECT * FROM rank WHERE id = :id");
            $statement->bindValue(':id', $id);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        }

        public function deleteRank($id){
            $statement = $this->pdo->prepare("DELETE FROM rank WHERE id = :id");

            // Bind values
            $statement->bindValue(':id', $id);

            $statement->execute();
        }

        public function createRank(Rank $Rank){
            // Make query
            $statement = $this->pdo->prepare("INSERT INTO rank (name, position, movement, count, image)
                VALUES (:name, :position, :movement, :count, :image)
            ");

            // Bind values
            $statement->bindValue(':name', $Rank->name);
            $statement->bindValue(':position', $Rank->position);
            $statement->bindValue(':movement', $Rank->movement);
            $statement->bindValue(':count', $Rank->count);
            $statement->bindValue(':image', $Rank->imagePath);

            $statement->execute();
        }

        public function updateRank(Rank $Rank){
            // Make query
            $statement = $this->pdo->prepare("UPDATE rank SET name = :name, position = :position,
            movement = :movement, count = :count, image = :image WHERE id = :id");

            $statement->bindValue(':name', $Rank->name);
            $statement->bindValue(':position', $Rank->position);
            $statement->bindValue(':movement', $Rank->movement);
            $statement->bindValue(':count', $Rank->count);
            $statement->bindValue(':image', $Rank->imagePath);
            $statement->bindValue(':id', $Rank->id);

            $statement->execute();
        }
    }
    