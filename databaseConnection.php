<?php
    //no access specifier provided
    class Database {
        private $host = 'localhost'; 
        private $db_name = 'laundrobook'; 
        private $username = 'root'; 
        private $password = ''; 
        private $pdo; 


        public function connect(){
            //I've wrapped this in a try-catch to ensure that we only 
            //attempt to establish a db connection if none exists already
            if($this->pdo == null){
                try{
                    $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
                    $this->pdo = new PDO($dsn, $this->username, $this->password);
                    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                    $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);  
                } catch(PDOException $e){
                    //this has to be changed into a different format instead of it being thrown
                    //to the user of the system
                    die("Database Connection Failed: ". $e->getMessage()); 
                }
            }
            return $this->pdo; 
        }
    }
    // Usage example in another class that has included the db connection file:
    // $db = new Database();
    // $pdo = $db->connect();
?>