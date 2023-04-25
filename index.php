<?php
require_once "pdo.php";
require_once "util.php";

session_start();

?>
<!DOCTYPE html>
<html>
<head>
<title>My Resume Registry</title>
<!-- bootstrap.php - this is HTML -->
<?php require_once "head.php"; ?>

</head>
<body>
<div class="container">
<h1>My Resume Registry</h1>
<?php

flashMessages();

if (isset($_SESSION['user_id'])) {
    echo('<p><a href="logout.php">Logout</a></p>');
}
echo('<table border="1">'."\n");
$stmt = $pdo->query("SELECT first_name, last_name, headline, profile_id FROM Profile");
    echo "<tr><td>";
    echo "<b>Name</b>";
    echo("</td><td>");
    echo("<b>Headline</b>");
    echo("</td><td>");
    echo("<b>Action</b>");
    echo("</td></tr>\n");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    echo('<a href="view.php?profile_id='.$row['profile_id'].'">'.htmlentities($row['first_name']).' '.htmlentities($row['last_name']).'</a>');
    echo("</td><td>");
    echo(htmlentities($row['headline']));
    echo("</td><td>");
    echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
    echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
    echo("</td></tr>\n");
}
?>
</table>
<?php
if (isset($_SESSION['user_id'])) { ?>
    <p><a href="add.php">Add New Entry</a></p>
<?php } else { ?>
    <p><a href="login.php">Please log in</a></p>
<?php } ?>
<p>
<b>Note:</b> Your implementation should retain data across multiple
logout/login sessions.  This sample implementation clears all its
data periodically - which you should not do in your implementation.
</p>
</div>
</body>