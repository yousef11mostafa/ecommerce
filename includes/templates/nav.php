<?php

?>

<div class=" bg-dark-subtle">
    <div class=" container header p-1 ">
        <?php
        if (isset($_SESSION['User'])) {
            $sql="select  user_id from users where username='$_SESSION[User]'";
            $res=mysqli_query($con,$sql);
            $row=mysqli_fetch_assoc($res);
            $_SESSION['user_id']=$row['user_id'];
        ?>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <button class="btn btn-dark-outline dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION['User']; ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="profile.php">my profile</a></li>
                        <li><a class="dropdown-item" href="items.php">add item</a></li>
                        <li><a class="dropdown-item" href="showitems.php">my items</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        <?php
        } else {
        ?>
            <div class="d-flex justify-content-end ">
                <a href="login.php">Login/ SignUp</a>
            </div>
        <?php
        }

        ?>
    </div>
</div>


<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <div class="container ">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">


            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <a class="nav-link active" aria-current="page" href="index.php">homepage</a>
            </ul>


            <ul class="navbar-nav ">
                <?php
                $sql = "select  * from categories limit 5";
                try {
                    $res = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_assoc($res)) {
                ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="categories.php?id=<?=$row['id']?>"><?=$row['name']?></a>
                        </li>
                <?php
                    }
                } catch (Exception $e) {
                    echo $e;
                    echo 'failed';
                }
                ?>
            </ul>





        </div>
    </div>
</nav>