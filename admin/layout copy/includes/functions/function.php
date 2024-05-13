<?php


function redirect ($msg , $seconds,$path){
     echo $msg;
     $back= $_SERVER['HTTP_REFERER'];
     if(!empty($path)){$back=$path;}
     echo "<div class=\"alert alert-warning \" >you will be redirected after $seconds seconds </div>";
     header("refresh:$seconds;url=$back");
}


function checkrow($name,$col,$table){
    global $con;
    $sql="select * from $table where $col='$name'";
    if(empty($name)){
        $sql="select * from $table";
    }
    try{
        $res=mysqli_query($con,$sql);
        $count=mysqli_num_rows($res);
        return $count;
    }
    catch(exception $e){
        echo $e->getMessage();
        return 1;
        echo 'faileddddddddddddd';
    }
}
function checkrows($name,$col,$table,$id){
    global $con;
    $sql="select * from $table where $col='$name' and item_id !='$id'";
    try{
        $res=mysqli_query($con,$sql);
        $count=mysqli_num_rows($res);
        return $count;
    }
    catch(exception $e){
        echo $e->getMessage();
        echo 'errorrrrrrrrrrr';
    }
}