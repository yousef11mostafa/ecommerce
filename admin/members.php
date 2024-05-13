<?php
session_start();
if (isset($_SESSION['username'])) {
    include("init.php");

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') {           //////////////////////////////////////////////////// ///////////  manage users
        //
        include("nav.php");
        $sql = "select * from users ";
        try {
            // $res=mysqli_connect($con,$sql);
            $res = $con->query($sql);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

?>
        <div class="container">
            <h1 class="text-center mt-3 fw-bold mb-5">manage users</h1>
            <table class="table table-bordered">
                <tr class="tr table-dark text-center">
                    <td>userid</td>
                    <td>username</td>
                    <td>email</td>
                    <td>regstatus</td>
                    <td>truststatus</td>
                    <td>modify</td>
                </tr>

                <?php

                while ($row = $res->fetch_assoc()) {
                    echo "<tr class='text-center'>";
                    echo "<td>$row[user_id]</td>";
                    echo "<td>$row[username]</td>";
                    echo "<td>$row[email]</td>";
                    echo "<td>$row[regstatus]</td>";
                    echo "<td>$row[truststatus]</td>";
                ?>
                    <td class=''>
                        <span><a href="?do=edit&id=<?php echo $row['user_id'] ?>" class=" btn btn-warning"><i class="fa fa-edit fa-sm"></i>edit</a></span>
                        <span><a href="?do=delete&id=<?php echo $row['user_id'] ?>" class=" btn btn-danger"><i class="fa fa-remove fa-sm"></i>delete</a></span>
                        <?php
                        if ($row['regstatus'] == 0) {
                        ?>
                            <span><a href="?do=activate&id=<?php echo $row['user_id'] ?>" class="btn btn-primary">+ approve</a></span>
                        <?php
                        }
                        ?>
                    </td>
                <?php

                    echo "</tr>";
                }

                ?>

            </table>

                <a href="?do=add" class="btn btn-primary"><i class="fa fa-user fa-sm"></i>add user</a>
        </div>
    <?php



        //
    } else if ($do == 'add') {             /////////////////////////////////////////////////////////// add user
        //

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email = $_POST['mail'];
            $pass = $_POST['pass'];
            $fullname = $_POST['fullname'];
            $status = $_POST['status'];
            $groupid = $_POST['groupid'];
            $regstatus = $_POST['regstatus'];

            $formerrors = array();
            if (empty($name)) {
                $formerrors[] = 'the name is empty';
            }
            if (empty($pass)) {
                $formerrors[] = 'the pass is empty';
            }
            if (empty($email)) {
                $formerrors[] = 'the email is empty';
            }
            if (empty($fullname)) {
                $formerrors[] = 'the fullname is empty';
            }

            $pass = sha1($pass);

            if (empty($formerrors)) {

                $count = checkrow($name,'username', 'users');
                if ($count < 1) {

                    $sql = "insert into users (username,email,password,fullname,truststatus,groupid,regstatus) values('$name','$email','$pass','$fullname','$status','$groupid','$regstatus');";
                    try {
                        $res = mysqli_query($con, $sql);
                        if ($res) {
                            $msg= "<div class=\"alert alert-success alert-sm\">user has added successfully</div>";
                            redirect($msg,3,'');
                        }
                    } catch (exception $e) {
                        echo $e->getMessage();
                        echo 'not found';
                    }
                } else {
                    echo "<div class=\"alert alert-warning alert-sm\">failed to add this username has aleardy found</div>";
                }
            }
        }

        //


    ?>

        <div class="container">
            <?php
            if (!empty($formerrors)) {
                foreach ($formerrors as $error) {
                    echo "<div class=\"alert alert-danger alert-sm\">$error</div>";
                }
            }
            ?>

            <form action="?do=add" method='POST' class="membersform">
                <h1 class="text-center mt-3 fw-bold mb-5">add user</h1>
                <div class="row mb-3">
                    <label for="name" class="col-sm-1 col-form-label">username</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="name" name="name" value="<?php if (isset($name)) {
                                                                                                    echo $name;
                                                                                                } ?>" autocomplete="off">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="pass" class="col-sm-1 col-form-label">password</label>
                    <div class="col-sm-11">
                        <input type="password" class="form-control" id="pass" name="pass" value="<?php if (isset($pass)) {
                                                                                                        echo $pass;
                                                                                                    } ?>" autocomplete="off">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-1 col-form-label">Email</label>
                    <div class="col-sm-11">
                        <input type="email" class="form-control" id="email" name="mail" value="<?php if (isset($email)) {
                                                                                                    echo $email;
                                                                                                } ?>" autocomplete="off">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="fullname" class="col-sm-1 col-form-label">fullname</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?php if (isset($fullname)) {
                                                                                                            echo $fullname;
                                                                                                        } ?>" autocomplete="off">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="truststatus" class="col-sm-1 col-form-label">truststatus</label>
                    <div class="col-sm-11">
                        <input type="number" min='1' max='10' class="form-control" id="truststatus" name="status" value="<?php if (isset($status)) {
                                                                                                                                echo $status;
                                                                                                                            } ?>" autocomplete="off">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">groupid</label>
                    <div class="col-sm-11">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="groupid" value='1' id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                admin
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="groupid" id="flexRadioDefault2" value='0' checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                user
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">regstatus</label>
                    <div class="col-sm-11">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="regstatus" value='1' id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="regstatus" value='0' id="flexRadioDefault2" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                no
                            </label>
                        </div>
                    </div>
                </div>

                <input type="submit" value="add" class="btn btn-primary mt-3">
            </form>
        </div>

        <?php




    } else if ($do == 'edit') {        ///////////////////////////////////////////////////////////////////   edit user

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "select * from users where user_id='$id' ";
            try {
                $res = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($res);
                $name = $row['username'];
                $email = $row['email'];
                $pass = $row['password'];
                $fullname = $row['fullname'];
                $status = $row['truststatus'];
                $groupid = $row['groupid'];
                $regstatus = $row['regstatus'];
            } catch (exception $e) {
                echo $e->getMessage();
                echo "not found";
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['name'];
                $email = $_POST['mail'];
                $pass = $_POST['pass'];
                $fullname = $_POST['fullname'];
                $status = $_POST['status'];
                $groupid = $_POST['groupid'];
                $regstatus = $_POST['regstatus'];
                // echo $name . ' '. $email . ' ' . $pass . ' ' . $fullname . ' status  ' . $status . ' group '  . $groupid . ' reg ' . $regstatus ;
                $sql = "update users set username='$name',email='$email',fullname='$fullname',truststatus='$status',groupid='$groupid',regstatus='$regstatus' where user_id='$id'";
                try {
                    $res = mysqli_query($con, $sql);
                    $msg = '<div class="alert alert-warning " >edited successfully</div>';
                    redirect($msg, 3, 'members.php');
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }

        ?>
            <div class="container">
                <form action="" method='POST' class="membersform">
                    <h1 class="text-center mt-3 fw-bold mb-5">edit user</h1>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-1 col-form-label">username</label>
                        <div class="col-sm-11">
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="pass" class="col-sm-1 col-form-label">password</label>
                        <div class="col-sm-11">
                            <input type="password" class="form-control" id="pass" name="pass" value="<?php echo $pass ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-1 col-form-label">Email</label>
                        <div class="col-sm-11">
                            <input type="email" class="form-control" id="email" name="mail" value="<?php echo $email ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="fullname" class="col-sm-1 col-form-label">fullname</label>
                        <div class="col-sm-11">
                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $fullname ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="truststatus" class="col-sm-1 col-form-label">truststatus</label>
                        <div class="col-sm-11">
                            <input type="number" min='1' max='10' class="form-control" id="truststatus" name="status" value="<?php echo $status ?>" autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="flexRadioDefault2" class="col-sm-1 col-form-label">groupid</label>
                        <div class="col-sm-11">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="groupid" value='1' id="flexRadioDefault1" <?php if ($groupid == '1') echo 'selected';  ?>>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    admin
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="groupid" id="flexRadioDefault2" value='0' checked ?>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    user
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="flexRadioDefault4" class="col-sm-1 col-form-label">regstatus</label>
                        <div class="col-sm-11">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="regstatus" value='1' id="flexRadioDefault3" <?php if ($regstatus == '1') echo 'selected';  ?>>
                                <label class="form-check-label" for="flexRadioDefault3">
                                    yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="regstatus" value='0' id="flexRadioDefault4" checked>
                                <label class="form-check-label" for="flexRadioDefault4">
                                    no
                                </label>
                            </div>
                        </div>
                    </div>

                    <input type="submit" value="edit" class="btn btn-primary mt-3">
                </form>
            </div>
        <?php


        } else {
            echo 'not found id';
        }

        ?>


    <?php

    } else if ($do == 'activate') {            ////////////////////////////////////////////////////////////  activate users
    ?>

        <div class="container">
            <h1 class="text-center">activate page</h1>
        </div>

        <?php

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "update users set regstatus='1' where user_id='$id'";
            try {
                $res = mysqli_query($con, $sql);
                $msg = '<div class="alert alert-warning " >activated successfully</div>';
                redirect($msg, 3, 'members.php');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    } else if ($do == 'delete') {    /////////////////////////////////////////////////////////      delete user
        ?>

        <div class="container">
            <h1 class="text-center">delete page</h1>
        </div>

<?php

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "delete from users where user_id='$id'";
            try {
                $res = mysqli_query($con, $sql);
                $msg = '<div class="alert alert-warning " >deleted successfully</div>';
                redirect($msg, 3, 'members.php');
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
