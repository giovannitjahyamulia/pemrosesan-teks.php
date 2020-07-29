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
		<table class='table table-hover'>
			<?php
			// tidak menampilkan error dan warning pada PHP
			error_reporting(0);

			// mengambil data dari page sebelumnya dengan metode POST
			$dokumen = $_POST['dokumen'];

			// insialisasi
			$stopwordremoval_result = array();

			// Nama Kolom Table
			echo "<thead>";
			for($col = 1; $col <= count($dokumen); $col++){
				echo "<th class='font-weight-bold p-3 text-center text-dark'>Dokumen $col</th>";
			}
			echo "</thead>";

			include 'config.php';

			// stopword removal
		  $length = 0;
			for ($row = 1; $row <= count($dokumen); $row++){
				$temp = $dokumen[$row];

				// lowercase
				$temp = strtolower($temp);

				// hapus tanda baca
				$temp = str_replace(',', '', $temp);
				$temp = str_replace('.', '', $temp);
				$temp = str_replace('!', '', $temp);
				$temp = str_replace('?', '', $temp);

				// memecah string menjadi array dengan regex " " (spasi)
				$result =  explode(" ", $temp);

				$final_result = array();
				for($i = 0; $i < count($result); $i++){
					$word = strval($result[$i]);

					// mencari kata di database
					$query = mysqli_query($con, "select word from stopword where word='$word'");
				  if(!mysqli_num_rows($query) > 0){
						// jika ada pada database, $word merupakan stopword
						// jika tidak ada pada database, $word merupakan stopword
						array_push($final_result, $word);
				  }
				}
				// memasukkan data ke $stopwordremoval_result untuk ditampilkan
				$stopwordremoval_result[$row] = array_values($final_result);

				// mengambil length terbesar untuk menampilkan data
				if(count($final_result) > $length){
					$length = count($final_result);
				}
			}

			// menampilkan data
			for ($row = 0; $row < $length; $row++){
				echo "<tr>";
				for ($col = 1; $col <= count($dokumen); $col++){
					try {
						echo "<td class='p-3 text-center'>".strval($stopwordremoval_result[$col][$row])."</td>";
					}
					catch (Exception $e) {

					}
				}
				echo "</tr>";
			}

			echo "</tbody></table>";

			?>
			<a href="index.php" class="btn btn-warning" style="text-decoration:none;">Kembali ke Halaman Utama</a>
	</div>
</body>
</html>
