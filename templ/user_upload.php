<h2>
<?php


  echo "Willkommen ".Controller::getUserName(); //Username

 ?>
</h2>
<h3>Dateien uploaden</h3>

<?php echo $data ?>


<form method="post" action="index.php" enctype="multipart/form-data">
  <input type="hidden" name="upload">
  <input type="file" name="userfile" placeholder="Datei" required><br>
  <input type="submit" value="upload">

</form>
