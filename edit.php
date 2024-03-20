<?php

   $servername = "localhost";
   $username = "root";
   $password = "";
   $database = "contact_db";

   $connection = new mysqli($servername, $username, $password, $database);


   $id = "";
   $name = "";
   $email = "";
   $number = "";
   $date = "";

   $errorMessage = "";
   $successMessage = "";

   if($_SERVER['REQUEST_METHOD'] == 'GET'){
      if(!isset($_GET["id"])){
         header("Location: /PROJECT/CRUD.php");
         exit; 
      }

      $id = $_GET["id"];

      $sql = "SELECT * FROM `contact_form` WHERE id=$id";
      $result = $connection->query($sql);
      $row = $result->fetch_assoc();

      if(!$row){
         header("Location: /PROJECT/CRUD.php");
         exit;
      }

      $name = $row["name"];
      $email = $row["email"];
      $number = $row["number"];
      $date = $row["date"];
   }
   else{

      $id = $_POST["id"];
      $name = $_POST["name"];
      $email = $_POST["email"];
      $number = $_POST["number"];
      $date = $_POST["date"];

      do{
         if(empty($id) ||  empty($name) || empty($email) || empty($number) || empty($date)){
            $errorMessage = "All the fields are required";
            break;
         }

         $sql = "UPDATE `contact_form`". "SET `name`='$name',`email`='$email',`number`='$number',`date`='$date' ". "WHERE id = $id"; 

         $result = $connection->query($sql);

         if(!$result){
             $errorMessage = "Invalid Query: " . $connection->error;
             break; 
         }

         $successMessage = "Data Updated Successfully";

         header("Location: /PROJECT/CRUD.php");
         exit;

      } while(true);
   }
?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dental Care Website</title>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css">

   <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
   <div class="container my-5">
      <h2>Make Appointment</h2>

      <?php
         if(!empty($errorMessage)){
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
               <strong>$errorMessage</strong>
               <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
         }
      ?>

      <form method="post">
         <input type="hidden" name = "id" value="<?php echo $id; ?>">
         <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-6">
               <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
            </div>   
         </div>

          <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
               <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
            </div>
         </div>

          <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Phone</label>
            <div class="col-sm-6">
               <input type="number" class="form-control" name="number" value="<?php echo $number; ?>">
            </div>
         </div>

          <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Date</label>
            <div class="col-sm-6">
               <input type="datetime-local" class="form-control" name="date" value="<?php echo $date; ?>">
            </div>
         </div>

         <?php
         if(!empty($successMessage)){
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
               <strong>$successMessage</strong>
               <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
         }
         ?>

          <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
               <button type="submit" class="btn btn-primary">Make Appointment</button>
            </div>
            <div class="col-sm-3 d-grid">
               <a class="btn btn-outline-primary" href="CRUD.php" role="button">Update</a>
            </div>
            </div>
         </div>
      </form>
   </div>
</body>
</html>