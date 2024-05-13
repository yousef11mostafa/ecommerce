<?php
session_start();
include("init.php");

if (isset($_SESSION['User'])) {
?>

    <div class="container">
        <h1 class="text-center mt-3 mb-3">Create New Ad</h1>

        <div class="card information mb-4">
            <div class="card-header text-bg-primary">My Information</div>
            <div class="card-body fw-bold">
                <?php
                $username = $_SESSION['User'];
                $data = getAll("*", "users", "where username='$username'", "", "user_id", "");
                $userdata = mysqli_fetch_assoc($data);
                ?>
                <ul>
                    <li>
                        <span>login Name</span>
                        <span>:<?= $userdata['username'] ?></span>
                    </li>
                    <li>
                        <span>Email</span>
                        <span>:<?= $userdata['email'] ?></span>
                    </li>
                    <li>
                        <span>Full Name</span>
                        <span>:<?= $userdata['fullname'] ?></span>
                    </li>
                    <li>
                        <span>Fav Category</span>
                        <span>:<? ?></span>
                    </li>
                </ul>
                <?php

                ?>
            </div>
        </div>

        <div class="card profile-ads mb-4">
            <div class="card-header text-bg-primary">show Ads</div>
            <div class="card-body ">
                <?php
                $count = checkrow($userdata['user_id'], 'member_id', 'items');
                if ($count > 0) {
                    $ads = getAll("*", "items", "where member_id=$userdata[user_id]", "", "item_id", "");
                ?>
                    <div class="row g-1">
                        <?php
                        while ($row = mysqli_fetch_assoc($ads)) {
                        ?>
                            <div class="card col-md-6 col-lg-3 mb-3 mt-3">
                                <img src="https://cdn5.vectorstock.com/i/1000x1000/51/99/icon-of-user-avatar-for-web-site-or-mobile-app-vector-3125199.jpg" alt="" class="card-img-top">
                                <div class="card-body">
                                    <div class="card-title text-primary fw-bold"><?= $row['name'] ?></div>
                                    <div class="card-text"><?= $row['description'] ?></div>
                                    <span class='price'><?= '$' . $row['price'] ?></span>
                                </div>
                            </div>
                        <?php
                        }

                        ?>
                    </div>
                <?php
                } else {
                    echo 'there is no ads';
                }
                ?>
            </div>
        </div>

        <div class="card profile-comments mb-4">
            <div class="card-header text-bg-primary mt-3">Latest Comments</div>
            <div class="card-body">
                <?php
              $count = checkrow($userdata['user_id'], 'user_id', 'comments');
                if ($count > 0) {
                    $ads = getAll("*", "comments", "where user_id=$userdata[user_id]", "", "c_id", "");
                ?>
                    <div class="row g-1">
                        <?php
                        while ($row = mysqli_fetch_assoc($ads)) {
                        ?>
                            <P><?=$row['comment']?></p>
                        <?php
                        }

                        ?>
                    </div>
                <?php
                } else {
                    echo 'there is no comments';
                }
                ?>
            </div>
        </div>

    </div>
<?php
} else {
    header('location:login.php');
}

?>



<?php include $tmp . '/footer.php' ?>