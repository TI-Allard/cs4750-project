<?php

// CREATE TABLE friends (
//    name varchar(30) NOT NULL,
//    major varchar(10) NOT NULL,
//    year int NOT NULL,
//    PRIMARY KEY (name) );

// Prepared statement (or parameterized statement) happens in 2 phases:
//   1. prepare() sends a template to the server, the server analyzes the syntax
//                and initialize the internal structure.
//   2. bind value (if applicable) and execute
//      bindValue() fills in the template (~fill in the blanks.
//                For example, bindValue(':name', $name);
//                the server will locate the missing part signified by a colon
//                (in this example, :name) in the template
//                and replaces it with the actual value from $name.
//                Thus, be sure to match the name; a mismatch is ignored.
//      execute() actually executes the SQL statement

$uname = null;

function authenticateUser($username, $pswd)
{
	global $db;
	//$query = "SELECT  COUNT(*)  FROM Profile WHERE username = :username AND pswd = :pswd";
    //printf("username " + $username);
    //printf("password " + $pswd);
    $query = "SELECT * FROM Profile WHERE username = :username AND pswd = :pswd";
	$statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':pswd', $pswd);
	$statement->execute();http://www.cs.virginia.edu/~

    $count = $statement->rowCount(); 
    if($count == "1"){
        $uname = $username;
        printf($uname);
    }
	
	// fetchAll() returns an array for all of the rows in the result set
	// $results = $statement->fetch();
	
	// closes the cursor and frees the connection to the server so other SQL statements may be issued
	$statement->closecursor();
	
	return $count;
}

function setUNAME($username){
    $uname = $username;
}

// -----Code for Library Events -----
function selectAllLibEvents(){
    // db
    global $db;
    // query
    $query = "SELECT * FROM LibEvent";
    // prepare
    $statement = $db->prepare($query);
    // execute
    $statement->execute();
    // retrieve
    $results = $statement->fetchAll(); // fetch()
    // close cursor
    $statement->closeCursor();
    // return result
    return $results;
}

function getContestEvents(){
    global $db;

    $query = "SELECT * FROM Contest NATURAL JOIN LibEvent";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(); // fetch()
    $statement->closeCursor();

    return $results;
}

function getReadingEvents(){
    global $db;

    $query = "SELECT * FROM Reading NATURAL JOIN LibEvent";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(); // fetch()
    $statement->closeCursor();

    return $results;
}

function getContest($event_id){
    global $db;

    $query = "SELECT * FROM Contest WHERE event_id=:event_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $results = $statement->fetch(); // fetch()
    $statement->closeCursor();

    return $results;
}

function getReading($event_id){
    global $db;

    $query = "SELECT * FROM Reading WHERE event_id=:event_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $results = $statement->fetch(); // fetch()
    $statement->closeCursor();

    return $results;
}

// ----- Code for Displaying Books that have been Reserved ----- 

function getReservedBooks($username){
    global $db;
    $query = "SELECT * FROM Reserves NATURAL JOIN BOOK WHERE username=:username";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$results = $statement->fetchAll();
	$statement->closeCursor();
	return $results;
}

// ----- Code for Checking out and Returning Books ----- 

function getAvailability($isbn){ //idk if i need this 
    global $db;
    
    $query = "SELECT copies_available FROM Book WHERE isbn=:isbn";
	$statement = $db->prepare($query);
	$statement->bindValue(':isbn', $isbn);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();
	return $results;
}

function checkoutBook($isbn){
    global $db;
    
    $query = "UPDATE Book SET copies_checked_out = copies_checked_out + 1 WHERE isbn = :isbn";
	$statement = $db->prepare($query);
	$statement->bindValue(':isbn', $isbn);
	$statement->execute();
	$results = $statement->fetchAll();
	$statement->closeCursor();
	return $results;
}

function getReviewsForBook($isbn){
    global $db;
    $query = "SELECT * FROM Review WHERE isbn=:isbn";
	$statement = $db->prepare($query);
	$statement->bindValue(':isbn', $isbn);
	$statement->execute();
	$results = $statement->fetchAll();
	$statement->closeCursor();
	return $results;
}

function selectAllBooks(){
    // db
    global $db;

    // query
    $query = "SELECT * FROM Book";

    // prepare
    $statement = $db->prepare($query);
    
    // execute
    $statement->execute();

    // retrieve
    $results = $statement->fetchAll(); // fetch()

    // close cursor
    $statement->closeCursor();

    // return result
    return $results;
}

function selectFeaturedBooks(){
    // db
    global $db;

    // query
    $query = "SELECT * FROM Book LIMIT 5";

    // prepare
    $statement = $db->prepare($query);
    
    // execute
    $statement->execute();

    // retrieve
    $results = $statement->fetchAll(); // fetch()

    // close cursor
    $statement->closeCursor();

    // return result
    return $results;
}

function getBookByTitle($title){
    global $db;
    $query = "select * from Book where title=:title";
	$statement = $db->prepare($query);
	$statement->bindValue(':title', $title);
	$statement->execute();
	$result = $statement->fetch();
	$statement->closeCursor();
	return $result;
}

function getBookByISBN($isbn){
    global $db;
    $query = "select * from Book where isbn=:isbn";
	$statement = $db->prepare($query);
	$statement->bindValue(':isbn', $isbn);
	$statement->execute();
	$result = $statement->fetch();
	$statement->closeCursor();
	return $result;
}
function getBooksRead($username){   
    global $db;
    $query = "select * from HasRead NATURAL JOIN Book where username=:username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $results = $statement->fetchAll(); //fetch()
    $statement->closeCursor();
    return $results;
}

function createreview($isbn, $username, $title, $body){
    global $db;
    $query = "insert into Review values (:isbn, NULL, :username, :title, :body)";
    $statement = $db->prepare($query);
    $statement->bindValue(':isbn', $isbn);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':body', $body);
    $statement->execute();
    $statement->closeCursor();
}

function getRole($username){   
    global $db;
    $query = "select admin from Profile where username=:username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $results = $statement->fetch(); //fetchAll()
    $statement->closeCursor();
    return $results;
}


function selectAllUsers(){
    global $db;
    $query = "select * from Profile";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(); // fetch()
    $statement->closeCursor();
    return $results;
}

function getFriends($username){   
    global $db;
    $query = "select * from FriendOf where username1=:username or username2=:username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $results = $statement->fetchAll(); //fetch()
    $statement->closeCursor();
    return $results;
}

// CODE FROM CLASS
// function getFriendInfo_by_name($name)
// {
// 	global $db;
	
// 	$query = "SELECT * FROM friends WHERE name = :name";
// 	$statement = $db->prepare($query);
// 	$statement->bindValue(':name', $name);
// 	$statement->execute();
	
// 	// fetchAll() returns an array for all of the rows in the result set
// 	// fetch() return a row
// 	$results = $statement->fetch();
	
// 	// closes the cursor and frees the connection to the server so other SQL statements may be issued
// 	$statement->closecursor();
	
// 	return $results;
// }

// function addFriend($name, $major, $year)
// {
// 	global $db;
	
// 	// insert into friends (name, major, year) values ('someone', 'CS', 4);
// 	$query = "INSERT INTO friends VALUES (:name, :major, :year)";
	
// 	try {
// 		$statement = $db->prepare($query);
// 		$statement->bindValue(':name', $name);
// 		$statement->bindValue(':major', $major);
// 		$statement->bindValue(':year', $year);	    
// 	   	$statement->execute();

// 		echo "number of rows affected = " . $statement->rowCount() . "##";
// 		if ($statement->rowCount() == 0)
// 			 echo "Failed to add a friend <br/>";
// 	} catch (PDOException $e) {
// 		echo $e->getMessage();
// 		// if (str_contains($e->getMessage(), "Duplicate"))
// 		//    echo "Failed to add a friend <br/>";
	
// 	//    echo "\nPDOStatement::errorInfo():\n";
//     //    $arr = $statement->errorInfo();
//     //    print_r($arr);
// 	}
// 	$statement->closeCursor();
// }

// function updateFriend($name, $major, $year)
// {
// 	global $db;
	
// 	$query = "UPDATE friends SET major=:major, year=:year WHERE name=:name";

// 	try {
// 		$statement = $db->prepare($query);
// 		$statement->bindValue(':name', $name);
// 		$statement->bindValue(':major', $major);
// 		$statement->bindValue(':year', $year);
// 		$statement->execute();
	
// 		echo "number of rows affected = " . $statement->rowCount() . "##";
// 		if ($statement->rowCount() == 0)
// 	   		echo "No row has been updated <br/>";	
	
// 		$statement->closeCursor();
// 	} catch (PDOException $e){
// 		echo $e->getMessage();
// 	}
// }

// function deleteFriend($name)
// {
// 	global $db;
	
// 	$query = "DELETE FROM friends WHERE name=:name";

// 	try {
// 		$statement = $db->prepare($query);
// 		$statement->bindValue(':name', $name);
// 		$statement->execute();

// 		echo "number of rows affected = " . $statement->rowCount() . "##";
// 		// if ($statement->rowCount() == 0) // this won't happen since we deleted the row we got from the table
// 		//   echo "no row has been deleted <br/>";

// 		if ($statement->rowCount() == 1) 
// 	  		echo "Delete successfully <br/>";

// 		$statement->closeCursor();
// 	} catch (PDOException $e){
// 		echo $e->getMessage();
// 	}
// }
?>