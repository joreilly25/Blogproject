<html>
<head>
    <link rel="stylesheet" href="blogcss.css" type="text/css"/>
    <title>The Blog Page!</title>
</head>
<body>
<?php
//Created by Justin

error_reporting(E_ALL);
ini_set('display_errors', 1);

$server = mysql_connect('localhost', 'jogfx_xithryl', 'alex') or die('Could not connect because: ' . mysql_error());
echo "Connected to MySQL! <br />";
$database = mysql_select_db('jogfx_blog', $server);

function DisplayPost($row)
{
    echo "<h2>Title: <a href=\"?postid=$row[postID]\" class=\"blogtitle\">$row[post_title]</a>";
    echo "<h3 class=\"catclass\">Category: <a href=\"?category=$row[post_category]\">$row[post_category]</a>";
    echo "<p>Post: $row[post_body]</p>";
    echo "<p>Time: $row[post_time]<p><br />";
}

function DisplayComment($row)
{
    //echo "<h2>Title: " . "<a href= ?postid=" . $row['postID'] . ">" . $row['post_title']."</a>";
    //echo "<h3>Category: " . "<a href= ?category=" . $row['post_category'] . ">" . $row['post_category']."</a>";
    echo "<p>Comment: $row[comment_body]</p>";
    echo "<p>Time: $row[comment_time]</p><br />";
}
if (isset($_REQUEST['postid'])) {
    $querypostsid = mysql_query("SELECT * FROM blogposts WHERE postid = '" . mysql_real_escape_string($_REQUEST['postid']) . "'");
    while ($row = mysql_fetch_assoc($querypostsid)) {
        DisplayPost($row);
    }
    if (isset($_REQUEST['comment_body'])) {
        $comment_body = mysql_real_escape_string($_POST['comment_body']);
        $comment_id = mysql_real_escape_string($_REQUEST['postid']);
        $newcomment_insert = mysql_query("INSERT INTO blogcomments (comment_time, comment_body, blogpostid)
                      VALUES (now(), '" . mysql_real_escape_string($comment_body) . "', '" . mysql_real_escape_string($comment_id) . "')");

        if ($newcomment_insert === FALSE) {
            echo mysql_error();
        }
    }
    $querycomments = mysql_query("SELECT * FROM blogcomments WHERE blogpostid = '" . mysql_real_escape_string($_REQUEST['postid']) . "'");
    while ($row = mysql_fetch_assoc($querycomments)) {
        DisplayComment($row);
    }
    echo "<form name=\"commentform\" id=\"postcomment\" action=\"mysql.php\" method=\"post\">
    Your Comment: <br />
    <textarea name=\"comment_body\" style=\"width: 380px; height: 90px\"></textarea>
    <input type=\"hidden\" name=\"postid\" value=\"$_REQUEST[postid]\"/>
    <input type=\"submit\" value=\"Add Comment\"/>
</form>";


}
elseif (isset($_REQUEST['category'])) {
    $querypostscat = mysql_query("SELECT * FROM blogposts WHERE post_category = '" . mysql_real_escape_string($_REQUEST['category']) . "'");

    while ($row = mysql_fetch_assoc($querypostscat)) {
        DisplayPost($row);
    }
}
else {
    $queryposts = mysql_query("SELECT * FROM blogposts");
    while ($row = mysql_fetch_assoc($queryposts)) {
        DisplayPost($row);
    }
}
echo "<a href=\"/blog/mysql.php\">Click to go the fuck home</a>";
?>
</body>
</html>