<?php
$page_title = 'Books - Book';

include ('header.htm');

	if ($errorcode != 1) {
		if (isset($_GET['pid'])) {
			$isbn = $_GET['pid'];
			$q = "SELECT BookTable.ISBN, ImageURL, BookTitle, BookDataTable.AuthorID, AuthorFN, AuthorMN, AuthorSN, SeriesID, SeriesName, NoInSeries, Pages, BookTypeID, BookType, Comments, StatusID, BookStatus, NoTimesRead FROM BookTable, BookDataTable, CurrentBookStatusTable, AuthorTable, BookTypeTable, BookSeriesTable, BookStatusTable WHERE (BookTable.ISBN = '$isbn' && BookTable.ISBN = BookDataTable.ISBN && BookTable.ISBN = CurrentBookStatusTable.ISBN && BookDataTable.AuthorID = AuthorTable.AuthorID && SeriesID = BSerID && BookTypeID = BTID && BStatID = StatusID)";
			$r = mysql_query($q, $link);
			if (mysql_num_rows($r) == 1) {
				while ($val = mysql_fetch_array($r, MYSQL_ASSOC)) {
					$ISBN = $val['ISBN'];
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
					$image = $val['ImageURL'];
					
					if ($image == ''){
						$image = 'no_book.jpg';
					}
					if ($NoInSeries == 0) {
						$NoInSeries = "";
					}
				}
					echo '<h1 class="title">'.$BookTitle.'</h1>';
					echo "
						<p><table><tr>
						<td>
						<img src=\"images/$image\" alt=\"$BookTitle\" title=\"$BookTitle\">
						</td>						
						<td>
						ISBN: $ISBN<br />
						Book Title: $BookTitle<br />
						Author: $AuthorSN, $AuthorFN $AuthorMN<br />
						Series: $SeriesName<br />
						No. in Series: $NoInSeries<br />
						No. of pages: $Pages<br />
						Format: $BookType<br />
						Book Status: $BookStatus<br />
						Times Read: $NoTimesRead<br />
						Comments:<br />
						<img src=\"images/commentss.jpg\" />$Comments<img src=\"images/commentsf.jpg\" />
						</td>
						</tr></table></p>
					";
					echo '<p>
					<form method="POST" action="modify.php">
					<input type="hidden" name="ISBN" value="'.$ISBN.'" />
					<input type="submit" name="MODIFYBOOK" value="Modify Book Details" />
					</form>
					</p>';
					echo '<p>
					<form method="POST" action="remove.php">
					<input type="hidden" name="ISBN" value="'.$ISBN.'" />
					<input type="submit" name="REMOVE" value="Remove This Book" />
					</form>
					</p>';
				
				
					
			}
			else {
				echo '<p>Sorry, this book doesnt exist.</p>';
			}
		}
		else {
			echo '<p>This page has been access in error.</p>';
		}
	}

include ('footer.htm');
?>
