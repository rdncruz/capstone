<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section id="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-smile'></i>
            <span class="text">Renz Daryl Cruz</span>
        </a>
        <ul class="sidebar-menu">
            <li class="active">
                <a href="index.html">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Account Settings</span>
                </a>
            </li>
        </ul>
    </section>

    <section id="container">
        <nav>
			<i class='bx bx-menu' ></i>
			
			<form action="#">
				<!---->
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
            <div class="head-title">
				<div class="left">
					<h1>Admin Panel</h1>
					<ul class="breadcrumb">
						
					</ul>
				</div>

			</div>

            <ul class="box-info">
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3>1020</h3>
						<p>Total User</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h3>2834</h3>
						<p>Total Verified Seller</p>
					</span>
				</li>
	
				<li>
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">
						<h3>$2543</h3>
						<p>Unverified Seller</p>
					</span>
				</li>
			</ul>

            <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Unverified user</h3>
						<i class='bx bx-filter' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>User Name</th>
								<th>Details</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<img src="img/people.png">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status completed">Completed</span></td>
							</tr>
							<tr>
								<td>
									<img src="img/people.png">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
									<img src="img/people.png">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status process">Process</span></td>
							</tr>
							<tr>
								<td>
									<img src="img/people.png">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
									<img src="img/people.png">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status completed">Completed</span></td>
							</tr>
						</tbody>
					</table>
				</div>
            </div>
        </main>
    </section>
	<script src="javascript/design.js"></script>
</body>
</html>