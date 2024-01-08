<?php
$page_title = 'Books - View';
$heading = "View";
include ('header.htm');

	if ($errorcode != 1) {
		if (isset($_GET['s'])) {
			$order_by = '';
			if (isset($_REQUEST['order'])) {
				if ($_REQUEST['order'] == 'Title') {
					$order_by .= 'BookTitle';
				}
				if ($_REQUEST['order'] == 'Series') {
					$order_by .= 'SeriesName, NoInSeries';
				}
				if ($_REQUEST['order'] == 'Author') {
					$order_by .= 'AuthorSN, AuthorFN, AuthorMN';
				}
				if ($_REQUEST['order'] == 'Status') {
					$order_by .= 'BookStatus';
				}
			}
			else {
				$order_by .= 'SeriesName, NoInSeries, BookTitle';
			}
			
			$value = $_GET['s'];
			if ($value == 'toorder') {
				$q = "SELECT BookTable.ISBN, BookTitle, SeriesName, NoInSeries, AuthorFN, AuthorMN, AuthorSN, BookStatus FROM BookTable, CurrentBookStatusTable, BookDataTable, BookStatusTable, AuthorTable, BookSeriesTable WHERE (NoTimesRead = '0' && BookStatus = 'To Order' &&  BookTable.ISBN = CurrentBookStatusTable.ISBN && BookTable.ISBN = BookDataTable.ISBN && BookDataTable.AuthorID = AuthorTable.AuthorID && StatusID = BStatID && BSerID = SeriesID) ORDER BY $order_by";
			}
			else if ($value == 'unreadowned') {
				$q = "SELECT BookTable.ISBN, BookTitle, SeriesName, NoInSeries, AuthorFN, AuthorMN, AuthorSN, BookStatus FROM BookTable, CurrentBookStatusTable, BookDataTable, BookStatusTable, AuthorTable, BookSeriesTable WHERE (NoTimesRead = '0' && BookStatus = 'Owned' && BookTable.ISBN = CurrentBookStatusTable.ISBN && BookTable.ISBN = BookDataTable.ISBN && BookDataTable.AuthorID = AuthorTable.AuthorID && StatusID = BStatID && BSerID = SeriesID) ORDER BY $order_by";
			}
			else {
				if ($value != '') {
					$q = "SELECT BookTable.ISBN, BookTitle, SeriesName, NoInSeries, AuthorFN, AuthorMN, AuthorSN, BookStatus FROM BookTable, CurrentBookStatusTable, BookDataTable, BookStatusTable, AuthorTable, BookSeriesTable WHERE ((SeriesName LIKE '%$value%' || BookTitle LIKE '%$value%' || BookTable.ISBN LIKE '%$value%' || AuthorFN LIKE '%$value%' || AuthorMN LIKE '%$value%' || AuthorSN LIKE '%$value%' || BookStatus LIKE '%$value%') && BookTable.ISBN = CurrentBookStatusTable.ISBN && BookTable.ISBN = BookDataTable.ISBN && BookDataTable.AuthorID = AuthorTable.AuthorID && StatusID = BStatID && BSerID = SeriesID) ORDER BY $order_by";
				}
			}
			
			$r = mysql_query($q, $link);
			if (mysql_num_rows($r) > 0){
				$resultnum = mysql_num_rows($r);
				echo "<p>Below are your search results for '$value', there are $resultnum result/s.</p>";
				echo '<p><form>Order By:<br/>
				<input type="radio" name="order" value="Title"> Book Title<t />
				<input type="radio" name="order" value="Series"> Series Name<t />
				<input type="radio" name="order" value="Author"> Author<t />
				<input type="radio" name="order" value="Status"> Status<t />
				<input type="hidden" name="s" value="'.$value.'" />
				<input type="submit" name="x" value="Change Ordering">
				</form></p>';
			
				echo '<p><table border = 1 align = "center">';
				echo '<tr class="yellow">
				<td>Book Title</td>
				<td>Series Name</td>
				<td>No. in Series</td>
				<td>Author</td>
				<td>Status</td>
				</tr>';
				OutputResults($r);			
				echo '</table></p>';
			}
			else {
				echo "<p>Sorry, there we found no results for '$value'.</p>";
			}
		}
		else {
			echo '<p>You must first enter a search criteria.</p>';
		}
			
		
	}
	else {
		echo '<p>Sorry, this page has been accessed in error.</p>';
	}
include ('footer.htm');

function OutputResults($r) {
	while ($val = mysql_fetch_array($r, MYSQL_ASSOC)) {
		$isbn = $val['ISBN'];
		$BookTitle = $val['BookTitle'];
		$SeriesName = $val['SeriesName'];
		$NSeries = $val['NoInSeries'];
		$AFN = $val['AuthorFN'];
		$AMN = $val['AuthorMN'];
		$ASN = $val['AuthorSN'];
		$Status = $val['BookStatus'];
		
		if ($NSeries == 0) {
			$NSeries = "";
		}
		
		echo "<tr>
			<td><a href=\"view_book.php?pid={$isbn}\">$BookTitle</td>
			<td>$SeriesName</td>
			<td>$NSeries</td>
			<td>$ASN, $AFN $AMN</td>
			<td>$Status</td></tr>";
	}
}

?>			
