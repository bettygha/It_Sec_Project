<?php

require "../private/autoload.php";
$Error ="";


if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION['token']) && isset($_POST['token']) && $_SESSION['token'] == $_POST['token']){
    
    $email = $_POST['email'];
    //$password = escape($_POST['password']);
    $password =$_POST['password'];


     if($Error == ""){
     //$arr['user_id'] = $user_id;
     //$arr['username'] = $username;
     $arr['email'] = $email;
     $arr['password'] = $password;
     //$arr['date'] = $date;

    //$query = "insert into users (user_id,username,password,email,date) values ('$user_id','$username','$password','$email','$date')";
    //$query = "insert into users (user_id,username,password,email,date) values (:user_id,:username,:password,:email,:date)";
    $query = "select * from users where email = :email && password= :password limit 1";
    //echo $query;
    $stm = $connection-> prepare($query);
    $check= $stm-> execute($arr);

    if($check){
        $data = $stm->fetchAll(PDO::FETCH_OBJ);
        if(is_array($data) && count($data)>0){
            $data = $data[0];
            $_SESSION['user_id'] = $data->user_id;
            $_SESSION['username'] = $data->username;
            header("Location: index.php");
            die;
        }
   

    }

     }
     $Error = "Oops , Wrong email or password !";
     echo $Error;

     // mysqli_query($connection, $query);
     

}

$_SESSION['token']=get_random_string(60);
//echo $_SESSION['username'];

?>

<html>
    <head>
        <title>
            Login 
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
            <div id = "title" >Login </div>
            <input  id = "textbox" type="email" name="email" required>
            <input id = "textbox" type="password" name="password" required>
            <input type="hidden" name="token" value="<?=$_SESSION['token']?>">
            <input type="submit"  value="Login">
        </form>
    </body>
</html>