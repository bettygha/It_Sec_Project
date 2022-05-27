<?php

require "../private/autoload.php";
$user_data = check_login($connection);

$username ="";

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title> Home </title>

</head>
<body>
    <div id="header">
        <?php if($username != ""): ?>
    <div>Hi <?=htmlspecialchars($_SESSION['username'])?></div>
    <?php endif; ?>
     <li>
         <ul>
         <a href="suggestion.php">submit a submission</a>
         <a href="privious_suggestion.php">Review last submission</a>
         </ul>
     </li>
    <div style="center"> <a href="logout.php"> Logout </a> </div>
    Hello 
</body>
</html>
