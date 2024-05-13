<?php

// session_unset();
// session_destroy();

?>

<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <div class="container ">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="categories.php">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="items.php">items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="members.php">members</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="comments.php">comments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">statitcs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">logs</a>
                </li>
            </ul>


            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if (isset($_SESSION['username'])) {
                           echo $_SESSION['username'];
                        }else{
                            echo 'user';
                        } ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">                   
                        <li><a class="dropdown-item" href="../index.php">visit shop</a></li>
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>


        </div>
    </div>
</nav>