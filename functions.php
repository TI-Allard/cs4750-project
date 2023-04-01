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


function authenticateUser($username, $password)
{
	global $db;
	$query = "SELECT  COUNT(*)  FROM Profile WHERE username = :username AND password = :password";
	$statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', $password);
	$statement->execute();
	
	// fetchAll() returns an array for all of the rows in the result set
	$results = $statement->fetch();
	
	// closes the cursor and frees the connection to the server so other SQL statements may be issued
	$statement->closecursor();
	
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