<?php
  include 'config.php';

  set_time_limit(30000);

  // sumber: https://www.wdb24.com/php-read-text-file-and-insert-into-mysql-database/
  $open = fopen('katadasar.txt','r');

  while (!feof($open)){
    $getTextLine = fgets($open);
    $explodeLine = explode(",",$getTextLine);

    list($kata) = $explodeLine;

    $query = mysqli_query($con, "insert into katadasar (word) values('".$kata."')");
  }

  echo "Input berhasil!";

  fclose($open);
?>
