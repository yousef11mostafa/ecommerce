<?php
ob_start();
session_start();

if (isset($_SESSION['username'])) {
    include("init.php");

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') {

        //
        include("nav.php");
        $sql = "select comments.* , users.username,items.name from comments join users on comments.user_id = users.user_id join items on comments.item_id=items.item_id;";
        try {
            $res = $con->query($sql);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

?>
<div class="container">
    <h1 class="text-center mt-3 fw-bold mb-5">manage comments</h1>
    <table class="table table-bordered">
        <tr class="tr table-dark text-center">
            <td>comment_id</td>
            <td>comment</td>
            <td>item Name</td>
            <td>user Name</td>
            <td>added date</td>
            <td>modify</td>
        </tr>

        <?php

                while ($row = $res->fetch_assoc()) {
                    echo "<tr class='text-center'>";
                    echo "<td>$row[c_id]</td>";
                    echo "<td>$row[comment]</td>";
                    echo "<td>$row[name]</td>";
                    echo "<td>$row[username]</td>";
                    echo "<td>$row[comment_date]</td>";
                ?>
        <td class=''>
            <span><a href="?do=edit&id=<?php echo $row['c_id'] ?>" class=" btn btn-warning"><i
                        class="fa fa-edit fa-sm"></i>edit</a></span>
            <span><a href="?do=delete&id=<?php echo $row['c_id'] ?>" class=" btn btn-danger"><i
                        class="fa fa-remove fa-sm"></i>delete</a></span>
            <?php
                        if ($row['status'] == 0) {
                        ?>
            <span><a href="?do=activate&id=<?php echo $row['c_id'] ?>" class="btn btn-primary">+ approve</a></span>
            <?php
                        }
                        ?>
        </td>
        <?php

                    echo "</tr>";
                }

                ?>

    </table>

</div>
<?php





    } else if ($do == 'add') { ///////////////////////////////////////// add comment

        //start add

        // end add

    } else if ($do == 'edit') {        ///////////////////////////////////////////////////////////////////   edit comment

        // start edit
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "select * from comments where c_id='$id' ";
            try {
                $res = mysqli_query($con, $sql);
            } catch (exception $e) {
                $msg = '<div class="alert alert-danger">you should not be here</div>';
                redirect($msg, 3, '');
                echo "not found";
            }
            $count = mysqli_num_rows($res);
            if ($count > 0) {
                $row = mysqli_fetch_assoc($res);
                $comment = $row['comment'];

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $comment = $_POST['comment'];
                    $sql = "update comments set comment='$comment' where c_id='$id' ";
                    try {
                        $res = mysqli_query($con, $sql);
                        $msg = '<div class="alert alert-success " >edited successfully</div>';
                        redirect($msg, 3, '');
                    } catch (Exception $e) {
                        echo $e->getMessage();
                        echo 'failed';
                    }
                }
                //
        ?>
<div class="container">
    <form action="" method='POST' class="membersform">
        <h1 class="text-center mt-3 fw-bold mb-5">edit comment</h1>
        <div class="row mb-3">
            <label for="area" class="col-sm-1 col-form-label">comment</label>
            <div class="col-sm-11">
                <textarea class="form-control" name="comment" id="area"><?php echo $comment; ?></textarea>
            </div>
        </div>
        <input type="submit" value="edit" class="btn btn-primary mb-3"></input>
    </form>
</div>
<?php
                //
            } else {
                echo "not found";
            }
        } else {
            echo 'not found id';
        }

        ?>


<?php

        //end add

    } else if ($do == 'edit') {
    } else if ($do == 'activate') { /////////////////////////////  approve comment

    ?>

<div class="container">
    <h1 class="text-center">activate comment </h1>
</div>

<?php

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "update comments set status='1' where c_id='$id'";
            try {
                $res = mysqli_query($con, $sql);
                $msg = '<div class="alert alert-warning " >comment activated successfully</div>';
                redirect($msg, 3, '');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    } else if ($do == 'delete') {   ////////////////////////////////////////////////  delete comment
        ?>

<div class="container">
    <h1 class="text-center">delete comment </h1>
</div>

<?php

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "delete from comments where c_id='$id'";
            try {
                $res = mysqli_query($con, $sql);
                $msg = '<div class="alert alert-warning " >comment deleted successfully</div>';
                redirect($msg, 3, '');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    
    include $tmp . "/footer.php";
    ob_end_flush();
} else {
    include("init.php");
    $msg = '<div class="alert alert-warning " >yo not allowed in this page </div>';
    redirect($msg, 3, '');
    include $tmp . "/footer.php";
}