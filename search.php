<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
    {
        header('Location: index.php?page=search');
        die();
    }
mysql_selector();

if (!isset($_POST['search']))
{
    echo <<< _END
<center>
<h2>Search</h2>
<form class="form" action="?page=search" method="post" autocomplete="off">
<span class="search">
	<input class="autosuggest" type="text" name="search" placeholder="Search"/>
    <ul class="result"></ul>    
</span>
<span class="search_for">
	<select name="select">
        <option value="all">All</option>
		<option value="filename">Filename</option>
		<option value="username">Username</option>
	</select>
</span>
<span class="submit">
	<input type="submit" value="Search" />
</span>
</form>
</center>
_END;
} 
elseif (isset($_POST['search']))
{
    $search_strip = stripcslashes($_POST['search']);
    echo '<center>
<h2>Search</h2>
<form class="form" action="?page=search" method="post" autocomplete="off">
<span class="search">
    <input class="autosuggest" type="text" name="search" placeholder="Search"/>
    <ul class="result"></ul>    
</span>
<span class="search_for">
    <select name="select">';
    if ($_POST['select'] == 'all') echo '<option value="all" selected=selected>All</option>';
    else echo '<option value="all">All</option>';
    if ($_POST['select'] == 'filename') echo '<option value="filename" selected=selected>Filename</option>';
    else echo '<option value="filename">Filename</option>';
    if ($_POST['select'] == 'username') echo '<option value="username" selected=selected>Username</option>';
    else echo'<option value="username">Username</option>';

    echo '  </select>
</span>
<span class="submit">
    <input type="submit" value="Search" />
</span>
</form>
</center>';
}



if ((isset($_POST['select'])))
{
    $search_for = mysql_enteries_fix_string($_POST['select']);
    $search = mysql_enteries_fix_string($_POST['search']);
    
    if ($search_for == "filename") $sql = "SELECT f.size AS size, f.rowID AS file_row, u.rowID AS user_row, f.file AS file, f.uploaded_date AS uploaded_date, u.username AS username FROM files f, users u WHERE f.file='$search' AND u.rowID=f.uploaded_by";

    elseif ($search_for == "username") $sql = "SELECT f.size AS size, f.rowID AS file_row, u.rowID AS user_row, f.file AS file, f.uploaded_date AS uploaded_date, u.username AS username FROM files f, users u WHERE u.username='$search' AND u.rowID=f.uploaded_by";

    elseif($search_for == 'all') $sql = "SELECT f.size AS size, f.rowID AS file_row, u.rowID AS user_row, f.file AS file, f.uploaded_date AS uploaded_date, u.username AS username FROM files f, users u WHERE u.username='$search' AND u.rowID=f.uploaded_by OR f.file='$search' AND u.rowID=f.uploaded_by";
   
    $result = mysql_query($sql, $con);

    if (mysql_num_rows($result) > 0)
    {
        echo "<center><table id='table'>"; //Start table
        echo '<th>Filename</th>
			<th>Uploaded by</th>
			<th>Upload date</th>
            <th>Filesize</th>
            <th>Comments</th>
            <th>Report abuse</th>';
        $count = 0;
        while ($row = mysql_fetch_array($result))
        {
            $fileRow  = $row['file_row'];
            $sql2     = "SELECT * FROM comments WHERE fileID='$fileRow'";
            $result2  = mysql_query($sql2,$con);
            $numrows2 = mysql_num_rows($result2);
            if($numrows2 == 1) $comment_string = 'comment';
            else $comment_string = 'comments';
             //File size calc
            if(oddOrEven($count)==1) echo "<tr class='alt'>";
            elseif(oddOreven($count)==0) echo '<tr>';
            echo '<td><a href=download.php?file=' . $row['file_row'] . '>' . $row['file'] . '</a></td>';
            echo '<td><a href=?page=profile&userID=' . $row["user_row"] . '>' . $row["username"] . '</a></td>';
            echo '<td>' . $row['uploaded_date'] . '</td>';  
            if($row['size'] >= 1024) echo '<td>'.($row["size"]/1024).'KB</td>';
            elseif($row['size'] >= 1048576) echo '<td>'.($row['size']/10485776).'MB</td>';
            else echo '<td>'.$row['size'].'bytes</td>';
            $string1   = 'onClick=areYouSure2('.$row['file_row'].');';
            echo "<td><a href='?page=comments&fileID=".$row['file_row']."'>$numrows2 $comment_string</a></td>
            <td><a onClick=$string1 href='#'".$row['file_row']."' title='Report abuse'><img src='img/abuse.png'></a></td>";
            echo "</tr>";
            ++$count;
        }
        
        echo $row['uploded_by'];
        echo "</table></center>";
    }
    else
        echo '<div id="error">Nothing matched your search</div>';
}
echo '<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/autosuggest.js"></script>';
?>