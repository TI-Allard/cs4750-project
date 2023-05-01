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

// for error reporting 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

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

// ----- Code for Adding to HasRead ----- 

function addHasRead($isbn, $username){
    global $db;
    $query = "insert into HasRead values (:isbn, :username)";
    //  ON DUPLICATE KEY UPDATE isbn=:isbn, username=:username
    $statement = $db->prepare($query);
    $statement->bindValue(':isbn', $isbn);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $statement->closeCursor();
}

// ----- Code for Displaying Books that have been Reserved ----- 

function getReservedBooks($username){
    global $db;
    $query = "SELECT * FROM Reserves NATURAL JOIN Book WHERE username=:username";
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

function getReservation($reserve_id){ //idk if i need this 
    global $db;
    
    $query = "SELECT  FROM Reserves WHERE (reserve_id=:reserve_id)";
	$statement = $db->prepare($query);
	$statement->bindValue(':reserve_id', $reserve_id);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();
	return $results;
}

function reserveBook($isbn, $username){
    global $db;
    // $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "insert into Reserves values (NULL, :isbn, :username)";
    //  ON DUPLICATE KEY UPDATE isbn=:isbn, username=:username
    $statement = $db->prepare($query);
    $statement->bindValue(':isbn', $isbn); //PDO::PARAM_INT
    $statement->bindValue(':username', $username);
    $statement->execute();
    $statement->closeCursor();
}

function deleteReservation($reserve_id){
    global $db;
    // $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "delete from Reserves where (reserve_id=:reserve_id)";
    //  ON DUPLICATE KEY UPDATE isbn=:isbn, username=:username
    $statement = $db->prepare($query);
    // $statement->bindValue(':isbn', $isbn); //PDO::PARAM_INT
    $statement->bindValue(':reserve_id', $reserve_id);
    $statement->execute();
    $statement->closeCursor();
}

function checkoutBook($isbn, $copies_checked_out){
    global $db;
    
    $query = "UPDATE Book SET copies_checked_out=:copies_checked_out WHERE isbn=:isbn";
	$statement = $db->prepare($query);
    $statement->bindValue(':copies_checked_out', $copies_checked_out);
	$statement->bindValue(':isbn', $isbn);
	$statement->execute();
	// $results = $statement->fetchAll(); 
	$statement->closeCursor();
}

function returnBook($isbn, $copies_checked_out){
    global $db;
    
    $query = "UPDATE Book SET copies_checked_out=:copies_checked_out WHERE isbn=:isbn";
	$statement = $db->prepare($query);
    $statement->bindValue(':copies_checked_out', $copies_checked_out);
	$statement->bindValue(':isbn', $isbn);
	$statement->execute();
	// $results = $statement->fetchAll(); 
	$statement->closeCursor();
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

function searchForBooks($search_term) {
    global $db;
    $search_term = htmlspecialchars($search_term);
    $query = "select * from Book where (title like '%".$search_term."%') or (author LIKE '%".$search_term."%')";
    $statement = $db->prepare($query);
    $statement->bindValue(':search_term', $search_term, PDO::PARAM_STR);
	$statement->execute();
	$result = $statement->fetchAll();
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

function addBookRating($isbn, $username, $overall_stars, $plot, $characters, $writing_style){
    global $db;
    $query = "insert into Rating values (:isbn, NULL, :username, :overall_stars, :plot, :characters, :writing_style)";
    $statement = $db->prepare($query);
    $statement->bindValue(':isbn', $isbn);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':overall_stars', $overall_stars);
    $statement->bindValue(':plot', $plot);
    $statement->bindValue(':characters', $characters);
    $statement->bindValue(':writing_style', $writing_style);
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


function deleteReview($review_id){
    global $db;
    //echo $review_id;
    $query = "delete from Review where review_id=:review_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':review_id', $review_id);
    $statement->execute();
    $statement->closeCursor();
}

function updateReview($review_id, $title, $body){
    global $db;
    $query = "update Review set title=:title, body=:body where review_id=:review_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':body', $body);
    $statement->bindValue(':review_id', $review_id);
    $statement->execute();
    $statement->closeCursor();
}

function getReviewByID($review_id){
    global $db;
	$query = "select * from Review where review_id=:review_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':review_id', $review_id);
	$statement->execute();
	$result = $statement->fetch();
	$statement->closeCursor();
	return $result;
}

function getAverageOverallRating($isbn){
    global $db;
	$query = "SELECT AVG(overall_stars) FROM Rating WHERE isbn=:isbn";
    $statement = $db->prepare($query);
    $statement->bindValue(':isbn', $isbn);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;

}

function getAveragePlotRating($isbn){
    global $db;
	$query = "SELECT AVG(plot) FROM Rating WHERE isbn=:isbn";
    $statement = $db->prepare($query);
    $statement->bindValue(':isbn', $isbn);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;

}

function getAverageCharactersRating($isbn){
    global $db;
	$query = "SELECT AVG(characters) FROM Rating WHERE isbn=:isbn";
    $statement = $db->prepare($query);
    $statement->bindValue(':isbn', $isbn);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;

}

function getAverageWritingStyleRating($isbn){
    global $db;
	$query = "SELECT AVG(writing_style) FROM Rating WHERE isbn=:isbn";
    $statement = $db->prepare($query);
    $statement->bindValue(':isbn', $isbn);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;

}

function getUserBookRating($isbn, $username){
    //SELECT * FROM Rating WHERE username=:username AND isbn=:isbn
    global $db;
	$query = "SELECT * FROM Rating WHERE username=:username AND isbn=:isbn";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
    $statement->bindValue(':isbn', $isbn);
	$statement->execute();
	$result = $statement->fetch();
	$statement->closeCursor();
	return $result;
}

function getAvailabilityStatus($copies_checked_out, $total_copies){
    global $db;
	$query = "SELECT status 
        from Book, CopyInfo 
        where Book.copies_checked_out = CopyInfo.copies_checked_out 
            AND Book.total_copies = CopyInfo.total_copies 
            AND Book.copies_checked_out=:copies_checked_out 
            AND Book.total_copies=:total_copies";
    $statement = $db->prepare($query);
    $statement->bindValue(':copies_checked_out', $copies_checked_out);
    $statement->bindValue(':total_copies', $total_copies);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function addFriend($un_1, $un_2){
    global $db;
    // $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $query = "insert into FriendOf (friend_id, username1, username2, accept, reject) values (NULL, :username1, :username2, :acc, :rej)";
    $statement = $db->prepare($query);
    $statement->bindValue(':username1', $un_1);
    $statement->bindValue(':username2', $un_2);
    $statement->bindValue(':acc', 0);
    $statement->bindValue(':rej', 0);
    $statement->execute();
    $statement->closeCursor();
}

function setRequestAccept($un_1, $un_2){
    global $db;
    $query = "update FriendOf set accept=:accept where username1=:username1 AND username2=:username2";
    $statement = $db->prepare($query);
    $statement->bindValue(':accept', TRUE);
    $statement->bindValue(':username1', $un_1);
    $statement->bindValue(':username2', $un_2);
    $statement->execute();
    $statement->closeCursor();
}

function setRequestReject($un_1, $un_2){
    global $db;
    $query = "update FriendOf set reject=:reject where username1=:username1 AND username2=:username2";
    $statement = $db->prepare($query);
    $statement->bindValue(':reject', TRUE);
    $statement->bindValue(':username1', $un_1);
    $statement->bindValue(':username2', $un_2);
    $statement->execute();
    $statement->closeCursor();
}

function removeFriend($un_1, $un_2){
    global $db;
    $query = "delete from FriendOf where (username1=:username1 AND username2=:username2) or (username1=:username1 AND username2=:username2)";
    $statement = $db->prepare($query);
    $statement->bindValue(':username1', $un_1);
    $statement->bindValue(':username2', $un_2);
    $statement->execute();
    $statement->closeCursor();
}

function setAdmin($username){
    global $db;
    $query = "update Profile set admin=:admin where username=:username";
    $statement = $db->prepare($query);
    $statement->bindValue(':admin', TRUE);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $statement->closeCursor();
}

function deleteBook($isbn){
    global $db;
    //echo $review_id;
    $query = "delete from Book where isbn=:isbn";
    $statement = $db->prepare($query);
    $statement->bindValue(':isbn', $isbn);
    $statement->execute();
    $statement->closeCursor();
}

function emptyInputBook($isbn, $title, $author, $total_copies){
    if (empty($isbn) || empty($title) || empty($author) || empty($title)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidDate($date) {
    if (!preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[1-2]{1}[0-9]{3}$/", $date) AND ($date <> NULL)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function addBook($isbn, $title, $author, $genre, $date_published, $book_cover, $total_copies, $copies_checked_out, $average_rating){
    global $db;
    // $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $query = "insert into Book (isbn, title, author, genre, date_published, book_cover, total_copies, copies_checked_out, average_rating) values (:isbn, :title, :author, :genre, :date_published, :book_cover, :total_copies, :copies_checked_out, :average_rating)";
    $statement = $db->prepare($query);
    $statement->bindValue(':isbn', $isbn);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':author', $author);
    $statement->bindValue(':genre', $genre);
    $statement->bindValue(':date_published', $date_published);
    $statement->bindValue(':book_cover', $book_cover);
    $statement->bindValue(':total_copies', $total_copies);
    $statement->bindValue(':copies_checked_out', $copies_checked_out);
    $statement->bindValue(':average_rating', $average_rating);
    $statement->execute();
    $statement->closeCursor();
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