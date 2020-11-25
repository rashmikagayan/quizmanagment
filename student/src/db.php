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
    
    // Student Join

    public function joinExam($stdId,$password){
        // Check if the student exist
        $query = "SELECT * FROM students WHERE student_id = '$stdId'";
        if (!$this->query_closed) {
            $this->query->close();
        }
		if ($this->query = $this->connection->prepare($query)) {
            
            $store = $this->connection->query($query);

            if ($store->num_rows > 0) {
                // output data of each row
                while($row = $store->fetch_assoc()) {
                    if($row['password']==$password){
                        $this->createSession($stdId);
                    }else{
                        echo "Wrong pass";
                    }
                }
            } else {
                $query = "INSERT INTO  students(student_id,password) VALUES('$stdId', '$password')";
                $this->query = $this->connection->prepare($query);
                $this->query->execute();
                $this->createSession($stdId);
            }
           	
        } else {
            $this->error('Unable to prepare MySQL statement (check your syntax) - ' . $this->connection->error);
        }
        
        $this->query_closed = TRUE;
		return $this;
    }


    private function createSession($studentId){
        $_SESSION['id'] = $this->generateRandomString(10);
        $_SESSION['email'] = $studentId;
    }

    // Fetch papers list 
	public function fetchPapers($studentId) {
        $result= array();
        $query = "SELECT * FROM `paper` INNER JOIN joined_exams ON paper.paper_id = joined_exams.paper_id WHERE joined_exams.student_id = '$studentId'";
        if (!$this->query_closed) {
            $this->query->close();
        }
		if ($this->query = $this->connection->prepare($query)) {
            
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
				$this->error('Unable to process MySQL query' . $this->query->error);
           	}
            $this->query_closed = FALSE;
        } else {
            $this->error('Unable to prepare MySQL statement (check your syntax) - ' . $this->connection->error);
        }
        
        $this->query->close();
        $this->query_closed = TRUE;
		return $result;
    }

    // Join exam
    public function joinPaper($subjectCode,$stdId){
        // Check if the paper exist
        $query = "SELECT * FROM paper WHERE paper_id = '$subjectCode'";
        if (!$this->query_closed) {
            $this->query->close();
        }
		if ($this->query = $this->connection->prepare($query)) {
            
            $store = $this->connection->query($query);

            if ($store->num_rows > 0) {
                // output data of each row
                $query = "SELECT * FROM joined_exams WHERE student_id = '$stdId' AND paper_id = '$subjectCode'";
                if (!$this->query_closed) {
                    $this->query->close();
                }
                if ($this->query = $this->connection->prepare($query)) {
                    
                    $store = $this->connection->query($query);

                    if ($store->num_rows > 0) {
                        // output data of each row
                        echo "already joined";
                    } else {
                        $query = "INSERT INTO  joined_exams(student_id,paper_id) VALUES('$stdId', '$subjectCode')";
                        $this->query = $this->connection->prepare($query);
                        $this->query->execute();
                    }
                    
                } else {
                    $this->error('Unable to prepare MySQL statement (check your syntax) - ' . $this->connection->error);
                }
            } else {
                echo "Wrong exam code";
            }
           	
        } else {
            $this->error('Unable to prepare MySQL statement (check your syntax) - ' . $this->connection->error);
        }
        
        $this->query_closed = TRUE;
		return $this;
    }

    
     // Fetch papers list 
	public function startPaper($paperId) {
        $result= array();
        $query = "SELECT paper_id FROM paper WHERE paper_id = '$paperId'";
        if (!$this->query_closed) {
            $this->query->close();
        }
		if ($this->query = $this->connection->prepare($query)) {
            
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
				$this->error('Unable to process MySQL query' . $this->query->error);
           	}
            $this->query_closed = FALSE;
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
				$this->error('Unable to process MySQL query' . $this->query->error);
           	}
            $this->query_closed = FALSE;
        } else {
            $this->error('Unable to prepare MySQL statement (check your syntax) - ' . $this->connection->error);
        }
		return $this;
    }
    // Save edited paper
    public function submitPaper($qno,$ansNum,$paperId,$stdId){
        $query = "INSERT INTO submittions(paper_id,student_id,qno,answer) values('$paperId','$stdId','$qno','$ansNum')";
        if (!$this->query_closed) {
            $this->query->close();
        }
		if ($this->query = $this->connection->prepare($query)) {
            $this->query->execute();
           	if ($this->query->errno) {
				$this->error('Unable to process MySQL query' . $this->query->error);
           	}
            $this->query_closed = FALSE;
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
				$this->error('Unable to process MySQL query' . $this->query->error);
           	}
            $this->query_closed = FALSE;
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