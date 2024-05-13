<?php

session_start();

if (isset($_SESSION['username'])) {
    include("init.php");

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') {       ////////////////////////////////////////////////   manage categories
        include('nav.php');
        $sort='ASC';
        $sort_arr=["ASC","DESC"];
        if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_arr)){
            $sort=$_GET['sort'];
        }
        $sql = "select * from categories order by ordering $sort";
        try {
            $res = mysqli_query($con, $sql);
            $count = mysqli_num_rows($res);
        } catch (Exception $e) {
            echo $e->getMessage();
        }


?>
        <div class="container">
            <h1 class="text-center fw-bold my-4">categories page</h1>
            <div class="card category_card">
                <div class="card-header d-flex justify-content-between">
                   <h5>categories</h5>
                   <div class="ordering">
                    ordering:
                    <a href="?sort=ASC" class="<?php if($sort=='ASC'){echo 'active';} ?>" >Asc</a>
                    |
                    <a href="?sort=DESC" class="<?php if($sort=='DESC'){echo 'active';}?>">Desc</a>
                   </div>
                </div>
                <?php
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                    <div class="card-body category_card_body">
                        <div class="category">
                            <h4 class="card-title"><?= $row['name'] ?></h4>
                            <p class="card-text"><?= $row['description'] ?></p>
                            <?php if ($row['visibility'] == 0) {
                                echo ' <span><a href="#" class="btn btn-danger">Hidden</a></span>';
                            } ?>
                            <?php if ($row['allow_comment'] == 0) {
                                echo ' <span><a href="#" class="btn btn-dark">Comment disabled</a></span>';
                            } ?>
                            <?php if ($row['allow_adds'] == 0) {
                                echo ' <span><a href="#" class="btn btn-warning">Ads disabled</a></span>';
                            } ?>
                            <div class="manuplation">
                                <span><a href="?do=edit&id=<?= $row['id'] ?>" class="btn btn-warning"><i class="fa fa-edit fa-sm"></i>edit</a></span>
                                <span><a href="?do=delete&id=<?= $row['id'] ?>" class="btn btn-danger"><i class="fa fa-remove fa-sm "></i>delete</a></span>
                            </div>
                        </div>
                    </div>
                    <hr class="line">
                <?php
                }

                ?>
            </div>
            <a href="?do=add" class="btn btn-primary mt-3 mb-3">add category</a>
        </div>

    <?php

    } else if ($do == 'add') {     ////////////////////////////////////////////////// add category

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $desc = $_POST['desc'];
            $order = $_POST['ordering'];
            $vis = $_POST['visibility'];
            $comment = $_POST['comment'];
            $adds = $_POST['adds'];

            $count = checkrow($name, 'name', 'categories');
            if ($count == 0) {
                $sql = "insert into categories (name,description,ordering,visibility,allow_comment,allow_adds) 
                                values('$name','$desc','$order','$vis','$comment','$adds')";

                try {
                    $res = mysqli_query($con, $sql);
                    if ($res) {
                        $msg= "<div class=\"alert alert-success alert-sm\">category has added successfully</div>";
                        redirect($msg,3,'');
                    }
                } catch (Exception $e) {
                    echo 'failed';
                }
            } else {
                echo "<div class=\"alert alert-warning alert-sm\">failed to add this category has aleardy found</div>";
            }
        }

    ?>
        <div class="container">

            <form action="?do=add" method='POST' class="membersform">
                <h1 class="text-center mt-3 fw-bold mb-5">add category</h1>
                <div class="row mb-3">
                    <label for="name" class="col-sm-1 col-form-label">name</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" <?php if (isset($name)) {
                                                                                                                echo $name;
                                                                                                            } ?>>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="area" class="col-sm-1 col-form-label">description</label>
                    <div class="col-sm-11">
                        <textarea class="form-control" name="desc" id="area" <?php if (isset($desc)) {
                                                                                    echo $desc;
                                                                                } ?>></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="ordering" class="col-sm-1 col-form-label">ordering</label>
                    <div class="col-sm-11">
                        <input type="number" min='1' max='100' class="form-control" id="ordering" name="ordering" <?php if (isset($order)) {
                                                                                                                        echo $order;
                                                                                                                    } ?> autocomplete="off">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">visibility</label>
                    <div class="col-sm-11">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="visibility" value='1' id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                visible
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="visibility" id="flexRadioDefault2" value='0' checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                hidden
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">allow<br>comment</label>
                    <div class="col-sm-11">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="comment" value='1' id="flexRadioDefault3">
                            <label class="form-check-label" for="flexRadioDefault3">
                                yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="comment" value='0' id="flexRadioDefault4" checked>
                            <label class="form-check-label" for="flexRadioDefault4">
                                no
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">allow ads</label>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="adds" value='1' id="flexRadioDefault5">
                            <label class="form-check-label" for="flexRadioDefault5">
                                yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="adds" value='0' id="flexRadioDefault6" checked>
                            <label class="form-check-label" for="flexRadioDefault6">
                                no
                            </label>
                        </div>
                    </div>
                </div>

                <input type="submit" value="add" class="btn btn-primary mt-3">
            </form>
        </div>

    <?php

    } else if ($do == 'edit') {       //////////////////////////////////////////// edit category



        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "select * from categories where id='$id' ";
            try {
                $res = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($res);
                $name = $row['name'];
                $desc = $row['description'];
                $order = $row['ordering'];
                $vis = $row['visibility'];
                $comment = $row['allow_comment'];
                $adds = $row['allow_adds'];
            } catch (exception $e) {
                echo $e->getMessage();
                echo "not found";
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['name'];
                $desc = $_POST['desc'];
                $order = $_POST['ordering'];
                $vis = $_POST['visibility'];
                $comment = $_POST['comment'];
                $adds = $_POST['adds'];
                // echo $name . ' '. $email . ' ' . $pass . ' ' . $fullname . ' status  ' . $status . ' group '  . $groupid . ' reg ' . $regstatus ;
                $sql = "update categories set name='$name',description='$desc',ordering='$order',visibility='$vis',allow_comment='$comment',allow_adds='$adds' where id='$id' ";
                try {
                    $res = mysqli_query($con, $sql);
                    $msg = '<div class="alert alert-success " >edited successfully</div>';
                    redirect($msg, 3, '');
                } catch (Exception $e) {
                    echo $e->getMessage();
                    echo 'failed';
                }
            }
        } else {
            $msg = 'you should not be here ';
            redirect($msg, 3, '');
        }


    ?>
        <div class="container">

            <form action="" method='POST' class="membersform">
                <h1 class="text-center mt-3 fw-bold mb-5">edit category</h1>
                <div class="row mb-3">
                    <label for="name" class="col-sm-1 col-form-label">name</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" value="<?php if (isset($name)) {
                                                                                                                    echo $name;
                                                                                                                } ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="area" class="col-sm-1 col-form-label">description</label>
                    <div class="col-sm-11">
                        <textarea class="form-control" name="desc" id="area"><?php if (isset($desc)) {
                                                                                    echo $desc;
                                                                                } ?></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="ordering" class="col-sm-1 col-form-label">ordering</label>
                    <div class="col-sm-11">
                        <input type="number" min='1' max='100' class="form-control" id="ordering" name="ordering" value="<?php if (isset($order)) {
                                                                                                                                echo $order;
                                                                                                                            } ?>" autocomplete="off">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">visibility</label>
                    <div class="col-sm-11">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="visibility" value='1' id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                visible
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="visibility" id="flexRadioDefault2" value='0' checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                hidden
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">allow<br>comment</label>
                    <div class="col-sm-11">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="comment" value='1' id="flexRadioDefault3">
                            <label class="form-check-label" for="flexRadioDefault3">
                                yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="comment" value='0' id="flexRadioDefault4" checked>
                            <label class="form-check-label" for="flexRadioDefault4">
                                no
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">allow ads</label>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="adds" value='1' id="flexRadioDefault5">
                            <label class="form-check-label" for="flexRadioDefault5">
                                yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="adds" value='0' id="flexRadioDefault6" checked>
                            <label class="form-check-label" for="flexRadioDefault6">
                                no
                            </label>
                        </div>
                    </div>
                </div>

                <input type="submit" value="edit" class="btn btn-primary mt-3">
            </form>
        </div>

    <?php

    } else if ($do == 'activate') {  //////////////////////////////////////////////////  activate page

    ?>

        <div class="container">
            <h1 class="text-center">activate visibility page</h1>
        </div>

        <?php

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "update categories set visibility='1' where id='$id'";
            try {
                $res = mysqli_query($con, $sql);
                $msg = '<div class="alert alert-warning " >category activated successfully</div>';
                redirect($msg, 3, 'categories.php');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    } else if ($do == 'delete') {   ///////////////// /////////////////////////////////// delete page

        ?>

        <div class="container">
            <h1 class="text-center">delete category page</h1>
        </div>

<?php

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "delete from categories where id='$id'";
            try {
                $res = mysqli_query($con, $sql);
                $msg = '<div class="alert alert-warning " >category deleted successfully</div>';
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
