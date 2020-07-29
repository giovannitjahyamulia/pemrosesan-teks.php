<!DOCTYPE html>
<html lang="en" class="h-100" id ="html">

<head>
	<meta charset="utf-8" />

	<title>
	  Pemrosesan Teks
	</title>

	<!--Fonts and icons-->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<!-- CSS Files -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body class="h-100 w-100 bg-light">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item">
	        <a class="nav-link" href="tokenisasi.php">Tokenisasi</a>
	      </li>
				<li class="nav-item">
					<a class="nav-link" href="stopwordsremoval.php">Stopwords Removal</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="stemming.php">Stemming</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="indexing.php">Indexing</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="preprocessing.php">Preprocessing</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="query.php">Query</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="vsm.php">Vector Space Model</a>
				</li>
	    </ul>
	  </div>
	</nav>

	<div class="p-5">
		<div class="d-flex justify-content-center align-item-center">
			<div class="col-lg-6">
				<div class="card card-body bg-light p-4">
					<h1 class="text-dark text-center p-3">Selamat Datang!</h1>
					<hr>
					<h5 class="font-weight-normal text-center mb-4">Website ini dapat melakukan pemrosesan teks, seperti tokenisasi, stopword removal, stemming, dan indexing.</h5>
			    <div class="row justify-content-center align-item-center">
						<a href="tokenisasi.php" class="btn btn-danger m-1" style="text-decoration:none;">Tokenisasi</a>
						<a href="stopwordsremoval.php" class="btn btn-warning m-1" style="text-decoration:none;">Stopwords Removal</a>
						<a href="stemming.php" class="btn btn-success m-1" style="text-decoration:none;">Steming</a>
						<a href="indexing.php" class="btn btn-primary m-1" style="text-decoration:none;">Indexing</a>
						<a href="indexing.php" class="btn btn-info m-1" style="text-decoration:none;">Preprocessing</a>
					</div>
					<h5 class="font-weight-normal text-center my-4">Website ini juga dapat menghitung kemiripan antar dokumen dengan menggunakan metode Query dan Vector Space Model.</h5>
					<div class="d-flex justify-content-center align-item-center mb-2">
						<a href="query.php" class="btn btn-danger mx-1" style="text-decoration:none;">Query</a>
						<a href="vsm.php" class="btn btn-warning mx-1" style="text-decoration:none;">Vector Space Model</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
