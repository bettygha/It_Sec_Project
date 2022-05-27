<?php
 
 function get_random_string($length = 60) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function escape($word){
    return addslashes($word);
}

function check_login($connection){
    if(isset( $_SESSION['user_id'])){

           $arr['user_id'] = $_SESSION['user_id']; 
           $query = "select * from users where user_id = :user_id limit 1";
           $stm = $connection-> prepare($query);
           $check= $stm-> execute($arr);
           if($check){
               $data = $stm->fetchAll(PDO::FETCH_OBJ);
               if(is_array($data) && count($data)>0){
                   return $data[0];
                  
               }
    }
}

    header("Location: login.php");
    die;
}

function check_token($token){
    if(isset($_SESSION['token']) && $token == $_SESSION['token']){
        unset($_SESSION['token']);
        return $token;
    }
}