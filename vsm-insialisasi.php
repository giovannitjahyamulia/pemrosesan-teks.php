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
			<form action="vsm-result.php" method="post" class="w-100">
	      <div class="form-group w-100">
					<p class="text-center p-3">Masukan query yang akan digunakan</p>
					<input type='text' class='form-control' placeholder='Query' name='dokumen[0]'>

					<p class="text-center p-3">Masukan dokumen yang akan digunakan</p>
					<div class="form-group">
						<table width="100%">
							<?php
							if($_POST['jumlah'] == 1){
								echo "
								<tr class='pb-2'>
								<td class='p-1'><input type='text' class='form-control' placeholder='Dokumen' name='dokumen[1]'></td>
								</tr>
								";
							}
							else{
								for ($i = 1; $i <= $_POST['jumlah']; $i++){
									echo "
									<tr class='pb-2'>
									<td class='p-1'>$i.</td>
									<td class='p-1'><input type='text' class='form-control' placeholder='Dokumen' name='dokumen[$i]'></td>
									</tr>
									";
								}
							}
							?>
						</table>
						<div class="d-flex justify-content-center">
							<input type="submit" class="btn btn-dark mt-2" value="Lanjutkan"/>
						</div>
					</div>
	      </div>
	    </form>
		</div>
	</div>
</body>
</html>
