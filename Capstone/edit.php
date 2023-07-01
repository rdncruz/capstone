<?php 
    session_start();
    include 'php/db.php';
    
    $id = "";
    $category = "";
    $name = "";
    $small_description = "";
    $price = "";
    $image = "";
    $quantity = "";
    $status = "";

    $errorMessage = "";
    $successMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        //GET Method: Show the data of the client

        if(!isset($_GET["id"])) {
            header("location: ./product.php");
            exit;
        }
        $id = $_GET["id"];

        // read the row of the selected client from database table
        $sql = "SELECT * FROM products WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        
        if(!$row) {
            header("location: ./product.php");
            exit;
        }

        $category = $row["category"];
        $name = $row["name"];
        $small_description = $row["small_description"];
        $price = $row["price"];
        $quantity = $row["quantity"];
        $status = $row["status"];
        
    }
    else {
        // POST Method: update the data of the client
        $id = $_POST["id"];
        $category = $_POST["category"];
        $name = $_POST["name"];
        $small_description = $_POST["small_description"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $status = $_POST["status"];
        
        do {
            if (empty($id) || empty($category) || empty($name) || empty($small_description) || empty($price) || empty($quantity) || empty($status) ) {
                $errorMessage= "All the fiels Are Required";
                break;
            }


            //add new product to database

            $sql = "UPDATE products SET category = '$category', name = '$name', small_description = '$small_description', price = '$price', quantity = '$quantity', status = '$status' WHERE id = $id";


            $result = $conn->query($sql);

            if(!$result) {
                $errorMessage = "Invlaid query: ". $conn->error;
                break;
            }
            $successMessage = "Client updated Correctly";

            header("location: ./product.php");
            exit;

        } while(false);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="css/error.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <h2>New Product</h2>

    <?php 
        if(!empty($errorMessage)) {
            echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            ";

        }
    ?>

    <form method="post">
        <input type="hidden" value="<?php echo $id; ?>" name="id">
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Category</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="category"  value="<?php echo $category; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Small_Description</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="small_description" value="<?php echo $small_description; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Price</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="price"  value="<?php echo $price; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Quantiy</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="quantity" value="<?php echo $quantity; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Status</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="status" value="<?php echo $status; ?>">
            </div>
        </div>
        <!--<div class="row mb-3">
            <label class="col-sm-3 col-form-label">Created_at</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="create_at" value="">
            </div>
        </div>-->
        <?php 
            if(!empty($successMessage) ) {
                echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$successMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                ";
            }
        ?>

        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid"> 
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col-sm-3 d-grid"> 
                <a class="btn btn-outline-primary" href="./product.php" role="button">Cancel</a>
            </div>
        </div>
    </form>
</div>
</body>
</html>