<?php
require_once 'Database.php';

class Admin {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function login($email, $password) {
        try {
            error_log("=== Login Attempt Start ===");
            error_log("Email: " . $email);
            error_log("Password length: " . strlen($password));
            
            // First check if the database connection is working
            if (!$this->db) {
                error_log("Database connection is null");
                throw new Exception("Database connection failed");
            }
            
            // Get the admin user
            $stmt = $this->db->prepare("SELECT * FROM admin_users WHERE email = ?");
            if (!$stmt) {
                error_log("Failed to prepare statement");
                throw new Exception("Database error");
            }
            
            $stmt->execute([$email]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            error_log("Admin data: " . print_r($admin, true));
            
            if (!$admin) {
                error_log("No admin found with email: " . $email);
                return [
                    'success' => false,
                    'message' => 'Invalid username or password'
                ];
            }
            
            error_log("Stored password hash: " . $admin['password']);
            error_log("Attempting to verify password");
            
            // Verify the password
            $passwordVerified = password_verify($password, $admin['password']);
            error_log("Password verification result: " . ($passwordVerified ? "true" : "false"));
            
            if ($passwordVerified) {
                error_log("Login successful");
                return [
                    'success' => true,
                    'admin' => [
                        'id' => $admin['id'],
                        'name' => $admin['full_name']
                    ],
                    'message' => 'Login successful'
                ];
            } else {
                error_log("Password verification failed");
                return [
                    'success' => false,
                    'message' => 'Invalid username or password'
                ];
            }
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An error occurred during login'
            ];
        } finally {
            error_log("=== Login Attempt End ===");
        }
    }
    
    public function register($username, $password, $name, $email) {
        // Check if username or email already exists
        $stmt = $this->db->prepare("SELECT * FROM admin_users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        $existing = $stmt->fetchAll();
        
        if (!empty($existing)) {
            return false;
        }
        
        // Hash password and create admin
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("
            INSERT INTO admin_users (username, password, full_name, email) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$username, $hashedPassword, $name, $email]);
    }
    
    public function updateAdmin($id, $name, $email, $password = '') {
        // Check if email is already used by another admin
        $stmt = $this->db->prepare("SELECT * FROM admin_users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);
        $existing = $stmt->fetchAll();
        
        if (!empty($existing)) {
            return false;
        }
        
        if (!empty($password)) {
            // Update with new password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("
                UPDATE admin_users 
                SET full_name = ?, email = ?, password = ? 
                WHERE id = ?
            ");
            return $stmt->execute([$name, $email, $hashedPassword, $id]);
        } else {
            // Update without changing password
            $stmt = $this->db->prepare("
                UPDATE admin_users 
                SET full_name = ?, email = ? 
                WHERE id = ?
            ");
            return $stmt->execute([$name, $email, $id]);
        }
    }
    
    public function deleteAdmin($id) {
        $stmt = $this->db->prepare("DELETE FROM admin_users WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getAllAdmins() {
        $stmt = $this->db->query("
            SELECT id, username, full_name, email, created_at 
            FROM admin_users 
            ORDER BY full_name ASC
        ");
        return $stmt->fetchAll();
    }
    
    public function getAdminById($id) {
        $stmt = $this->db->prepare("
            SELECT id, username, full_name, email, created_at 
            FROM admin_users 
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function changePassword($id, $currentPassword, $newPassword) {
        // Verify current password
        $stmt = $this->db->prepare("SELECT password FROM admin_users WHERE id = ?");
        $stmt->execute([$id]);
        $admin = $stmt->fetch();
        
        if (!$admin || !password_verify($currentPassword, $admin['password'])) {
            return false;
        }
        
        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE admin_users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashedPassword, $id]);
    }
} 