<?php
class db {

    protected $connection;
	protected $query;
    protected $show_errors = TRUE;
    protected $query_closed = TRUE;
	public $query_count = 0;

	public function __construct($dbhost = 'localhost', $dbuser = 'root', $dbpass = '', $dbname = 'quiz', $charset = 'utf8') {
		$this->connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		if ($this->connection->connect_error) {
			$this->error('Failed to connect to MySQL - ' . $this->connection->connect_error);
		}
		$this->connection->set_charset($charset);
    }
    
    // Lecturer Login in

    public function lectLogin($email,$pass){
        $paperId = $this->generateRandomString(6);  
        $query = "SELECT * FROM lecturer WHERE email = '$email' && password = '$pass'";
        if (!$this->query_closed) {
            $this->query->close();
        }
		if ($this->query = $this->connection->prepare($query)) {
            
            $this->query->execute();
           	if ($this->query->errno) {
				$this->error('Unable to process MySQL query (check your params) - ' . $this->query->error);
           	}
            $this->query_closed = FALSE;
            $this->query_count++;
            $this->createSession($email);
        } else {
            $this->error('Unable to prepare MySQL statement (check your syntax) - ' . $this->connection->error);
        }

		return $this;
    }


    private function createSession($email){
        $_SESSION['id'] = $this->generateRandomString(10);
        $_SESSION['email'] = $email;
    }

    // Fetch papers list 
	public function fetchPapers($email) {
        $result= array();
        $query = "SELECT * FROM paper WHERE lect_email = '$email'";
        if (!$this->query_closed) {
            $this->query->close();
        }
		if ($this->query = $this->connection->prepare($query)) {
            
            //$this->query->execute();
            //$result = $this->query->fetch();
            $store = $this->connection->query($query);

            if ($store->num_rows > 0) {
            // output data of each row
            while($row = $store->fetch_assoc()) {
                array_push($result, $row);
            }
            } else {
            echo "0 results";
            }
            
           
           	if ($this->query->errno) {
				$this->error('Unable to process MySQL query (check your params) - ' . $this->query->error);
           	}
            $this->query_closed = FALSE;
            $this->query_count++;
        } else {
            $this->error('Unable to prepare MySQL statement (check your syntax) - ' . $this->connection->error);
        }
        
        $this->query->close();
        $this->query_closed = TRUE;
		return $result;
	}



    // Create a paper   
    // a lecturer can create a paper with a auto generated code which later students can use to join using and answer the quiz
    // Generate random class id using a private function with 6 varchars
    public function createPaper($classname,$lectemail){
        $paperId = $this->generateRandomString(6);  
        $query = "INSERT INTO paper(paper_id,subject_name,lect_email) values('$paperId','$classname','$lectemail')";
        if (!$this->query_closed) {
            $this->query->close();
        }
		if ($this->query = $this->connection->prepare($query)) {
            
            $this->query->execute();
           	if ($this->query->errno) {
				$this->error('Unable to process MySQL query (check your params) - ' . $this->query->error);
           	}
            $this->query_closed = FALSE;
			$this->query_count++;
        } else {
            $this->error('Unable to prepare MySQL statement (check your syntax) - ' . $this->connection->error);
        }
		return $this;
    }

    // generate random string
    function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

	public function close() {
		return $this->connection->close();
	}

    public function numRows() {
		$this->query->store_result();
		return $this->query->num_rows;
	}

	public function affectedRows() {
		return $this->query->affected_rows;
	}

    public function lastInsertID() {
    	return $this->connection->insert_id;
    }

    public function error($error) {
        if ($this->show_errors) {
            exit($error);
        }
    }

	private function _gettype($var) {
	    if (is_string($var)) return 's';
	    if (is_float($var)) return 'd';
	    if (is_int($var)) return 'i';
	    return 'b';
	}

}
?>