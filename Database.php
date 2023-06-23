<?php
//Names: Brianna Stewart
//Date: 4/26/2023
//Assignment: This program implements a php website for interacting with a database. 

class Database {

	// Constructor that connects to database on turing 
    public function __construct($username, $password) {
		$this->conn = false;
		$this->host = 'turing';           
		$this->username = $username;           
		$this->password = $password;  
		$this->dbaseName = $username;      
		$this->port = '3306';
		$this->debug = true;
		$this->connect();
    }
	
	// Destructor that disconnects from turing
	public function __destruct() {
        $this->disconnect();
    }
	
	// Connection to database
	public function connect() {
		if (!$this->conn) {
			try {
				$this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->dbaseName.'', 
										$this->username, $this->password, 
										array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));  
			}
			catch (Exception $e) {
				die('Error : ' . $e->getMessage());
			}
   
			if (!$this->conn) {
				$this->status_fatal = true;
				echo 'Connection BD failed';
				die();
			} 
			else {
				$this->status_fatal = false;
			}
		}
		return $this->conn;
    }
	
	public function disconnect() {
		if ($this->conn) {
			$this->conn = null;
		}	
    }

	// Inserts a record by taking a query as a parameter and executing it
    public function insertRecord($query) {
        try {
            $result = $this->conn->prepare($query);    
            $ret = $result->execute();
			if (!$ret) {
				return false;
			}
			return true;
        } catch (PDOException $e) {
            return false;
        }
    }

	// Gets an array of values by taking a table name and field name as parameters
    public function selectValues($table, $field) {
		// Creating query to select unique values from table
        $query = "SELECT DISTINCT $field FROM $table";
        try {
            $stmt = $this->conn->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			// Return results
            if (count($result) > 0) {
                return $result;
            } else { // No results from query
                return false;
            }
        } catch (PDOException $e) {
              return false;
        }
    }

	// Gets specified records by taking a query and field names as parameters
    public function selectRecords($query, $fields) {
        try {
			// Getting results of query
            $stmt = $this->conn->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			// Create an html table for data for results
            if (count($result) > 0) {
					  $html = "<table>";
			          $html .= "<tr><th>" . implode("</th><th>", $fields) . "</th></tr>";
                foreach ($result as $row) {
                    $html .= "<tr><td>" . implode("</td><td>", $row) . "</td></tr>";
                }
                $html .= "</table>";
                return $html;
            } else { // No results from query
                return false;
            }
        } catch (PDOException $e) {
              return false;
        }
    }
}