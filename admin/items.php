<?php

session_start();

if (isset($_SESSION['username'])) {
    include("init.php");

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') {
        //
        include("nav.php");
        $sql = "select * from items ";
        try {
            $res = $con->query($sql);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

?>
        <div class="container">
            <h1 class="text-center mt-3 fw-bold mb-5">manage items</h1>
            <table class="table table-bordered">
                <tr class="tr table-dark text-center">
                    <td>#id</td>
                    <td>name</td>
                    <td>description</td>
                    <td>price</td>
                    <td>adding date</td>
                    <td>control</td>
                </tr>

                <?php

                while ($row = $res->fetch_assoc()) {
                    echo "<tr class='text-center'>";
                    echo "<td>$row[item_id]</td>";
                    echo "<td>$row[name]</td>";
                    echo "<td>$row[description]</td>";
                    echo "<td>$row[price]</td>";
                    echo "<td>$row[add_date]</td>";
                ?>
                    <td>
                        <span><a href="?do=edit&id=<?php echo $row['item_id'] ?>" class=" btn btn-warning"><i class="fa fa-edit fa-sm"></i>edit</a></span>
                        <span><a href="?do=delete&id=<?php echo $row['item_id'] ?>" class=" btn btn-danger"><i class="fa fa-remove fa-sm"></i>delete</a></span>
                        <?php
                            if($row['approve']=='0'){
                                ?>
                                <span><a href="?do=approve&id=<?php echo $row['item_id'] ?>" class=" btn btn-primary">+ approve</a></span>
                                <?php
                            }
                        ?>
                    </td>
                <?php

                    echo "</tr>";
                }

                ?>

            </table>

                <a href="?do=add" class="btn btn-primary"><i class="fa fa-user fa-sm"></i>add items</a>
        </div>
    <?php



        //
    } else if ($do == 'add') {       ////////////////////////////////////////////////////////////////   add item

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $desc = $_POST['desc'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $cat_id = $_POST['category'];
            $member_id = $_POST['member'];
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

                $count = checkrow($name, 'name', 'items');
                if ($count == 0) {
                    $sql = "insert into items (name,description,price,country_made,status,approve,cat_id,member_id,add_date,rating,image) values
                ('$name','$desc','$price','$country','$status','0','$cat_id','$member_id',now(),'0','0')";
                    try {
                        $res = mysqli_query($con, $sql);
                        $msg = "<div class=\"alert alert-success alert-sm\">category has added successfully</div>";
                        redirect($msg, 3, '');
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                } else {
                    echo "<div class=\"alert alert-warning\">this items is aleardy found </div> ";
                }
            }
        }

?>
        <div class="container">
            <form action="" method='POST'>
                <h1 class="text-center mt-3 fw-bold mb-5">add item</h1>
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
                    <label for="name" class="col-sm-1 col-form-label">name</label>
                    <div class="col col-sm-11">
                        <input type="text" name="name" id="name" class="form-control" placeholder="item name">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="desc" class="col-sm-1 col-form-label">Description</label>
                    <div class="col col-sm-11">
                        <input type="text" name="desc" id="desc" class="form-control" placeholder="item description">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="price" class="col-sm-1 col-form-label">price</label>
                    <div class="col col-sm-11">
                        <input type="text" name="price" id="price" class="form-control" placeholder="item price">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="country" class="col-sm-1 col-form-label">country</label>
                    <div class="col col-sm-11">
                        <input type="text" name="country" id="country" class="form-control" placeholder="country of made">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="status" class="col-sm-1 col-form-label">status</label>
                    <div class="col col-sm-11">
                        <select name="status" class="form-control" id="status">
                            <option value="2">new</option>
                            <option value="1">good</option>
                            <option value="0">old</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="category" class="col-sm-1 col-form-label">category_id</label>
                    <div class="col col-sm-11">
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
                <div class="row mb-3">
                    <label for="member" class="col-sm-1 col-form-label">member_id</label>
                    <div class="col col-sm-11">
                        <select name="member" id="member" class="form-control">
                            <?php
                            $sql = "select * from users";
                            try {
                                $res = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<option value=\"$row[user_id]\">$row[username]</option>";
                                }
                            } catch (Exception $e) {
                                echo $e;
                                echo 'failed one';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <input type="submit" value="add" class="btn btn-primary mb-3">
            </form>
        </div>
<?php
    } else if ($do == 'edit') {       ////////////////////////////////////////////////////  edit items;

        //
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "select * from items where item_id='$id' ";
            try {
                $res = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($res);

                $name = $row['name'];
                $desc = $row['description'];
                $price = $row['price'];
                $country = $row['country_made'];
                $status = $row['status'];
                $rating = $row['rating'];
                $cat_id = $row['cat_id'];
                $member_id = $row['member_id'];
            } catch (exception $e) {
                echo $e->getMessage();
                echo "not found";
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['name'];
                $desc = $_POST['desc'];
                $price = $_POST['price'];
                $country = $_POST['country'];
                $status = $_POST['status'];
                $cat_id = $_POST['category'];
                $member_id = $_POST['member'];
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
    
                    $count = checkrows($name, 'name', 'items',$id);
                    if ($count == 0) {
                        $sql = "update  items set name='$name' , description='$desc',price ='$price',status='$status',cat_id='$cat_id',member_id='$member_id',add_date=now() where item_id='$id'";
                        try {
                            $res = mysqli_query($con, $sql);
                            $msg = "<div class=\"alert alert-success alert-sm\">item has updated successfully</div>";
                            redirect($msg, 3, '');
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    } else {
                        echo "<div class=\"alert alert-warning\">this items is aleardy found </div> ";
                    }
                }
            }
           

        ?>


            
        <?php


        } else {
            echo 'not found id';
        }

        ?>

<div class="container">
            <form action="" method='POST'>
                <h1 class="text-center mt-3 fw-bold mb-5">edit item</h1>
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
                    <label for="name" class="col-sm-1 col-form-label">name</label>
                    <div class="col col-sm-11">
                        <input type="text" name="name" id="name" class="form-control" placeholder="item name" value="<?=$name;?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="desc" class="col-sm-1 col-form-label">Description</label>
                    <div class="col col-sm-11">
                        <input type="text" name="desc" id="desc" class="form-control" placeholder="item description"  value="<?=$desc;?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="price" class="col-sm-1 col-form-label">price</label>
                    <div class="col col-sm-11">
                        <input type="text" name="price" id="price" class="form-control" placeholder="item price"  value="<?=$price;?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="country" class="col-sm-1 col-form-label">country</label>
                    <div class="col col-sm-11">
                        <input type="text" name="country" id="country" class="form-control" placeholder="country of made"  value="<?=$country;?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="status" class="col-sm-1 col-form-label">status</label>
                    <div class="col col-sm-11">
                        <select name="status" class="form-control" id="status">
                            <option value="2">new</option>
                            <option value="1">good</option>
                            <option value="0">old</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="category" class="col-sm-1 col-form-label">category_id</label>
                    <div class="col col-sm-11">
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
                <div class="row mb-3">
                    <label for="member" class="col-sm-1 col-form-label">member_id</label>
                    <div class="col col-sm-11">
                        <select name="member" id="member" class="form-control">
                            <?php
                            $sql = "select * from users";
                            try {
                                $res = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<option value=\"$row[user_id]\">$row[username]</option>";
                                }
                            } catch (Exception $e) {
                                echo $e;
                                echo 'failed one';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <input type="submit" value="edit" class="btn btn-primary mb-3">
            </form>
        </div>


    <?php
        //

    } else if ($do == 'approve') {        //////////////////////////////////////////// approve page
        ?>

        <div class="container">
            <h1 class="text-center">activate item</h1>
        </div>

        <?php

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "update items set approve='1' where item_id='$id'";
            try {
                $res = mysqli_query($con, $sql);
                $msg = '<div class="alert alert-warning " >activated successfully</div>';
                redirect($msg, 3, '');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        

    } else if ($do == 'delete') {       ////////////////////////////////////////////////  delete items
        ?>

        <div class="container">
            <h1 class="text-center">delete page</h1>
        </div>

<?php

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "delete from items where item_id='$id'";
            try {
                $res = mysqli_query($con, $sql);
                $msg = '<div class="alert alert-warning " >item deleted successfully</div>';
                redirect($msg, 3, '');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    include $tmp . "/footer.php";
} else {
    include("init.php");
    $msg = '<div class="alert alert-warning " >yo not allowed in this page </div>';
    redirect($msg, 3, '');
    include $tmp . "/footer.php";
}
