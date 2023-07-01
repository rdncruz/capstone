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

        
        <div class="form">
            <form action="" ectype="multipart/form-data">
            <div class="error-text">Error</div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Category</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="category">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Small_Description</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="small_description">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Price</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="price">
                    </div>
                </div>
            <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">image</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" name="image">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Quantiy</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="quantity">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="status">
                    </div>
                </div>
                <!--?php 
                    if(!empty($successMessage) ) {
                        echo "
                        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                        ";
                    }
                ?>-->

                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid"> 
                        <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                    </div>
                    <div class="col-sm-3 d-grid"> 
                        <a class="btn btn-outline-primary" href="./product.php" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="js/adding.js"></script>
</body>
</html>