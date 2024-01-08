<?php
$page_title = 'Books - Home';
$heading = "Books";
include ('header.htm');

	if ($errorcode != 1) {
		$q = "SELECT ISBN FROM BookTable";
		$r = mysql_query($q, $link);
		$BooksInDatabase = mysql_num_rows($r);
		$q = "SELECT ISBN FROM CurrentBookStatusTable, BookStatusTable WHERE BookStatus = 'Awaiting Delivery' && StatusID = BStatID";
		$r = mysql_query($q, $link);
		$BooksOnDelivery = mysql_num_rows($r);
		$q = "SELECT ISBN FROM CurrentBookStatusTable, BookStatusTable WHERE BookStatus = 'Pre-Ordered' && StatusID = BStatID";
		$r = mysql_query($q, $link);
		$BooksPreOrdered = mysql_num_rows($r);
		$q = "SELECT ISBN FROM CurrentBookStatusTable, BookStatusTable WHERE BookStatus = 'To Order' && StatusID = BStatID";
		$r = mysql_query($q, $link);
		$BooksToOrder = mysql_num_rows($r);
		$q = "SELECT ISBN FROM CurrentBookStatusTable WHERE NoTimesRead > 0";
		$r = mysql_query($q, $link);
		$BooksRead = mysql_num_rows($r);
		$q = "SELECT ISBN FROM CurrentBookStatusTable WHERE NoTimesRead = 0";
		$r = mysql_query($q, $link);
		$BooksUnread = mysql_num_rows($r);
		
		echo "<p>Below is a summary for your books.</p>
		<p>
			Number of books in database: $BooksInDatabase <br />
			Number of books awaiting delivery: $BooksOnDelivery <br />
			Number of books on pre-order: $BooksPreOrdered <br />
			Number of books to be ordered: $BooksToOrder <br />
			Number of books read from database: $BooksRead <br />
			Number of books to be read in database: $BooksUnread <br />
		</p>";
		echo "<p>Click <a href=\"results.php?s=toorder\">here</a> to view the books you still have to order.</br>";
		echo "Click <a href=\"results.php?s=unreadowned\">here</a> to view the books you still have to read that you currently own.</p>";
	}

include ('footer.htm');
?>
