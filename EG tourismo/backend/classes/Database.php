<?php
require_once __DIR__ . '/../config/config.php';

class Database {
    private static $instance = null;
    private $connection;
    
    public function __construct() {
        $this->connect();
    }
    
    private function connect() {
        try {
            $this->connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_PERSISTENT => true
                ]
            );
        } catch (PDOException $e) {
            if ($e->getCode() == 1049) {
                $this->createDatabase();
            } else {
                error_log("Database connection failed: " . $e->getMessage());
                throw new Exception("Database connection failed. Please try again later.");
            }
        }
    }
    
    public function createDatabase() {
        try {
            // First create the database
            $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Drop and recreate database
            $pdo->exec("DROP DATABASE IF EXISTS " . DB_NAME);
            $pdo->exec("CREATE DATABASE " . DB_NAME);
            $pdo->exec("USE " . DB_NAME);
            
            // Now connect to the new database
            $this->connect();
            
            // Read and execute SQL file
            $sql = file_get_contents(__DIR__ . '/../database/final.sql');
            if ($sql === false) {
                throw new Exception("Could not read SQL file");
            }
            
            // Disable foreign key checks temporarily
            $this->connection->exec("SET FOREIGN_KEY_CHECKS = 0");
            
            // Split SQL file into individual statements
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            
            // Execute each statement separately
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    try {
                        $this->connection->exec($statement);
                    } catch (PDOException $e) {
                        error_log("Error executing SQL statement: " . $e->getMessage());
                        error_log("Statement: " . $statement);
                        // Continue with next statement
                    }
                }
            }
            
            // Re-enable foreign key checks
            $this->connection->exec("SET FOREIGN_KEY_CHECKS = 1");
            
            // Verify zona_turismo table was created
            $tables = $this->connection->query("SHOW TABLES LIKE 'zona_turismo'")->fetchAll();
            if (empty($tables)) {
                throw new Exception("Failed to create zona_turismo table");
            }
            
        } catch (PDOException $e) {
            error_log("Database creation failed: " . $e->getMessage());
            throw new Exception("Database setup failed: " . $e->getMessage());
        } catch (Exception $e) {
            error_log("Database creation failed: " . $e->getMessage());
            throw new Exception("Database setup failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        if (!$this->connection) {
            $this->connect();
        }
        return $this->connection;
    }
    
    public function prepare($query) {
        if (!$this->connection) {
            $this->connect();
        }
        return $this->connection->prepare($query);
    }
    
    public function query($sql, $params = []) {
        try {
            $stmt = $this->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            if ($e->getCode() == 2006) { // MySQL server has gone away
                $this->connect();
                $stmt = $this->prepare($sql);
                $stmt->execute($params);
                return $stmt->fetchAll();
            }
            throw $e;
        }
    }
    
    public function queryOne($sql, $params = []) {
        try {
            $stmt = $this->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            if ($e->getCode() == 2006) { // MySQL server has gone away
                $this->connect();
                $stmt = $this->prepare($sql);
                $stmt->execute($params);
                return $stmt->fetch();
            }
            throw $e;
        }
    }
    
    public function execute($sql, $params = []) {
        try {
            $stmt = $this->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            if ($e->getCode() == 2006) { // MySQL server has gone away
                $this->connect();
                $stmt = $this->prepare($sql);
                return $stmt->execute($params);
            }
            throw $e;
        }
    }
    
    // Prevent cloning of the instance
    private function __clone() {}
    
    // Prevent unserializing of the instance
    public function __wakeup() {}
} 