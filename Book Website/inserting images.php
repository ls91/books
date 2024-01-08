<?php
include ('header.htm');
$q = "SELECT ISBN FROM BookDataTable";
		$r = mysql_query($q, $link);
		
		while ($val = mysql_fetch_array($r, MYSQL_ASSOC)) {
			$isbn = $val['ISBN'];
			$q = "UPDATE BookDataTable SET ImageURL = '$isbn.jpg' WHERE ISBN = '$isbn'";
			$r2 = mysql_query($q, $link);
			if (mysql_affected_rows() == 1){
				echo 'successful<br/>';
			}
		}
		
?>
