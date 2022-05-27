<?php

require "../private/autoload.php";
$Error = "";
$email = "";
$username ="";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    // print_r($_POST);

    //placeholders 
    $user_id = get_random_string(60);
     if($Error == ""){
     $arr['user_id'] = $user_id;
     $arr['comments'] = $comments;
     

    //$query = "insert into users (user_id,username,password,email,date) values ('$user_id','$username','$password','$email','$date')";
    $query = "insert into poll (user_id,comments) values (:user_id,:comments)";
    $stm = $connection-> prepare($query);
    $stm-> execute($arr);

   // mysqli_query($connection, $query);
    header("Location:index.php");
    die;
     }

}

?>



<html>
    <head>
        <title>
            Comment
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
            <div id = "title" >Any Suggestion </div>
            <input  id = "textbox" type="text" name="comments"  value="<?=$comments?>" required>
            <input type="submit" value="comments">
        </form>
    </body>
</html>