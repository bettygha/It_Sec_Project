<?php 
ob_start(); 

require "../private/autoload.php";
require '../private/config.php';
$Error ="";


if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION['token']) && isset($_POST['token']) && $_SESSION['token'] == $_POST['token']){
    $view = $_POST['view'];
    $name = escape($_POST['name']);
    $comments = escape($_POST['comments']);
    $email = escape($_POST['email']);
    $num =escape($_POST['num']) ;

    $query = mysqli_query($con, "INSERT INTO `poll`(`id`, `name`, `email`, `phone`, `feedback`, `suggestions`) VALUES ('','$name','$email','$num','$view','$comments')");

}
$_SESSION['token']=get_random_string(60);

// echo '<script>alert("Thank You..! Your Feedback is Valuable to Us"); location.replace(document.referrer);</script>';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>
</head>
<body>
    <h1>Thank You</h1>
    <p>Here is the information you have submitted:</p>
    <ol>
        <li><em>Name:</em> <?php echo htmlspecialchars($_POST["name"])?></li>
        <li><em>Email:</em> <?php echo htmlspecialchars($_POST["email"])?></li>
        <li><em>nun:</em> <?php echo htmlspecialchars($_POST["num"])?></li>
        <li><em>comments:</em> <?php echo htmlspecialchars($_POST["comments"])?></li>
        <li><em>view:</em> <?php echo htmlspecialchars($_POST["view"])?></li>
        <ul type="hidden" name="token" value="<?=$_SESSION['token']?>"></ul>
    </ol>

    <div style="float:right"> <a href="logout.php"> Logout </a> </div>
</body>
</html>