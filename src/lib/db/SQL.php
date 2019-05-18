<?php

/**
 * Class SimpleSQL
 *
 * Simplifies using MySQLi by maintaining a singleton instance
 * and a simple query function to run paramterized queries.
 * 
 * Created By: Tyler Sriver
 * @author <tyler.w.sriver@eagles.oc.edu>
 */
class SQL
{
    // -- Connection Strings
    private  $servername = MYSQL_SERVER;
    private  $username = MYSQL_USER;
    private  $password = MYSQL_PASSWORD;
    private  $db = MYSQL_DB;

    private $conn; // MySQLi Connection
    private static $instance = null;

    private function __construct()
    {
        $this->conn = new \mysqli($this->servername, $this->username, $this->password, $this->db);
        if($this->conn->connect_error){
            die("Connection failed: " . $this->conn->connect_error);
        }    
    }

    public static function getInstance()
    {
        if(!self::$instance) {
            self::$instance = new SQL();
        }
        return self::$instance;
    }

    public function getConn()
    {
        return $this->conn;
    }

    public function close()
    {
        $this->conn->close();
    }

    private function __clone() {}
    private function __wakeup() {}
  
    /**
     * MySQLi bound query function
     *
     * @param $sql string - The query to be executed
     * @param $params array - Array of the parameters for the query
     * @return bool | array
     */
    public function query($sql, $params = array())
    {
        $db = self::getInstance();
        $sql = trim($sql); // Trim extra whitespace
        $params = (array)$params;
        $result = false;

        // Initiate statement
        $conn = $db->getConn();
        $stmt = $conn->prepare($sql);
        if(!$stmt) {
            die('SQL Error: ' . $sql);
        }

        // Build types array
        $types = self::buildTypeStringFromArray($params);

        // Bind params
        if (!empty($params)) {
            $binds = array($types);
            $binds = array_merge($binds, $params);
            $newBinds = self::makeValuesReferenced($binds);
            call_user_func_array([$stmt, 'bind_param'], $newBinds);
        }

        // Execute SQL
        if(!$stmt->execute()) {
            return $result;
        }

        // Return if no result
        if($stmt->affected_rows >= 0 ) {
            return $conn->insert_id;
        } 

        // return selected results
        $result = $stmt->get_result();
        if($result != null && $result != false) {
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            mysqli_free_result($result);
            return $data;
        }
        return $result;
    }

    /**
     * Make array pass by reference
     * 
     * @param $arr array
     * @return array
     */
    private function makeValuesReferenced(&$arr)
    {
        $refs = array();
        foreach($arr as $key => $value){
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }

    /**
     * Build string of types from an array
     *
     * Possible types:
     *  boolean b
     *  double d
     *  integer i
     *  string s
     *
     * @param $params array
     * @return string
     */
    private function buildTypeStringFromArray($params)
    {
        $types = "";
        foreach($params as &$p){
            switch (gettype($p)) {
                case 'boolean':
                    $bind = $bind ? 1 : 0;
                    $types .= 'i';
                    break;
                case 'double':
                    $types .= 'd';
                    break;
                case 'integer':
                    $types .= 'i';
                    break;
                case 'string':
                default:
                    $types .= 's';
            }
        }
        return $types;
    }
}

