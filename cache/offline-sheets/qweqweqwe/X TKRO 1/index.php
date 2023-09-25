<?php
$allow=1;
function curPageURL() {
    $pageURL = 'http';

    if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }

    return $pageURL;
}

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">

<!-- CSS Reset -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">

<!-- Milligram CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">

<!-- You should properly set the path from the main file. -->
</head>
<body>
<div class="container">
  <div class="row">
  <div class="column">

<?php
if($allow!==1){
	echo '<h3></h3>';
	echo '<h3>Akses ke halaman unduh soal belum dibuka.</h3>';
}else{
?>
  <h3></h3>
  <h3>Halaman Unduh Soal</h3>
  <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Ketikkan nama anda untuk mencari file...">
  <?php
  echo basename(curPageURL());
  if(basename(curPageURL())=='offline-sheets'){
	  // echo 'aaa';
  }else{
	  echo '<a href="../" class="button">&lArr; Kembali</a>';
  }
  ?>
  
<table id="myTable">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama File</th>
    </tr>
  </thead>
  <tbody>
<?php
// require_once('../../../../shared/config/tce_paths.php');
$path_url = curPageURL();
// echo basename($path_url);
// echo '<br/>';
$path = realpath(dirname(__FILE__));
// echo $path;
// echo '<ol>';
$no=1;
foreach(glob($path.'/*') as $file) {
    // echo basename($file);
	// get_file
	if(basename($file)!='index.php'){
		$dir =  $path.'/'.basename($file);
		if(is_dir($dir)){
			$download = '';
		}else{
			$download = 'download';
		}
		echo '<tr><td>'.$no.'</td><td><a '.$download.' href="'.$path_url.basename($file).'">'.basename($file).'</a></td></tr>';
	}
	$no++;
}
// echo '</ol>';
?>
 </tbody>
</table>
</div>
</div>
</div>
<script>
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
</body>
</html>
<?php
}
?>