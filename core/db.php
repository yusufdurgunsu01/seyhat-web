<?php
$conn = mysqli_connect("localhost", "root", "", "seyahat_rehberi");
if (!$conn) {
  die("Veritabanına bağlanılamadı: " . mysqli_connect_error());
}
