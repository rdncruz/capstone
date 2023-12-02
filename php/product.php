<?php 
function product($productcategory, $productname, $productprice, $productimg, $productid) {
    echo '

    
    
    <form action="store.php" method="post">     
    <div class="product-card">
		<div class="badge">Hot</div>
		<div class="product-tumb">
			<img src="Image/' . $productimg . '"  alt="">
		</div>
		<div class="product-details">
			<span class="product-catagory">' . $productcategory . '</span>
			<h4><a href="./product_details.php?product_id=' . $productid . '">' . $productname . '</a></h4>
			<div class="product-bottom-details">
				<div class="product-price"><small>₱' . $productprice . '</small>$230.99</div>
				<div class="product-links">
                 
                    

                    <button type="submit" class="fa fa-heart" name="add">Add to cart <i class="fas fa-shopping-cart"></i></button>
                    <a href="./product_details.php?product_id=' . $productid . '" class="fa fa-shopping-cart" name="view">View Details <i class="fas fa-info-circle"></i></a>
                    <input type="hidden" name="product_id" value="' . $productid . '">
				</div>
			</div>
		</div>
	</div>
    </form>     ';
    
}


function cartElement($productimg, $productname, $productprice, $productid) {
    echo '
    <form action="cart.php?action=remove&id=' . $productid . '" method="post" class="cart-items">
        <div class="border rounded">
            <div class="row bg-white">
                <div class="col-md-3 pl-0">
                    <img src="Images/' . $productimg . '" alt="Image1" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h5 class="pt-2">' . $productname . '</h5>
                    <small class="text-secondary"> Seller: daily tuition</small>
                    <h5 class="pt-2">$' . $productprice . '</h5>
                    <a href="store.php" class="btn btn-warning">Save for Later</a>
                    <button type="submit" class="btn btn-danger mx-2" name="remove">Remove</button>
                </div>
                <div class="col-md-3 py-5">
                    <div>
                        <button type="button" class="btn bg-light border rounded-circle decrement-quantity"><i class="fas fa-minus"></i></button>
                        <input type="text" value="1" class="form-control w-25 d-inline quantity-input" data-product-id="' . $productid . '">
                        <button type="button" class="btn bg-light border rounded-circle increment-quantity"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>';
}




function s($productcategory, $productname, $smalldescription, $productprice, $productimg, $productid) {
    echo '
    <form action="store.php" method="post">     
    <div class="single-product">
        <div class="row">
            <div class="col-6">
                <div class="product-image">
                    <div class="product-image-main">
                        <img src="Image/' . $productimg . '" alt="" id="product-main-image">
                    </div>
                </div>
            </div>
            <div class="col-6">

                <div class="product">
                    <div class="product-title">
                        <h2>' . $productname . '</h2>
                    </div>
                    <div class="product-rating">
                        <span><i class="bx bxs-star"></i></span>
                        <span><i class="bx bxs-star"></i></span>
                        <span><i class="bx bxs-star"></i></span>
                        <span><i class="bx bxs-star"></i></span>
                        <span><i class="bx bxs-star"></i></span>
                        <span class="review">(47 Review)</span>
                    </div>
                    <div class="product-price">
                        <span class="offer-price"> ₱' . $productprice . '</span>
                    
                    </div>

                    <div class="product-detailss">
                        <h3>Description</h3>
                        <p>' . $smalldescription . '</p>
                    </div>


                    <div class="product-btn-group">
                        <a href="./store.php?" class="button add-cart" name="view">Go Back<i class="bx bxs-cart"></i></a>
                   
                        <button type="submit" class="button buy-now" name="add">Add to cart <i class="bx bxs-cart"></i></button>
              
                        <input type="hidden" name="product_id" value="' . $productid . '">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="comments-container">
		<h1>Reviews</h1>

		<ul id="comments-list" class="comments-list">
			<li>
				<div class="comment-main-level">

					<div class="comment-avatar"><img src="" alt=""></div>

					<div class="comment-box">
						<div class="comment-head">
							<h6 class="comment-name by-author"><a href="#">Agustin Ortiz</a></h6>
							<span>20 minutes ago</span>
							<i class="fa fa-reply"></i>
							<i class="fa fa-heart"></i>
						</div>
						<div class="comment-content">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
						</div>
					</div>
				</div>

				<ul class="comments-list reply-list">
					<li>
						<div class="comment-avatar"><img src="" alt=""></div>

						<div class="comment-box">
							<div class="comment-head">
								<h6 class="comment-name"><a href="#">Lorena Rojero</a></h6>
								<span>10 minutes ago</span>
								<i class="fa fa-reply"></i>
								<i class="fa fa-heart"></i>
							</div>
							<div class="comment-content">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
							</div>
						</div>
					</li>
				</ul>
			</li>

			<li>
				<div class="comment-main-level">

					<div class="comment-avatar"><img src="" alt=""></div>

					<div class="comment-box">
						<div class="comment-head">
							<h6 class="comment-name"><a href="#">Lorena Rojero</a></h6>
							<span>10 minutes ago</span>
							<i class="fa fa-reply"></i>
							<i class="fa fa-heart"></i>
						</div>
						<div class="comment-content">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
						</div>
					</div>
				</div>
			</li>
            <li>
				<div class="comment-main-level">

					<div class="comment-avatar"><img src="" alt=""></div>

					<div class="comment-box">
						<div class="comment-head">
							<h6 class="comment-name"><a href="#">Lorena Rojero</a></h6>
							<span>10 minutes ago</span>
							<i class="fa fa-reply"></i>
							<i class="fa fa-heart"></i>
						</div>
						<div class="comment-content">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
    </form>';

}


?>
