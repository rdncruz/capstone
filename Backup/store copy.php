<?php 
    require_once('./php/product.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Center</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
  
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <section id="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-smile'></i>
            <span class="text">Renz Daryl Cruz</span>
        </a>
        <ul class="sidebar-menu">
            <li>
                <a href="index.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="inbox.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Inbox</span>
                </a>
            </li>
            <li class="active">
                <a href="product.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Product</span>
                </a>
            </li>
			<li>
                <a href="Seller_Center.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Seller Centre</span>
                </a>
            </li>
            <li>
                <a href="location.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Location</span>
                </a>
            </li>
        </ul>
    </section>

    <section id="container">
        <nav>
			<i class='bx bx-menu' ></i>
		
			<form action="#">
				<div class="form-input">
					<!---->
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a>
			<a href="#" class="profile">
				<img src="img/people.png">
			</a>
		</nav>
        <main>
            <div class="product">
                <section style="background-color: #eee;">
                    <div class="container py-5">
                        <div class="row"> 
                            <div class="col-md-12 col-lg-4 mb-4 mb-lg-0">
                                <div class="card"> 
                                    <div class="d-flex justify-content-between p-3"> 
                                        <p class="lead mb-0">Today's Combo Offer</p>
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center shadow-1-strong"
                                        style="width: 35px; height: 35px;">
                                        <p class="text-white mb-0 small">x4</p>
                                        </div>
                                    </div>
                                    <img src="image/1692811330IMG_20221128_134352.jpg"
                                    class="card-img-top" alt="Laptop" />
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                        <p class="small"><a href="#!" class="text-muted">Laptops</a></p>
                                        <p class="small text-danger"><s>$1099</s></p>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">HP Notebook</h5>
                                        <h5 class="text-dark mb-0">$999</h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <p class="text-muted mb-0">Available: <span class="fw-bold">6</span></p>
                                            <div class="ms-auto text-warning">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4 mb-4 mb-lg-0">
                                <div class="card"> 
                                    <div class="d-flex justify-content-between p-3"> 
                                        <p class="lead mb-0">Today's Combo Offer</p>
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center shadow-1-strong"
                                        style="width: 35px; height: 35px;">
                                        <p class="text-white mb-0 small">x4</p>
                                        </div>
                                    </div>
                                    <img src="image/1692811330IMG_20221128_134352.jpg"
                                    class="card-img-top" alt="Laptop" />
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                        <p class="small"><a href="#!" class="text-muted">Laptops</a></p>
                                        <p class="small text-danger"><s>$1099</s></p>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">HP Notebook</h5>
                                        <h5 class="text-dark mb-0">$999</h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <p class="text-muted mb-0">Available: <span class="fw-bold">6</span></p>
                                            <div class="ms-auto text-warning">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4 mb-4 mb-lg-0">
                                <div class="card"> 
                                    <div class="d-flex justify-content-between p-3"> 
                                        <p class="lead mb-0">Today's Combo Offer</p>
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center shadow-1-strong"
                                        style="width: 35px; height: 35px;">
                                        <p class="text-white mb-0 small">x4</p>
                                        </div>
                                    </div>
                                    <img src="image/1692811330IMG_20221128_134352.jpg"
                                    class="card-img-top" alt="Laptop" />
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                        <p class="small"><a href="#!" class="text-muted">Laptops</a></p>
                                        <p class="small text-danger"><s>$1099</s></p>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">HP Notebook</h5>
                                        <h5 class="text-dark mb-0">$999</h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <p class="text-muted mb-0">Available: <span class="fw-bold">6</span></p>
                                            <div class="ms-auto text-warning">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4 mb-4 mb-lg-0">
                                <div class="card"> 
                                    <div class="d-flex justify-content-between p-3"> 
                                        <p class="lead mb-0">Today's Combo Offer</p>
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center shadow-1-strong"
                                        style="width: 35px; height: 35px;">
                                        <p class="text-white mb-0 small">x4</p>
                                        </div>
                                    </div>
                                    <img src="image/1692811330IMG_20221128_134352.jpg"
                                    class="card-img-top" alt="Laptop" />
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                        <p class="small"><a href="#!" class="text-muted">Laptops</a></p>
                                        <p class="small text-danger"><s>$1099</s></p>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">HP Notebook</h5>
                                        <h5 class="text-dark mb-0">$999</h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <p class="text-muted mb-0">Available: <span class="fw-bold">6</span></p>
                                            <div class="ms-auto text-warning">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4 mb-4 mb-lg-0">
                                <div class="card"> 
                                    <div class="d-flex justify-content-between p-3"> 
                                        <p class="lead mb-0">Today's Combo Offer</p>
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center shadow-1-strong"
                                        style="width: 35px; height: 35px;">
                                        <p class="text-white mb-0 small">x4</p>
                                        </div>
                                    </div>
                                    <img src="image/1692811330IMG_20221128_134352.jpg"
                                    class="card-img-top" alt="Laptop" />
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                        <p class="small"><a href="#!" class="text-muted">Laptops</a></p>
                                        <p class="small text-danger"><s>$1099</s></p>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">HP Notebook</h5>
                                        <h5 class="text-dark mb-0">$999</h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <p class="text-muted mb-0">Available: <span class="fw-bold">6</span></p>
                                            <div class="ms-auto text-warning">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4 mb-4 mb-lg-0">
                                <div class="card"> 
                                    <div class="d-flex justify-content-between p-3"> 
                                        <p class="lead mb-0">Today's Combo Offer</p>
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center shadow-1-strong"
                                        style="width: 35px; height: 35px;">
                                        <p class="text-white mb-0 small">x4</p>
                                        </div>
                                    </div>
                                    <img src="image/1692811330IMG_20221128_134352.jpg"
                                    class="card-img-top" alt="Laptop" />
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                        <p class="small"><a href="#!" class="text-muted">Laptops</a></p>
                                        <p class="small text-danger"><s>$1099</s></p>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">HP Notebook</h5>
                                        <h5 class="text-dark mb-0">$999</h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <p class="text-muted mb-0">Available: <span class="fw-bold">6</span></p>
                                            <div class="ms-auto text-warning">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </section>
	<script src="javascript/design.js"></script>

</body>
</html>
                       