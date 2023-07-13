<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['Buy_shop'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image);

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
      $message[] = 'already added to wishlist!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }

}

if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home page</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="home-bg">

   <section class="home">

      <div class="content">
      
         <h1>Always Deliver More Than Expected</h1>
        <p>Buy Your Best Product</p>
         <a href="about.php" class="btn">about us</a>
      </div>

   </section>

</div>

<section class="home-category">

   <h1 class="title">shop by category</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/cat-1.png" alt="">
         <h3>fruits</h3>
         <p></p>
         <a href="category.php?category=fruits" class="btn">fruits</a>
      </div>
      <div class="box">
         <img src="images/cat-3.png" alt="">
         <h3>vegitables</h3>
         <p></p>
         <a href="category.php?category=vegitables" class="btn">vegitables</a>
      </div>
      <div class="box">
         <img src="images/cat-2.png" alt="">
         <h3>meat</h3>
         <p></p>
         <a href="category.php?category=meat" class="btn">meat</a>
      </div>

      
      <div class="box">
         <img src="images/cat-4.png" alt="">
         <h3>fish</h3>
         <p></p>
         <a href="category.php?category=fish" class="btn">fish</a>
      </div>

   </div>

</section>




<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>