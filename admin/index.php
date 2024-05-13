                  <?php

                  session_start();
                  require('init.php');


                  if (isset($_SESSION['username'])) {
                    header('location:dashboard.php');
                  }


                  if ($_SERVER["REQUEST_METHOD"] == 'POST') {

                    $name = $_POST['name'];
                    $pass = $_POST['pass'];
                    $pass=sha1($pass);
                    $sql = "select * from users where username='$name' and password='$pass' and regstatus=1 ";
                    try {
                      $res = mysqli_query($con, $sql);
                      $count = mysqli_num_rows($res);
                      if ($count > 0) {
                        $_SESSION['username'] = $name;
                        header("location:dashboard.php");
                      } else {
                        echo '<div class="alert alert-warning " >this user not found </div>';
                      }
                    } catch (exception $e) {
                      echo '<br>';
                      echo $e->getMessage();
                    }
                  }


                  ?>


                  <div class="container">
                    <form action="" method='POST' class="login mt-5">
                      <h1 class="text-center mb-5 fw-bold text-secondary">login page</h1>
                      <div class="mb-3">
                        <label for="name" class="form-label">Username</label>
                        <input type="text" id="name" name="name" placeholder="username" class=" input_field form-control" autocomplete="OFF">
                      </div>
                      <div class="mb-3">
                        <label for="pass" class="form-label">Password</label>
                        <input type="Password" id="pass" name="pass" placeholder="password" class="input_field form-control" autocomplete="off">
                      </div>
                      <input type="submit" value="login in " class="btn btn-primary">
                    </form>
                  </div>


                  <!-- end body -->
                  <?php include $tmp . "/footer.php" ?>