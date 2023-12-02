<?php 
function product($productcategory, $productname, $productprice, $productimg, $productid) {
    echo '

    
    <div class="col-md-4 mt-2">
    <form action="store.php" method="post">     
        <div class="card">
            <div class="card-body">
                <div class="card-img-actions">                                   
                    <img src="Image/' . $productimg . '" class="card-img img-fluid">
                </div>
            </div>
            <div class="card-body bg-light text-center">
                <div class="mb-2">
                    <h6 class="font-weight-semibold mb-2">
                        <a href="#" class="text-default mb-2" data-abc="true">' . $productname . '</a>
                    </h6>
                    <a href="#" class="text-muted" data-abc="true">' . $productcategory . 's</a>
                </div>

                <h3 class="mb-0 font-weight-semibold">₱' . $productprice . '</h3>
                <div>
                    <i class="fa fa-star star"></i>
                    <i class="fa fa-star star"></i>
                    <i class="fa fa-star star"></i>
                    <i class="fa fa-star star"></i>
                </div>
                <div class="text-muted mb-3">34 reviews</div>
                <button type="submit" class="btn btn-warning my-3" name="add">Add to cart <i class="fas fa-shopping-cart"></i></button>
                <button type="submit" class="btn btn-warning my-3" name="details">View Details <i class="fas fa-shopping-cart"></i></button>
                <input type="hidden" name="product_id" value="' . $productid . '">
            </div>
        </div>  
        </form>                  
    </div>';
}

function cartElement($productimg, $productname, $productprice, $productid) {
    echo '
    <form action="cart.php?action=remove&id=' . $productid . '" method="post" class="cart-items">
        <div class="border rounded">
            <div class="row bg-white">
                <div class="col-md-3 pl-0">
                    <img src="Images/Products/' . $productimg . '" alt="Image1" class="img-fluid">
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
                        <button type="button" class="btn bg-light border rounded-circle"><i class="fas fa-minus"></i></button>
                        <input type="text" value="1" class="form-control w-25 d-inline">
                        <button type="button" class="btn bg-light border rounded-circle"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>';
}
?>
