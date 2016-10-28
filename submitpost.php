<html>
<head>
    <title>SUBMIT POSTS</title>
</head>
<body>
<form action="submitpost.php" method="post">
    Category: <br/>
    <input name="post_category" style="width: 380px;" type="text"><br/>
    Title: <br/>
    <input name="post_title" style="width: 380px;" type="text"><br/>
    Body: <br/>
    <textarea name="post_body" style="width: 380px; height: 190px"></textarea>
    <input type="submit" value="SUBMIT FORM"/>
</form>

<?php
$con = mysql_connect("localhost", "jogfx_xithryl", "alex");
mysql_select_db("jogfx_blog", $con);

$postcategory = $_POST['post_cat'];
$postcategory = mysql_real_escape_string($_POST['post_category']);

$post_title = mysql_real_escape_string($_POST['post_title']);

$post_body = mysql_real_escape_string($_POST['post_body']);

if ($post_body == "" || $post_title == "" || $postcategory == "") {
    echo "<h1>" . "Don't forget to fill out all fields" . "</h1>";
}
else

    mysql_query("INSERT INTO blogposts (post_time, post_title, post_category, post_body)
VALUES (now(), '" . mysql_real_escape_string($post_title) . "', '" . mysql_real_escape_string($postcategory) . "' , '" . mysql_real_escape_string($post_body) . "')");

?>

</body>
</html>

'$post_title', '$postcategory', '$post_body')"