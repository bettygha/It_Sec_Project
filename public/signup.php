<?php

require "../private/autoload.php";
$Error = "";
$email = "";
$username ="";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    // print_r($_POST);

    if ( !isset($_POST['email'], $_POST['username'], $_POST['password'])) {
        
        $Error= "oops , Please fill all the fields!";
    }
    // if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    //     $Error='Email is not valid!';
    // }

    // if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    //     exit('Username is not valid!');
    // }
   
    if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
        $Error='Password must be between 5 and 20 characters long!';
    }
    $date = date("Y-m-d H:i:s");
    $user_id = get_random_string(60);
   // $username =escape($_POST['username']) ;
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $activation_code =uniqid();

     //Check if email exist 
    $arr = false;
    $arr['email']= $email;
    $query = "select * from users where email = :email limit 1";
    $stm = $connection-> prepare($query);
    $check= $stm-> execute($arr);

    if($check){
        $data = $stm->fetchAll(PDO::FETCH_OBJ);
        if(is_array($data) && count($data) > 0){
            $Error ="Someone is already using that email"; // not sure if it is a valid error ???
            echo $Error;
        }
    }
    //placeholders 
     if($Error == ""){
     $arr['user_id'] = $user_id;
     $arr['username'] = $username;
     $arr['email'] = $email;
     $arr['password'] = $password;
     $arr['date'] = $date;
     $arr['activation_code'] = $activation_code;

    //$query = "insert into users (user_id,username,password,email,date) values ('$user_id','$username','$password','$email','$date')";
    $query = "insert into users (user_id,username,password,email,date,activation_code) values (:user_id,:username,:password,:email,:date,:activation_code)";
    $stm = $connection-> prepare($query);
    $stm-> execute($arr);

    /////////////////////////////////////////////////////// copied from https://codeshack.io/secure-registration-system-php-mysql/ website but it's not working
    $from    = 'noreply@yourdomain.com';
    $subject = 'Account Activation Required';
    $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
// Update the activation variable below
    $activate_link = 'http://yourdomain.com/phplogin/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
    $message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
     mail($_POST['email'], $subject, $message, $headers);
echo 'Please check your email to activate your account!';
/////////////////////////////////////////////////////////////////////////

    echo $query;
   // mysqli_query($connection, $query);
    header("Location:login.php");
    die;
     }

}

?>

<html>
    <head>
        <title>
            Sign Up
        </title>
    </head>
    <body style="font-family : verdana">
        <style type="text/css">
            form {
                margin:auto;
                border: solid thin #aaa;
                padding : 6px;
                max-width: 200px;
            }
            #title {
                background-color: purple;
                padding: 1em;
                text-align : center;
                color : white;
            }
            #textbox{
                border: solid thin #aaa;
                margin-top : 6px;
                width: 98%;
            }
        </style>
        <form method="post">
            <div>
                <?php
                if(isset($Error) && $Error !=""){
                    echo $Error;
                }
                ?>
            </div>
            <div id = "title" >Sign up </div>
            <input  id = "textbox" type="text" name="username"  value="<?=$username?>" required>
            <input  id = "textbox" type="email" name="email" value="<?=$email?>" required>
            <input id = "textbox" type="password" name="password" required>
            <input type="submit" value="Signup">
        </form>
    </body>
</html>