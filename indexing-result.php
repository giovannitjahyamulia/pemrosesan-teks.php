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
			// tidak menampilkan error pada website
			error_reporting(0);

			// mengambil data dari page sebelumnya dengan metode POST
			$dokumen = $_POST['dokumen'];

			// insialisasi
			$indexing_result = array();
			$total_counter = array();
			$indexing_item = array();

			// nama kolom tabel
			echo "<thead>";
			for($col = 1; $col <= count($dokumen); $col++){
				echo "<th class='font-weight-bold p-3 text-center text-dark'>Dokumen $col</th>";
			}
			echo "<th class='font-weight-bold p-3 text-center text-dark'>Total</th>";

			echo "</thead>";

			// indexing
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

				$pembanding = $result;
				$count = array();

				// menhitung jumlah kata
				for($i = 0; $i < count($result); $i++){
					$word = strval($result[$i]);
					$count = 0;

					if(strlen($word) > 1){
						for($j = 0; $j < count($pembanding); $j++){
							if($word == $pembanding[$j]){
								$count++;
								$pembanding[$j] = '';
								$indexing_result[$row][$word] = $count;
							}
						}
						if(!in_array($word, $indexing_item)){
							array_push($indexing_item, $word);
						}
					}
				}
				// sort berdasarkan key 'word'
				ksort($indexing_result[$row]);

				// mengambil length terpanjang untuk menampilkan data
				if(count($indexing_result[$row]) > $length){
					$length = count($result);
				}
			}

			// menampilkan tabel
			foreach ($indexing_item as $word){
				$total_counter[$word] = 0;
				echo "<tr>";
				for ($col = 1; $col <= count($dokumen) + 1; $col++){
					try {
						// menampilkan total kata yang muncul
						if($col == count($dokumen) + 1){
							echo "<td class='p-3 text-center'>".intval($total_counter[$word])."</td>";
						}
						// menampiklkan jumlah kata yang muncul pada setiap dokumen
						else if(intval($indexing_result[$col][$word]) > 0){
							echo "<td class='p-3 text-center'>$word (".intval($indexing_result[$col][$word]).")</td>";
							$total_counter[$word] = intval($total_counter[$word]) + intval($indexing_result[$col][$word]);
						}
						// menampilkan jumlah kata yang sama dengan 0 sebagai kolom kosong (agar dapat membedakan dengan kata yang ada pada dokumen atau tidak)
						else{
							echo "<td class='p-3 text-center'></td>";
						}
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
