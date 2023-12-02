<?php
    session_start();
    require 'php/dbcon.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Center</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Override Bootstrap's container padding -->
    <style>
       
        #sidebar .sidebar-menu {
            margin-top: 1;
            padding: 0;
        }
    </style>
    
    <!-- Include the Bootstrap stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</header>
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
            <li>
                <a href="store.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Product</span>
                </a>
            </li>
			<li class="active">
                <a href="Seller_Center.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Sell on E-Fishing</span>
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
        <nav class="custom-nav">
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
            <div class="container mt-4">
                <?php include('php/message.php'); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Student Details
                                    <a href="student-create.php" class="btn btn-primary float-end">Add Students</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Student Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Course</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $query = "SELECT * FROM students";
                                            $query_run = mysqli_query($conn, $query);
                                            if(mysqli_num_rows($query_run) > 0)
                                            {
                                                foreach($query_run as $student)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?= $student['id']; ?></td>
                                                        <td><?= $student['name']; ?></td>
                                                        <td><?= $student['email']; ?></td>
                                                        <td><?= $student['phone']; ?></td>
                                                        <td><?= $student['course']; ?></td>
                                                        <td>
                                                            <a href="student-view.php?id=<?= $student['id']; ?>" class="btn btn-info btn-sm">View</a>
                                                            <a href="student-edit.php?id=<?= $student['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                                            <form action="code.php" method="POST" class="d-inline">
                                                                <button type="submit" name="delete_student" value="<?=$student['id'];?>" class="btn btn-danger btn-sm">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            else
                                            {
                                                echo "<h5> No Record Found </h5>";
                                            }
                                        ?>                                       
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </main>
    </section>
	<script src="javascript/design.js"></script>
</body>
</html>