<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/cart.css">
    <title>Cart</title>
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
	<div class="jumbotron">
		<div class="container">
			<h1 class="display-4"><span class="font-weight-bold">Berikut Hasil Belanja Anda</span></h1>
		</div>
	</div>

	<!-- Cart Info -->
	<div class="col-lg-8 offset-lg-2">
		<table class="table table-bordered">
			<thead align="center">
				<tr>
					<th>No</th>
					<th>Buku</th>
					<th>Harga</th>
					<th>Jumlah</th>
					<th>Subharga</th>
					<th>Aksi</th>
				</tr>
			</thead>

			<tbody align="center">
				<?php
					if(isset($_SESSION["keranjang"]))
					{
						$total = 0;
						$nomor = 1;
						foreach ($_SESSION["keranjang"] as $id_buku => $jumlah){
						
						$ambil = $con->query("SELECT * FROM buku WHERE id_buku='$id_buku'");
						$pecah = $ambil->fetch_assoc();
						$subharga =$pecah["harga"]*$jumlah;
						$total += $subharga;
					?>
				<tr>
					<td>
						<?php echo $nomor; ?>
					</td>
					<td>
						<?php echo $pecah['judul_buku']; ?>
					</td>
					<td>Rp.
						<?php echo number_format($pecah['harga']); ?>
					</td>
					<td>
						<?php echo $jumlah; ?>
					</td>
					<td>Rp.
						<?php echo number_format($subharga); ?>
					</td>
					<td width='50px'>
						<a href="process/delete-cart.php?id_buku=<?php echo $id_buku; ?>" class="btn btn-danger">Hapus</a>
					</td>
				</tr>
				<?php
				$nomor++;
				?>
				<?php }
						}
						else
						{
							echo "
							<tr>
								<td colspan='6'>Tidak Ada Data</td>
							</tr>";
						} ?>
			</tbody>
		</table>


		<div class="row">
			<div class="col">
				<div class="cart_buttons d-flex flex-lg-row flex-column align-items-start justify-content-start">
					<a href="index.php#produk" class="btn btn-info text-white">Continue shopping</a>
					<?php if(isset($_SESSION["keranjang"])){ ?>
					<div class="cart_buttons_right ml-lg-auto">
						<a href="process/clear-cart.php" class="btn btn-warning text-white">Clear cart</a>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

	<?php if(isset($_SESSION["keranjang"])){ ?>
	<div class="col-lg-8 offset-lg-2">
		<div class="cart_total_container">
			<b><ul>
				<li class="d-flex flex-row align-items-center justify-content-start">
					<div class="cart_total_title">Total Belanja</div>
					<div class="cart_total_value ml-auto">Rp.
						<?php echo $total;?>,-</div>
				</li>
			</ul>
		</div>
		<br>
			<a href="process/input-cart.php" class="checkout_button btn btn-success">Proceed to checkout</a>
		</div>
	</div>
	<?php } ?>

		<br><br>

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