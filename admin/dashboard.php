<?php

session_start();
ob_start();
if (isset($_SESSION['username'])) {
    include('init.php');
    include('nav.php');

?>
    <div class="container">
        <h1 class="mt-4 mb-4 fw-bold text-center">Dashboard</h1>
        <div class="row g-2 text-center justify-content-between dashboard">
            <div class="col-sm-10 col-md-5 box col-lg-2 box">
                <p class="mb-0">total members</p>
                <h4 class="mt-2"><?php echo checkrow('', '', 'users') ?></h4>
            </div>

            <div class="col-sm-10 col-md-5 box col-lg-2 box">
                <p class="mb-0">pending users</p>
                <h4 class="mt-2"><?php  ?></h4>
            </div>

            <div class="col-sm-10 col-md-5 box col-lg-2 box">
                <p class="mb-0">total items</p>
                <h4 class="mt-2"><?php echo checkrow('', '', 'items') ?></h4>
            </div>

            <div class="col-sm-10 col-md-5 box col-lg-2 box">
                <p class="mb-0">total comments</p>
                <h4 class="mt-2"><?php echo checkrow('', '', 'comments') ?></h4>
            </div>

        </div>



        <div class="row mt-5 justify-content-between">

            <div class="card col-sm-10 col-lg-5 user_dashboard mb-5">
                <div class="card-header header d-flex justify-content-between">
                    <h4>latest registerd users</h4>
                    <span class="toogle-info"><i class="fa fa-plus fa-lg fw-bold "></i></span>
                </div>
                <div class="card-body ">
                    <?php
                    $sql = "select * from users limit 6";
                    try {
                        $res = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                                <span>
                                    <h6><?php echo $row['username']; ?></h6>
                                </span>
                                <a href="members.php?do=edit&id=<?php echo $row['user_id']; ?>" class="btn btn-primary"><i class="fa fa-edit fa-sm"></i>edit</a>
                            </div>
                    <?php
                        }
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </div>
            </div>

            <div class="card col-sm-10 col-lg-5 user_dashboard mb-5">
                <div class="card-header header d-flex justify-content-between">
                    <h4>latest 6 registerd items</h4>
                    <span class="toogle-info"><i class="fa fa-plus fa-lg fw-bold "></i></span>
                </div>
                <div class="card-body ">
                    <?php
                    $sql = "select * from items limit 4";
                    try {
                        $res = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                                <span>
                                    <h6><?php echo $row['name']; ?></h6>
                                </span>
                                <a href="items.php?do=edit&id=<?php echo $row['item_id']; ?>" class="btn btn-primary"><i class="fa fa-edit fa-sm"></i>edit</a>
                            </div>
                    <?php
                        }
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </div>
            </div>

            <div class="card col-sm-10 col-lg-5 user_dashboard mb-5">
                <div class="card-header header d-flex justify-content-between">
                    <h4>latest 4 comments </h4>
                    <span class="toogle-info"><i class="fa fa-plus fa-lg fw-bold "></i></span>
                </div>
                <div class="card-body ">
                    <?php
                    $sql = "select comments.* , users.username from comments join users on comments.user_id=users.user_id limit 4";
                    try {
                        $res = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                                <span class="text-primary fw-bold"><?=$row['username']?></span>
                                <span><?=$row['comment']?></span>
                            </div>
                    <?php
                        }
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </div>
            </div>

        </div>



    </div>

<?php



    ob_end_flush();
    include $tmp . "/footer.php";
} else {
    $msg = '<div class="alert alert-warning">you should not be here</div>';
    redirect($msg, 3, '');
}
//  include ("includes/templates/footer.php");