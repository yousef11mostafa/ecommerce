<?php
session_start();
include('init.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_POST['login'])) {
        $name = $_POST['username'];
        $pass = $_POST['password'];
        $pass = sha1($pass);
        $sql = "select * from users where username='$name' and password='$pass' ";
        try {
            $res = mysqli_query($con, $sql);
            $count = mysqli_num_rows($res);
            if ($count > 0) {
                $_SESSION['User'] = $name;
                header("location:index.php");
            } else {
                echo '<div class="alert alert-warning " >this user not found </div>';
            }
        } catch (exception $e) {
            echo '<br>';
            echo $e->getMessage();
        }
    } else {
               ///signup
                $name = $_POST['username'];
                $email = $_POST['email'];
                $pass1 = $_POST['password'];
                $pass2 = $_POST['password2']; 
                
                // echo $name . ' '. $email . ' ' . $pass1 . ' ' . $pass2;
                $formerrors = array();
                if (empty($name)) {
                    $formerrors[] = 'the name is empty';
                }
                if (empty($email)) {
                    $formerrors[] = 'the email is empty';
                }
                if (empty($pass1)) {
                    $formerrors[] = 'the pass is empty';
                }
                if (empty($pass2)) {
                    $formerrors[] = 'the fullname is empty';
                }
                if($pass1!==$pass2){
                    $fromerros[]='the password not matched';
                }
                $pass1 = sha1($pass1);
                $pass2 = sha1($pass2);

                if (empty($formerrors)) {
                    $count = checkrow($name,'username', 'users');
                    if ($count < 1) {
                        $sql = "insert into users (username,email,password,fullname,truststatus,groupid,regstatus) values('$name','$email','$pass1','','0','0','0');";
                        try {
                            $res = mysqli_query($con, $sql);
                            if ($res) {
                                $_SESSION['User'] = $name;
                                header("location:index.php");
                            }
                        } catch (exception $e) {
                            echo $e->getMessage();
                            echo 'not found';
                        }
                    } else {
                        echo "<div class=\"alert alert-warning alert-sm\">failed to add this username has aleardy found</div>";
                    }
                }
            
               ///signup
    }
}





?>



<div class="container">
    <h1 class="logintext"><span class='selected'>login/</span class='signup-link'><span>signup</span></h1>

    <?php
            if (!empty($formerrors)) {
                foreach ($formerrors as $error) {
                    echo "<div class=\"alert alert-danger alert-sm\">$error</div>";
                }
            }
            ?>

    <form action="" method="POST" class="login-form">
        <div class="form-group mb-3">
            <label for="name" class="form-label">username</label>
            <input type="text" id="name" name="username" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="pass" class="form-label">password</label>
            <input type="text" id="pass" name="password" class="form-control" required>
        </div>
        <input type="submit" value="login" name="login" class="btn btn-primary">
    </form>

    <form action="" method="post" class="login-form signup selected-form">
        <div class="form-group mb-3">
            <label for="name" class="form-label">username</label>
            <input type="text" id="name" name="username" pattern=".{4,20}" class="form-control required">
        </div>
        <div class="form-group mb-3">
            <label for="name" class="form-label">email</label>
            <input type="email" id="name" name="email" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="pass" class="form-label">password</label>
            <input type="text" id="pass" name="password" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="pass" class="form-label">confirm password</label>
            <input type="text" id="pass" name="password2" class="form-control" required>
        </div>
        <input type="submit" value="signup" class="btn btn-primary">
    </form>

</div>

<?php include $tmp . '/footer.php'; ?>