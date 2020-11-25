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
    
     // Fetch papers list 
	public function editPaper($email,$paperId) {
        $result= array();
        $query = "SELECT paper_id FROM paper WHERE lect_email = '$email' AND paper_id = '$paperId'";
        if (!$this->query_closed) {
            $this->query->close();
        }
		if ($this->query = $this->connection->prepare($query)) {
            
            //$this->query->execute();
            //$result = $this->query->fetch();
            $store = $this->connection->query($query);

            if ($store->num_rows > 0) {
                // If lecturer created the paper allow edit
                $query = "SELECT * FROM questions WHERE paper_id = '$paperId' ORDER BY qno";
                $store = $this->connection->query($query);

                if ($store->num_rows > 0) {
                    // display questions
                    while($row = $store->fetch_assoc()) {
                        array_push($result, $row);
                    }
                } else {
                echo "No questions added";
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
    // Save edited paper
    public function saveEditedPaper($qarr){
        $query = "INSERT INTO questions(paper_id,qno,question,ans1,ans2,ans3,ans4,correct_answer) 
        values('$qarr[0]','$qarr[1]','$qarr[2]','$qarr[3]','$qarr[4]','$qarr[5]','$qarr[6]','$qarr[7]')";
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

    // Delete all questions from paper
    public function deleteAllQuestions($paperId){
        $query = "DELETE FROM questions WHERE paper_id = '$paperId'";
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
    // Logout
    public function logout(){
        session_unset();
        session_destroy(); 
    }

    // Delete Whole Paper
    public function deletePaper($paperId){
        $query = "DELETE FROM paper WHERE paper_id = '$paperId'";
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
        $this->deleteAllQuestions($paperId);
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