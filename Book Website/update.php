<?php
$page_title = 'Books - Update';
$heading = "Update";
include ('header.htm');

	if ($errorcode != 1) {
		if (isset($_REQUEST['UPDATECHANGES'])){
			$isbn = $_REQUEST['ISBN'];
			$title = $_REQUEST['TITLE'];
			$series = $_REQUEST['SERIES'];
			$nseries = $_REQUEST['NSERIES'];
			$author = $_REQUEST['AUTHOR'];
			$type = $_REQUEST['TYPE'];
			$pages = $_REQUEST['PAGES'];
			$status = $_REQUEST['STATUS'];
			$read = $_REQUEST['READ'];
			$comments = $_REQUEST['COMMENTS'];
			$image = $_REQUEST['IMAGE'];
			
			$q = "DELETE FROM BookDataTable WHERE ISBN = '$isbn'";
			$r = mysql_query($q, $link);
			$q = "DELETE FROM CurrentBookStatusTable WHERE ISBN = '$isbn'";
			$r = mysql_query($q, $link);
			$q = "DELETE FROM BookTable WHERE ISBN = '$isbn'";
			$r = mysql_query($q, $link);
			
			$count = 0;
			$r = '';
			$q = "INSERT IGNORE INTO BookDataTable (ISBN, AuthorID, SeriesID, NoInSeries, Pages, BookTypeID, Comments, ImageURL) VALUES (\"$isbn\", \"$author\", \"$series\", \"$nseries\", \"$pages\", \"$type\", \"$comments\", \"$image\")";
			$r = mysql_query($q, $link);
			if (mysql_affected_rows() == 1) {
				$count = $count + 1;
			}
			$r = '';
			$q = "INSERT IGNORE INTO CurrentBookStatusTable (ISBN, StatusID, NoTimesRead) VALUES (\"$isbn\", \"$status\", \"$read\")";
			$r = mysql_query($q, $link);
			if (mysql_affected_rows() == 1) {
				$count = $count + 1;
			}
			$r = '';
			$q = "INSERT IGNORE INTO BookTable (ISBN, BookTitle) VALUES (\"$isbn\", \"$title\")";
			$r = mysql_query($q, $link);
			if (mysql_affected_rows() == 1) {
				$count = $count + 1;
			}
			if ($count != 3) {
				$q = "DELETE FROM BookDataTable WHERE ISBN = '$isbn'";
				$r = mysql_query($q, $link);
				$q = "DELETE FROM CurrentBookStatusTable WHERE ISBN = '$isbn'";
				$r = mysql_query($q, $link);
				$q = "DELETE FROM BookTable WHERE ISBN = '$isbn'";
				$r = mysql_query($q, $link);
				echo "<p>Sorry, the book with ISBN: $isbn couldn't be updated successfully, it has now been removed from the database.</p>";
			}
			else {
				echo "<p>Update of the book with ISBN: $isbn has been successful.</p>";
			}
		}		
	}

include ('footer.htm');
?>