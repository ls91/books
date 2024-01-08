<?php
$page_title = 'Books - Add a Book';
$heading = "Add a Book";
include ('header.htm');

	if ($errorcode != 1) {		
		if (isset($_REQUEST['ADDBOOK'])){
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
			
			$q = "SELECT ISBN FROM BookTable WHERE ISBN ='$isbn'";
			$r = mysql_query($q, $link);
			if (mysql_num_rows($r) == 1){
				echo "A book with the ISBN: $isbn already exists, to modify this book's properties use the 'Modify Book' link.";
			}
			else {
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
					echo "<p>Sorry, You have unsuccessfully added the book with ISBN: $isbn</p>";
				}
				else {
					echo "<p>You have successfully added the book with ISBN: $isbn</p>";
				}
			}
		}
		
		$q = 'SELECT BStatID, BookStatus FROM BookStatusTable';
		$r = mysql_query($q, $link);
		$dropoptions = '';
		while ($option = mysql_fetch_array($r, MYSQL_ASSOC)){
			$dropoptions .= '<option value="'.$option['BStatID'].'">'.$option['BookStatus'].'</option>';
		}
		$q = 'SELECT AuthorID, AuthorFN, AuthorMN, AuthorSN FROM AuthorTable ORDER BY AuthorSN, AuthorFN';
		$r = mysql_query($q, $link);
		$dropoptions2 = '';
		while ($option = mysql_fetch_array($r, MYSQL_ASSOC)){
			$text = '';
			$text .= $option['AuthorSN'].', '.$option['AuthorFN'].' '.$option['AuthorMN'];
			$dropoptions2 .= '<option value="'.$option['AuthorID'].'">'.$text.'</option>';
		}
		$q = 'SELECT BTID, BookType FROM BookTypeTable';
		$r = mysql_query($q, $link);
		$dropoptions3 = '';
		while ($option = mysql_fetch_array($r, MYSQL_ASSOC)){
			$dropoptions3 .= '<option value="'.$option['BTID'].'">'.$option['BookType'].'</option>';
		}
		$q = 'SELECT BSerID, SeriesName FROM BookSeriesTable ORDER BY SeriesName';
		$r = mysql_query($q, $link);
		$dropoptions4 = '';
		while ($option = mysql_fetch_array($r, MYSQL_ASSOC)){
			$dropoptions4 .= '<option value="'.$option['BSerID'].'">'.$option['SeriesName'].'</option>';
		}

		echo '<p><form name="add" action="add.php" method="POST">
			<table>
			<tr><td>* ISBN: </td><td colspan="3"><input type="text" name="ISBN" size="20" maxlength="20"/></td></tr>
			<tr><td>* Book Title: </td><td colspan="3"><input type="text" name="TITLE" size="40" maxlength="100"/></td></tr>
			<tr><td>* Series Name: </td><td><select name="SERIES">'.$dropoptions4.'</select></td>
			<td>No. in Series: </td><td><input type="text" name="NSERIES" size="4" maxlength="2" /></td></tr>
			<tr><td>* Author: </td><td colspan="3"><select name="AUTHOR">'.$dropoptions2.'</select></td></tr>
			<tr><td>* Book Type: </td><td><select name="TYPE">'.$dropoptions3.'</select></td>
			<td>* No. Pages: </td><td><input type="text" name="PAGES"  size="4" maxlength="4"/></td></tr>
			<tr><td>* Status: </td><td><select name="STATUS">'.$dropoptions.'</select></td>
			<td>* Times Read: </td><td><input type="text" name="READ"  size="4" maxlength="2"/></td></tr>
			<tr><td>Image name:</td><td colspan="3"><input type="text" name="IMAGE"  size="20" maxlength="100" /></td></tr>
			<tr><td>Comments:</td><td><textarea name="COMMENTS" rows="10" cols="30"></textarea></td></tr>
			<tr><td colspan="2"><input type="submit" name="ADDBOOK" value="Add Book" text="Add Book" /></td></tr>
			</table>
			</form></p>';
	}

include ('footer.htm');
?>