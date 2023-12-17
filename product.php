<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/dekstop.css">

    <title>Produk</title>
	<style>
		.fixed-footer {
            width: 100%;
            position: static;
            margin: 0 10px 10px 0;
            padding: 10px 0;
            color: rgba(255, 255, 255, 1);
            text-align: center;
            bottom:0;
		}
		
		a {
            text-decoration: none;
        }
	</style>
</head>

	<?php 
	include 'helper/connection.php';
	session_start(); 
	error_reporting(0); 

	$id_customer = $_SESSION['id_customer'];
	$query = "SELECT * from customer where id_customer = '$id_customer'";

	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_assoc($result);

	$nama = $row['nama_customer'];

	$id_buku = $_GET['id_buku'];

	?>

<body id="page-top">

	<!-- navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-transparan fixed-top" id="mainNav">
		<div class="container">
		<b><a class="navbar-brand text-dark" href="index.php">Taman Baca Kesiman</a></b>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
		<li class="nav-item active">
			<a class="nav-link text-dark" href="index.php"><b>Home</b> <span class="sr-only">(current)</span></a>
		</li>
		<li class="nav-item active">
		<b><a class="nav-link text-dark" href="cart.php">Cart
				<span>(<?php if(isset($_SESSION["nomor"])){ echo $_SESSION["nomor"]; } else{ echo 0 ;} ?>)</span>
			</a></b> 
		</li>
		</div>
		<?php
                if (isset($_SESSION['id_customer'])) {
                    // If the user is logged in, display logout button
                    echo '<a href="logout.php" class="btn btn-danger mr-3 text-white">Logout</a>';
                } else {
                    // If the user is not logged in, display login button
                    echo '<a href="admin/index.php" class="btn btn-dark mr-3 text-white">Login</a>';
                }
                ?>
		</div>
	</nav>

	<!-- Product Details -->
	<div class="product_details">
		<div class="container">
			<div class="row">
				<?php
				$query = 
				"SELECT * from buku where id_buku='$id_buku'";
				
				$result = mysqli_query($con, $query);
				$row = mysqli_fetch_assoc($result);
				$kategori = $row['id_kategori'];
				?>
				<div class='col-lg-6'>
					<div class='details_image'>
						<div class='details_image_large'><img src='images/<?php echo $row['gambar'] ?>' alt=''>
						</div>
					</div>
				</div>

				<!-- Product Content -->
				<div class="col-lg-6">
					<div class="details_content">
						<br><br><br><br><br><br>
						<div class="details_name">
							<?php echo $row['judul_buku'] ?>
						</div>

						<div class="details_price">Rp.
							<?php echo $row['harga'] ?>,-</div>


						<!-- In Stock -->
						<div class="in_stock_container">
							<div class="availability">Availability : </div>
							<?php if($row['stok'] > 0){ ?>
							<span>In Stock</span>
							<?php } else { ?>
							<span>
								<font color="red">Sold Out</font>
							</span>
							<?php } ?>
						</div>

						<div class="details_text">Deskripsi buku : 
							<p>
								<?php echo $row['deskripsi'] ?>
							</p>
						</div>

						<!-- Product Quantity -->
						<?php if($row['stok'] > 0){ ?>
						<div class="product_quantity_container">
							<a href="process/update-cart.php?id_buku=<?php echo $id_buku; ?>" class="btn btn-success mr-3 text-white">Add to cart</a>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Products -->

	<div class="products">
		<div class="container">
			<div class="row">
				<div class="col text-center">
					<div class="products_title">Produk Dengan Kategori Yang Sama</div>
				</div>
			</div>
			<div class="row">
				<div class="col">

					<div class="product_grid">
						<?php
							$query = 
							"SELECT * from buku WHERE id_kategori='$kategori' AND id_buku!='$id_buku'";
							
							$result = mysqli_query($con, $query);

							if (mysqli_num_rows($result) > 0)
							{
								$index = 1;

								while($row = mysqli_fetch_assoc($result))
								{
									$id_buku = $row['id_buku'];
									echo "
									<div class='product'>
										<div class='product_image'><img src='images/". $row['gambar'] ."' alt=''></div>
										<div class='product_content'>
											<div class='product_title'><a href='product.php?id_buku=$id_buku'>".$row['judul_buku']."</a></div>
											<div class='product_price'>Rp.".$row['harga'].",-</div>
										</div>
									</div>
									";
								}
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

		<!-- footer -->
    <div class="fixed-footer bg-dark">
      <div class="container">Copyright &copy; 2023 </div>
    </div>
      
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script>
</body>

</html>