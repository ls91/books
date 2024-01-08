<?php
$page_title = 'Books - Remove a Book';
$heading = "Remove a Book";
include ('header.htm');

	if ($errorcode != 1) {		
		echo '<p><form name="add" action="remove.php" method="POST">
			ISBN: <input type="text" name="ISBN" /></t>
			<input type="submit" name="REMOVE" value="Get Details" /></form>';
		
		if (isset($_REQUEST['REMOVE'])){
			$isbn = $_REQUEST['ISBN'];
						
			$q = "SELECT BookTable.ISBN, ImageURL, BookTitle, BookDataTable.AuthorID, AuthorFN, AuthorMN, AuthorSN, SeriesID, SeriesName, NoInSeries, Pages, BookTypeID, BookType, Comments, StatusID, BookStatus, NoTimesRead FROM BookTable, BookDataTable, CurrentBookStatusTable, AuthorTable, BookTypeTable, BookSeriesTable, BookStatusTable WHERE (BookTable.ISBN = '$isbn' && BookTable.ISBN = BookDataTable.ISBN && BookTable.ISBN = CurrentBookStatusTable.ISBN && BookDataTable.AuthorID = AuthorTable.AuthorID && SeriesID = BSerID && BookTypeID = BTID && BStatID = StatusID)";
			$r = mysql_query($q, $link);
			if (mysql_num_rows($r) == 1) {
				while ($val = mysql_fetch_array($r, MYSQL_ASSOC)) {
					$BookTitle = $val['BookTitle'];
					$AuthorID = $val['AuthorID'];
					$AuthorFN = $val['AuthorFN'];
					$AuthorMN = $val['AuthorMN'];
					$AuthorSN = $val['AuthorSN'];
					$SeriesID = $val['SeriesID'];
					$SeriesName = $val['SeriesName'];
					$NoInSeries = $val['NoInSeries'];
					$Pages = $val['Pages'];
					$BookTypeID = $val['BookTypeID'];
					$BookType = $val['BookType'];
					$Comments = $val['Comments'];
					$StatusID = $val['StatusID'];
					$BookStatus = $val['BookStatus'];
					$NoTimesRead = $val['NoTimesRead'];
					$Image = $val['ImageURL'];
				}
				
				//GENERATING THE DROP DOWN MENUS
				$q = 'SELECT BStatID, BookStatus FROM BookStatusTable';
				$r = mysql_query($q, $link);
				$dropoptions = '';
				while ($option = mysql_fetch_array($r, MYSQL_ASSOC)){
					$dropoptions .= '<option value="'.$option['BStatID'];
					if ($StatusID == $option['BStatID']) {
						$dropoptions .= '" selected="selected">'.$option['BookStatus'];
					}
					else {
						$dropoptions .= '">'.$option['BookStatus'];
					}
					$dropoptions .= '</option>';
				}
				$q = 'SELECT AuthorID, AuthorFN, AuthorMN, AuthorSN FROM AuthorTable';
				$r = mysql_query($q, $link);
				$dropoptions2 = '';
				while ($option = mysql_fetch_array($r, MYSQL_ASSOC)){
					$text = '';
					$text .= $option['AuthorSN'].', '.$option['AuthorFN'].' '.$option['AuthorMN'];
					$dropoptions2 .= '<option value="'.$option['AuthorID'];
					if ($AuthorID == $option['AuthorID']) {
						$dropoptions2 .= '" selected="selected">'.$text;
					}
					else {
						$dropoptions2 .= '">'.$text;
					}
					$dropoptions2 .= '</option>';
				}
				$q = 'SELECT BTID, BookType FROM BookTypeTable';
				$r = mysql_query($q, $link);
				$dropoptions3 = '';
				while ($option = mysql_fetch_array($r, MYSQL_ASSOC)){
					$dropoptions3 .= '<option value="'.$option['BTID'];
					if ($BookTypeID == $option['BTID']) {
						$dropoptions3 .= '" selected="selected">'.$option['BookType'];
					}
					else {
						$dropoptions3 .= '">'.$option['BookType'];
					}
					$dropoptions3 .= '</option>';
				}
				$q = 'SELECT BSerID, SeriesName FROM BookSeriesTable';
				$r = mysql_query($q, $link);
				$dropoptions4 = '';
				while ($option = mysql_fetch_array($r, MYSQL_ASSOC)){
					$dropoptions4 .= '<option value="'.$option['BSerID'];
					if ($SeriesID == $option['BSerID']) {
						$dropoptions4 .= '" selected="selected">'.$option['SeriesName'];
					}
					else {
						$dropoptions4 .= '">'.$option['SeriesName'];
					}
					$dropoptions4 .= '</option>';
				}
				
				
				echo '<p>The book with ISBN: '.$isbn.' was found, below are the details held on this book.</p>';
				echo '<p><form name="sendupdate" action="removed.php" method="POST">
			<table>
			<tr><td>* ISBN: </td><td colspan="3"><input type="text" name="ISBN" size="20" maxlength="20" value="'.$isbn.'" readonly /></td></tr>
			<tr><td>* Book Title: </td><td colspan="3"><input type="text" name="TITLE" size="40" maxlength="100" value="'.$BookTitle.'"/></td></tr>
			<tr><td>* Series Name: </td><td><select name="SERIES">'.$dropoptions4.'</select></td>
			<td>No. in Series: </td><td><input type="text" name="NSERIES" size="4" maxlength="2" value="'.$NoInSeries.'"/></td></tr>
			<tr><td>* Author: </td><td colspan="3"><select name="AUTHOR">'.$dropoptions2.'</select></td></tr>
			<tr><td>* Book Type: </td><td><select name="TYPE">'.$dropoptions3.'</select></td>
			<td>* No. Pages: </td><td><input type="text" name="PAGES"  size="4" maxlength="4" value="'.$Pages.'"/></td></tr>
			<tr><td>* Status: </td><td><select name="STATUS">'.$dropoptions.'</select></td>
			<td>* Times Read: </td><td><input type="text" name="READ"  size="4" maxlength="2" value="'.$NoTimesRead.'"/></td></tr>
			<tr><td>Image name:</td><td colspan="3"><input type="text" name="IMAGE"  size="20" maxlength="100" value="'.$Image.'"/></td></tr>
			<tr><td>Comments:</td><td><textarea name="COMMENTS" rows="10" cols="30">'.$Comments.'</textarea></td></tr>
			<tr><td colspan="2"><input type="submit" name="REMOVEBOOK" value="Remove Book" text="Add Book" /></td></tr>
			</table>
			</form></p>';
			}
			else {
				echo "<p>Sorry, The book with the ISBN: '$isbn' does not exist in this database.</p>";
			}
		}
	}

include ('footer.htm');
?>