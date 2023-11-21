<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'akademines_root');
define('DB_PASSWORD', 'Root123');
define('DB_NAME', 'akademines_sistema');

define('BASE_URL', 'http://akademinesistema.us.lt');

class DB {
    private static $instance = null;
   
    public static function get() {
        if (self::$instance == null) {
            try {
                self::$instance = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            } catch(PDOException $e) {
                die("Nepavyko prisijungti prie duomenu bazes: " . $e->getMessage());
            }
        }
        
        return self::$instance;
    }
}
?>