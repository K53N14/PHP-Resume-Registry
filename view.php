<?php
require_once "pdo.php";
require_once "util.php";
session_start();

if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT first_name, last_name, email, headline, summary, profile_id FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}

$positions = loadPos($pdo, $_REQUEST['profile_id']);
$schools = loadEdu($pdo, $_REQUEST['profile_id']);
?>
<!DOCTYPE html>
<html>
<head>
<title>My Profile View</title>
<?php require_once "head.php"; ?>

</head>
<body>
<div class="container">
<h1>Profile information</h1>
<p>First Name:
<?= htmlentities($row['first_name']) ?></p>
<p>Last Name:
<?= htmlentities($row['last_name']) ?></p>
<p>Email:
<?= htmlentities($row['email']) ?></p>
<p>Headline:<br/>
<?= htmlentities($row['headline']) ?></p>
<p>Summary:<br/>
<?= htmlentities($row['summary']) ?></p>
<p>Position</p><ul>
<?php
  foreach( $positions as $position) {
      echo('<li>'.htmlentities($position["year"]).': '.htmlentities($position["description"]).'</li>'."\n");
}
?>
</ul>
<p>Education</p><ul>
<?php
  foreach( $schools as $school) {
      echo('<li>'.htmlentities($school["year"]).': '.htmlentities($school["name"]).'</li>'."\n");
}
?>
</ul>
<p>
<a href="index.php">Done</a>
</p>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>