<?php
$page_title = 'Books - Removed';
$heading = "Removed...";
include ('header.htm');

	if ($errorcode != 1) {
		//var_dump($_REQUEST);
		if (isset($_REQUEST['REMOVEBOOK'])){
			$isbn = $_REQUEST['ISBN'];
			
			$q = "DELETE FROM BookDataTable WHERE ISBN = '$isbn'";
			$r = mysql_query($q, $link);
			$q = "DELETE FROM CurrentBookStatusTable WHERE ISBN = '$isbn'";
			$r = mysql_query($q, $link);
			$q = "DELETE FROM BookTable WHERE ISBN = '$isbn'";
			$r = mysql_query($q, $link);
			
			echo "<p>The book with ISBN: $isbn has been successfully removed from the database.</p>";
		}		
	}

include ('footer.htm');
?>