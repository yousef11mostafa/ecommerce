<?php
session_start();
 include('init.php');

?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['User'])) {
        $name = $_POST['name'];
        $desc = $_POST['desc'];
        $price = $_POST['price'];
        $country = $_POST['country'];
        $status = $_POST['status'];
        $cat_id = $_POST['category'];
        $formerrors = [];
        if (empty($name)) {
            $formerrors[] = "the name is empty";
        }
        if (empty($desc)) {
            $formerrors[] = "the desc is empty";
        }
        if (empty($price)) {
            $formerrors[] = "the price is empty";
        }
        if (empty($country)) {
            $formerrors[] = "the country is empty";
        }

        if (empty($formerrors)) {
            $username = $_SESSION['User'];
            $sql = "select * from users where username='$username'";
            try {
                $ans = mysqli_query($con, $sql);
                $user = mysqli_fetch_assoc($ans);
                $userid = $user['user_id'];
                $_SESSION['user_id'] = $userid;
            } catch (Exception $e) {
                echo $e;
            }

            $count = checkrow($name, 'name', 'items');
            if ($count == 0) {
                $sql = "insert into items (name,description,price,country_made,status,approve,cat_id,member_id,add_date,rating,image) values
                ('$name','$desc','$price','$country','$status','0','$cat_id','$userid',now(),'0','0')";
                try {
                    $res = mysqli_query($con, $sql);
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                     item adedd successfuly
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                    
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                echo "<div class=\"alert alert-warning\">this items is aleardy found </div> ";
            }
        }
        

    } else {
        echo '<div class="alert alert-warning">you should register first</div>';
    }
}

?>

<!-- start html -->
  
        <div class="container">
            <h1 class="text-center mt-3 mb-3">Add New Ad</h1>
            <div class="card  mt-3">
                <div class="card-header text-bg-primary">create new ad</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- start form -->
                            <form action="" method='POST' class='add-item-form'>
                                <!-- start errors -->
                                <?php
                                if (!empty($formerrors)) {
                                    foreach ($formerrors as $error) {
                                        echo "<div class=\"alert alert-danger mb-2\">$error</div>";
                                    }
                                }
                                ?>
                                <!-- end errors -->

                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">name</label>
                                    <div class="col col-sm-10">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="item name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="desc" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col col-sm-10">
                                        <input type="text" name="desc" id="desc" class="form-control" placeholder="item description">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="price" class="col-sm-2 col-form-label">price</label>
                                    <div class="col col-sm-10">
                                        <input type="text" name="price" id="price" class="form-control" placeholder="item price">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="country" class="col-sm-2 col-form-label">country</label>
                                    <div class="col col-sm-10">
                                        <input type="text" name="country" id="country" class="form-control" placeholder="country of made">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="status" class="col-sm-2 col-form-label">status</label>
                                    <div class="col col-sm-10">
                                        <select name="status" class="form-control" id="status">
                                            <option value="2">new</option>
                                            <option value="1">good</option>
                                            <option value="0">old</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="category" class="col-sm-2 col-form-label">category_id</label>
                                    <div class="col col-sm-10">
                                        <select name="category" id="category" class="form-control">
                                            <?php
                                            $sql = "select * from categories";
                                            try {
                                                $res = mysqli_query($con, $sql);
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    echo "<option value=\"$row[id]\">$row[name]</option>";
                                                }
                                            } catch (Exception $e) {
                                                echo $e;
                                                echo 'failed one';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="submit" value="add" class="btn btn-primary mb-2 offset-2">
                            </form>
                            <!-- emd form -->
                        </div>
                        <div class="col-md-4">
                            <!-- start pic -->
                            <div class="card additem-card mt-3">
                                <img src="https://cdn5.vectorstock.com/i/1000x1000/51/99/icon-of-user-avatar-for-web-site-or-mobile-app-vector-3125199.jpg" alt="" class="card-img-top" style='max-height:300px;'>
                                <div class="card-body">
                                    <div class="card-title text-primary fw-bold">title</div>
                                    <div class="card-text">text</div>
                                    <span class='price'>price</span>
                                </div>
                            </div>
                            <!-- end pic -->
                        </div>
                    </div>
                </div>
            </div>
        </div>


<!-- end html -->



<?php include $tmp . '/footer.php'; ?>