<?php
  include 'config.php';

  set_time_limit(1000);

  // sumber: https://www.wdb24.com/php-read-text-file-and-insert-into-mysql-database/
  $open = fopen('stopword.txt','r');

  while (!feof($open)){
    $getTextLine = fgets($open);
    $explodeLine = explode(",",$getTextLine);

    list($kata) = $explodeLine;

    $query = mysqli_query($con, "insert into stopword (word) values('".$kata."')");
  }
  echo "Input berhasil!";

  fclose($open);
?>
