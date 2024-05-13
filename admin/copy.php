<?php

session_start();

if (isset($_SESSION['username'])) {
    include("init.php");

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if($do=='manage'){

    }
    else if($do=='add'){

    }
    else if($do=='edit'){

    }
    else if($do=='activate'){

    }
    else if($do=='delete'){

    }


} else {
    include("init.php");
    $msg = '<div class="alert alert-warning " >yo not allowed in this page </div>';
    redirect($msg, 3, '');
    include $tmp . "/footer.php";
}