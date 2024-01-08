<?php
$page_title = 'Books - Database Modification';
$heading = "Database Modification";
include ('header.htm');

	if ($errorcode != 1) {
		if (isset($_REQUEST['STATUS'])){
			$status = $_REQUEST['status'];
			$q = "INSERT IGNORE INTO BookStatusTable (BookStatus) VALUES ('$status')";
			$r = mysql_query($q, $link);
			if (mysql_affected_rows() == 1) {
				echo '<p>This status has been successfully added to the database.</p>';
			}
			else {
				echo '<p>Sorry, this status could not be added to the database.</p>';
			}
		}
		else if (isset($_REQUEST['AUTHOR'])){
			$afn = $_REQUEST['AFN'];
			$amn = $_REQUEST['AMN'];
			$asn = $_REQUEST['ASN'];
			$q = "INSERT IGNORE INTO AuthorTable (AuthorFN, AuthorMN, AuthorSN) VALUES ('$afn', '$amn', '$asn')";
			$r = mysql_query($q, $link);
			if (mysql_affected_rows() == 1) {
				echo '<p>This author has been successfully added to the database.</p>';
			}
			else {
				echo '<p>Sorry, this author could not be added to the database.</p>';
			}
		}
		else if (isset($_REQUEST['SERIES'])){
			$series = $_REQUEST['series'];
			$q = "INSERT IGNORE INTO BookSeriesTable (SeriesName) VALUES ('$series')";
			$r = mysql_query($q, $link);
			if (mysql_affected_rows() == 1) {
				echo '<p>This series has been successfully added to the database.</p>';
			}
			else {
				echo '<p>Sorry, this series could not be added to the database.</p>';
			}
		}
		else if (isset($_REQUEST['TYPE'])){
			$type = $_REQUEST['type'];
			$q = "INSERT IGNORE INTO BookTypeTable (BookType) VALUES ('$type')";
			$r = mysql_query($q, $link);
			if (mysql_affected_rows() == 1) {
				echo '<p>This book type has been successfully added to the database.</p>';
			}
			else {
				echo '<p>Sorry, this book type could not be added to the database.</p>';
			}
		}
		
		else if (isset($_REQUEST['RSTATUS'])){
			$status = $_REQUEST['status'];
			$q = "DELETE FROM BookStatusTable WHERE BookStatus = '$status'";
			$r = mysql_query($q, $link);
			if (mysql_affected_rows() == 1) {
				echo '<p>This status has been successfully removed from the database.</p>';
			}
			else {
				echo '<p>Sorry, this status could not be removed from the database.</p>';
			}
		}
		else if (isset($_REQUEST['RAUTHOR'])){
			$afn = $_REQUEST['AFN'];
			$amn = $_REQUEST['AMN'];
			$asn = $_REQUEST['ASN'];
			$q = "DELETE FROM AuthorTable WHERE AuthorFN = '$afn' && AuthorMN = '$amn' && AuthorSN = '$asn'";
			$r = mysql_query($q, $link);
			if (mysql_affected_rows() == 1) {
				echo '<p>This author has been successfully removed from the database.</p>';
			}
			else {
				echo '<p>Sorry, this author could not be removed from the database.</p>';
			}
		}
		else if (isset($_REQUEST['RSERIES'])){
			$series = $_REQUEST['series'];
			$q = "DELETE FROM BookSeriesTable WHERE SeriesName = '$series'";
			$r = mysql_query($q, $link);
			if (mysql_affected_rows() == 1) {
				echo '<p>This series has been successfully removed from the database.</p>';
			}
			else {
				echo '<p>Sorry, this series could not be removed from the database.</p>';
			}
		}
		else if (isset($_REQUEST['RTYPE'])){
			$type = $_REQUEST['type'];
			$q = "DELETE FROM BookTypeTable WHERE BookType = '$type'";
			$r = mysql_query($q, $link);
			if (mysql_affected_rows() == 1) {
				echo '<p>This book type has been successfully removed from the database.</p>';
			}
			else {
				echo '<p>Sorry, this book type could not be removed from the database.</p>';
			}
		}
		else if (isset($_REQUEST['BACKUP'])){
			$q = "SELECT BookTable.ISBN, BookTitle, AuthorFN, AuthorMN, AuthorSN, SeriesName, NoInSeries, BookType, Pages, BookStatus, NoTimesRead, Comments, ImageURL FROM BookTable, BookDataTable, CurrentBookStatusTable, BookStatusTable, BookTypeTable, BookSeriesTable, AuthorTable WHERE (BookTable.ISBN = BookDataTable.ISBN && BookTable.ISBN = CurrentBookStatusTable.ISBN && BookDataTable.AuthorID = AuthorTable.AuthorID && SeriesID = BSerID && BTID = BookTypeID && StatusID = BStatID) INTO OUTFILE '/tmp/backup.csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n'";
			$r = mysql_query($q, $link);
			if (mysql_affected_rows() > 0) {
				echo '<p>Backup was completed successfully.</p>';
			}
			else {
				echo '<p>Sorry, backup couldnt be completed successfully, ensure backup.csv does not already exist.</p>';
			}
		}
	
	
		echo '<h2>Add/Remove a book status:</h2>
			<p>
			<form>
			<table>
			<tr><td>Status: </td><td><input type="text" name="status"></td></tr>
			<tr><td colspan="2"><input type="submit" name="STATUS" value="Add Status"><input type="submit" name="RSTATUS" value="Remove Status"></td></tr>
			</table>
			</form>
			</p>';
		echo '<h2>Add/Remove an author:</h2>
			<p>
			<form>
			<table>
			<tr><td>Author&#39;s First Name: </td><td><input type="text" name="AFN"></td></tr>
			<tr><td>Author&#39;s Middle Name: </td><td><input type="text" name="AMN"></td></tr>
			<tr><td>Author&#39;s Surname: </td><td><input type="text" name="ASN"></td></tr>
			<tr><td colspan="2"><input type="submit" name="AUTHOR" value="Add Author"><input type="submit" name="RAUTHOR" value="Remove Author"></td></tr>
			</table>
			</form>
			</p>';
		echo '<h2>Add/Remove a book series:</h2>
			<p>
			<form>
			<table>
			<tr><td>Series Name: </td><td><input type="text" name="series"></td></tr>
			<tr><td colspan="2"><input type="submit" name="SERIES" value="Add Series"><input type="submit" name="RSERIES" value="Remove Series"></td></tr>
			</table>
			</form>
			</p>';
		echo '<h2>Add/Remove a book type:</h2>
			<p>
			<form>
			<table>
			<tr><td>Book Type: </td><td><input type="text" name="type"></td></tr>
			<tr><td colspan="2"><input type="submit" name="TYPE" value="Add Type"><input type="submit" name="RTYPE" value="Remove Type"></td></tr>
			</table>
			</form>
			</p>';
		echo '<h2>Backup Database</h2>
			<p>
			<form>
			<input type="submit" name="BACKUP" value="Backup DB">
			</form>
			</p>';
	}

include ('footer.htm');
?>
