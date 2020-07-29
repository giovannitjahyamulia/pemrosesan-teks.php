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
		<h1 class="text-dark">Query</h1>
		<table class="table table-hover table-bordered">
			<?php
			// tidak menampilkan error dan warning pada PHP
			error_reporting(0);

			// mengambil data dari page sebelumnya dengan metode POST
			$dokumen = $_POST['dokumen'];
			$isQuery = $_POST['isQuery'];

			// mengubah $isQuery menjadi boolean agar dapat digunakan pada if di bawah
			for ($i = 1; $i <= count($dokumen); $i++){
				if(isset($isQuery[$i])){
					$isQuery[$i] = true;
				}
				else{
					$isQuery[$i] = false;
				}
			}

			// insialisasi
			$N = 0;
			$TP = array();
			$TN = array();
			$FP = array();
			$FN = array();
			$indexing_result = array();
			$total_counter = array();
			$indexing_item = array();

			// Nama Kolom Table
			echo "<thead><tr>";
			echo "<th class='font-weight-bold p-3 text-center text-dark'>Word</th>";
			for($col = 1; $col < count($dokumen); $col++){
				echo "<th class='font-weight-bold p-3 text-center text-dark'>D$col</th>";
			}
			echo "</thead>";


			// indexing, stemming, stopwordsremoval
			$length = 0;
			for ($row = 0; $row <= count($dokumen); $row++){
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

				for($i = 0; $i < count($result); $i++){
					$word = strval($result[$i]);
					$found = false;

					// stemming - menghapus imbuhan
					$querytext = explode(" ", $dokumen[0]);
					include 'config.php';

					$query = mysqli_query($con, "select word from katadasar where word LIKE '%$word%'");
					if(mysqli_num_rows($query) > 0){
						$found = true;
					}
					// awalan
					for($beginindex = 0; $beginindex <= 4; $beginindex++){
						if(!$found){
							$temp_word = substr($word, $beginindex);
							$query = mysqli_query($con, "select word from katadasar where word ='$temp_word'");
							if(mysqli_num_rows($query) > 0){
								$word = $temp_word;
								$pembanding[$i] = $temp_word;
								$found = true;
								break;
							}
						}
					}
					// akhiran
					for($endindex = 0; $endindex <= 3; $endindex++){
						if(!$found){
							$temp_word = substr($word, 0, strlen($word) - $endindex);
							$query = mysqli_query($con, "select word from katadasar where word ='$temp_word'");
							if(mysqli_num_rows($query) > 0){
								$word = $temp_word;
								$pembanding[$i] = $temp_word;
								$found = true;
								break;
							}
						}
					}
					// awalan dan akhiran
					for($beginindex = 0; $beginindex <= 4; $beginindex++){
						for($endindex = 0; $endindex <= 3; $endindex++){
							if(!$found){
								$temp_word = substr($word, $beginindex, strlen($word) - $endindex);
								$query = mysqli_query($con, "select word from katadasar where word ='$temp_word'");
								if(mysqli_num_rows($query) > 0){
									$word = $temp_word;
									$pembanding[$i] = $temp_word;
									$found = true;
									break;
								}
							}
						}
					}
					// stopword removal - menghapus stopword
					$query = mysqli_query($con, "select word from stopword where word='$word'");
					if(!in_array($word, $querytext)){
						if(mysqli_num_rows($query) > 0){
							$word = '';
						}
					}

					$count = 0;

					// indexing - menghitung jumlah kata
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
				ksort($indexing_result[$row]);

				if(count($indexing_result[$row]) > $length){
					$length = count($result);
				}
			}

			// menghitung total jumlah kata, TP, TN, FP, dan FN;
			foreach ($indexing_item as $word){
				$total_counter[$word] = 0;

				$querytext = explode(" ", $dokumen[0]);
				if(in_array($word, $querytext)){
					$TP[$word] = 0;
					$TN[$word] = 0;
					$FP[$word] = 0;
					$FN[$word] = 0;
				}

				echo "<tr>";
				echo "<td class='p-3 text-center'>$word</td>";
				for ($col = 1; $col < count($dokumen); $col++){
					try {
						if(intval($indexing_result[$col][$word]) > 0){
							echo "<td class='p-3 text-center'>".intval($indexing_result[$col][$word])."</td>";
							$total_counter[$word] = intval($total_counter[$word]) + intval($indexing_result[$col][$word]);
							$N = $N + intval($indexing_result[$col][$word]);
							if(in_array($word, $querytext)){
								$FP[$word] = $FP[$word] + intval($indexing_result[$col][$word]);
								if($isQuery[$col]){
									$TP[$word] = $TP[$word] + intval($indexing_result[$col][$word]);
								}
							}
						}
						else{
							echo "<td class='p-3 text-center'>0</td>";
						}
					}
					catch (Exception $e) {

					}
				}
				$FN[$word] = $TP[$word] + $FP[$word];
				$TN[$word] = N - $TP[$word] - $FP[$word] - $FN[$word];
				if($TN[$word] < 0){
					$TN[$word] = 0;
				}
				echo "</tr>";
			}

			echo "</tbody></table>";


			// presisi, recall, f-measure

			// Nama Kolom Table
			echo "<table class='table table-hover table-bordered'>
							<thead>
								<tr>
									<th class='font-weight-bold p-3 text-center text-dark'>Query</th>
									<th class='font-weight-bold p-3 text-center text-dark'>Accuracy</th>
									<th class='font-weight-bold p-3 text-center text-dark'>Presisi</th>
									<th class='font-weight-bold p-3 text-center text-dark'>Recall</th>
									<th class='font-weight-bold p-3 text-center text-dark'>f-Measure</th>
								</tr>
							</thead>
							<tbody>";
			// menghitung dan akurasi, precission, recall, dan f-Measure
			$querytext = explode(" ", $dokumen[0]);
			foreach ($querytext as $word){
				$accuracy = (intval($TP[$word]) + intval($TN[$word])) / (intval($TP[$word]) + intval($TN[$word]) + intval($FP[$word]) + intval($FN[$word]));
				$presisi = intval($TP[$word]) / (intval($TP[$word]) + intval($FP[$word]));
				$recall = intval($TP[$word]) / (intval($TP[$word]) + intval($FN[$word]));
				$fMeasure = (2 * $presisi * $recall) / ($presisi + $recall);

				echo "<tr>
								<td class='text-center'>$word</td>
								<td class='text-center'>".number_format(doubleval($accuracy * 100), 2, '.', '')."%</td>
								<td class='text-center'>".number_format(doubleval($presisi * 100), 2, '.', '')."%</td>
								<td class='text-center'>".number_format(doubleval($recall * 100), 2, '.', '')."%</td>
								<td class='text-center'>".number_format(doubleval($fMeasure * 100), 2, '.', '')."%</td>
							</tr>";
			}
			echo "</tbody></table>";
			?>
			<a href="index.php" class="btn btn-warning" style="text-decoration:none;">Kembali ke Halaman Utama</a>
	</div>
</body>
</html>
