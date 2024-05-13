<?php
session_start();
include ('init.php');

$id= isset($_GET['id']) ? $_GET['id'] : '0';
// $sql = "select * from items  where cat_id='$id' ";
//         try {
//             $res = mysqli_query($con, $sql);
//         } catch (Exception $e) {
//             echo $e->getMessage();
//         }
// $res=getAll('*','items','where cat_id='.$id,'','item_id','');
$res=getAll("*","items","where cat_id=".$id,"","item_id","");
?>

<div class="container">
    <h1 class="text-center mt-3 mb-5">show category</h1>
    <div class="row ">
       <?php
       while($row=mysqli_fetch_assoc($res)){
        ?>
         <div class="card col-md-6 col-lg-3 mb-3 mt-3">
            <img src="https://cdn5.vectorstock.com/i/1000x1000/51/99/icon-of-user-avatar-for-web-site-or-mobile-app-vector-3125199.jpg" alt="" class="card-img-top">
            <div class="card-body">
                <div class="card-title text-primary fw-bold"><?=$row['name']?></div>
                <div class="card-text"><?=$row['description']?></div>
                <span class='price'><?='$'. $row['price']?></span>
            </div>
        </div>
        <?php
       }
       
       ?>
    </div>
</div>



<?php include $tmp . '/footer.php';?>
