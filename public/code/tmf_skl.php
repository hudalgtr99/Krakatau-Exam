<?php
//============================================================+
// File name   : tmf_skl.php
// File path   : public/code/tmf_skl.php
// Begin       : 2021-04-27
// Last Update : 2021-05-04
//
// Description : display SKL
//
// Author: Maman Sulaeman
//
// License:
//    Free and Open Source
//============================================================+


require_once('../../shared/config/tce_config.php');
require_once('../config/tce_config.php');
date_default_timezone_set(K_TIMEZONE);

$currentMonth=date("n"); 
if($currentMonth >=7){$tahun_pelajaran=date('Y').'/'.(date('Y')+1);}else{$tahun_pelajaran=(date('Y')-1).'/'.date('Y');}

/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
/////////////// AWAL KONFIGURASI SKL ////////////////////////////

//tanggal mulai dibukanya SKL
//format pengisian : yyyy-mm-dd jj-mm-dd, contoh: agar halaman SKL bisa dibuka pada tanggal 31 Desember 2021 Pukul 15:00:00, maka isikan: 2021-12-31 15:00:00
$data_date_skl= '2021-05-03 15:00:00'; 

// apabila SKL telah selesai di setting dan siap dipublikasikan, silakan ganti false menjadi true
$siap_publikasi = true;

$jenis_kurikulum = 'Kurikulum 2013 Revisi';

// kop SKL
$kopline1='XZ FOUNDATION INTERNATIONAL';
$kopline2='XAMZONE SCHOOL UNIVERSE';
$kopline3='WONOPRINGGO - PEKALONGAN';
$kopline4='PROVINSI JAWA TENGAH';

// ukuran kopline1 dan seterusnya
$ukuran_kopline1 = '12px';
$ukuran_kopline2 = '18px';
$ukuran_kopline3 = '14px';
$ukuran_kopline4 = '14px';

// spasi atas info alamat sekolah
$spasi_atas_alamat_sekolah = '0px';
$ukuran_bordertebal_atas_alamat = '0px';
$ukuran_bordertebal_bawah_alamat = '3px';
$ukuran_bordertipis_atas_alamat = '0px';
$ukuran_bordertipis_bawah_alamat = '1px';

// info alamat sekolah
$infoline1='Alamat: Kampus Pendidikan Xamzone Universe Wonopringgo - Pekalongan Kode Pos 51181';
$infoline2='Website: xamzonelinux.blogspot.com, Email: xamzone.linux@gmail.com, Telp. +628561575817';

// nama dokumen dan nomor surat
$docname = 'SURAT KETERANGAN LULUS';
$docnumber = 'Nomor: 030/Sk.02/XZSCH/V/2021';

// ucapan
$text_syukur_lulus = 'Selamat';
$text_syukur_lulusbs = 'Selamat';
$text_syukur_gagal = 'Maaf';

// text tampilan
$text_siap = 'Apabila Anda sudah siap untuk melihat pengumuman kelulusan, berdoalah dan tekan tombol SIAP di bawah ini.';
$text_tombol_siap = 'SIAP';
$text_tunggu = 'harap menunggu';

// text keputusan
$text_lulus = 'dinyatakan <b>LULUS</b> dari satuan pendidikan berdasarkan kriteria kelulusan Xamzone School Universe Wonopringgo Kabupaten Pekalongan Tahun Pelajaran '.$tahun_pelajaran;
$text_lulusbs = 'dinyatakan <b>LULUS BERSYARAT</b> dari satuan pendidikan berdasarkan kriteria kelulusan Xamzone School Universe Wonopringgo Kabupaten Pekalongan Tahun Pelajaran '.$tahun_pelajaran;
$text_gagal = 'dinyatakan <b>TIDAK LULUS</b> dari satuan pendidikan berdasarkan kriteria kelulusan Xamzone School Universe Wonopringgo Kabupaten Pekalongan Tahun Pelajaran '.$tahun_pelajaran;
// user level 4 ke atas dinyatakan lulus
// user level 3 dinyatakan lulus bersyarat
// user level 2 dinyatakan tidak lulus

// text inti pada SKL
$text_skl1 = 'Yang bertanda tangan di bawah ini, Kepala Xamzone School Universe (XSU) Wonopringgo Kabupaten Pekalongan, Provinsi Jawa Tengah menerangkan bahwa :';
$text_skl2 = 'Surat Keterangan Lulus ini berlaku sementara sampai dengan diterbitkannya Ijazah Tahun Pelajaran '.$tahun_pelajaran.', untuk menjadikan maklum bagi yang berkepentingan.';

// tempat dan tanggal SKL
$tt_skl = 'Wonopringgo, 17 Mei 2021';

// pejabat penandatangan SKL
$jabatan_ttd_skl = 'Kepala Xamzone School Universe';

// nama pejabat penandatangan SKL
$nama_ttd_skl = 'MAMAN SULAEMAN, S. Kom., M. Kom';

// NIP pejabat penandatangan SKL
$nip_ttd_skl = '-';

// ukuran tanda tangan pejabat
$ukuran_ttd_img = '80px';

// ukuran margin kiri ttd pejabat
$margin_kiri_ttd = '420px';
$margin_atas_ttd = '-55px';
$padding_atas_ttd = '31px';
$padding_bawah_ttd = '6px';


// ukuran margin kiri nama pejabat dan yang sejajar dengannya
$margin_kiri_nm_pejabat = '400px';

// ukuran spasi baris pada SKL
$ukuran_spasi_baris='1.1';

$ukuran_font_global = '14px';
$ukuran_info_alamat = '12px';

$tampilkan_tabel_nilai = true;
// apabila tabel nilai tidak ingin ditampilkan ganti true menjadi false
$ukuran_font_tabel_nilai = '12px';
// padding jarak dari teks ke tepi atas/bawah, cukup isi angka tanpa satuan apapun 
$padding_vertical_font_tabel_nilai = '2';

//jumlah desimal di belakang koma
$decnum = 2;

$tampilkan_tanda_tangan = true;
// apabila tanda tangan tidak ingin ditampilkan ganti true menjadi false

$tampilkan_foto_user = true;
// apabila foto user tidak ingin ditampilkan ganti true menjadi false

// margin dan ukuran foto
$margin_atas = '-30px';
$margin_kiri = '215px';
// lebar / tinggi foto juga bisa menggunakan satuan cm atau px, misal 3cm, 110px
$lebar_foto = '3cm';
$tinggi_foto = '4cm';

$tampilkan_qrcode = true;
// apabila QR Code tidak ingin ditampilkan ganti true menjadi false
// QR Code dipakai sebagai validasi dokumen SKL

/** PENGATURAN NAMA MAPEL
* Isikan semua mapel secara keseluruhan baik yang diterima peserta atau tidak.
* Nanti pada saat pengisian nilai di Excel, mapel yang tidak diterima siswa cukup diberi nilai 0, maka otomatis mapel tersebut tidak ditampilkan pada tabel nilai.
* Ganti nama mapel sesuai dengan yang diinginkan, jumlah total mapel di bawah ini biarkan tetap 30, apabila tidak ingin dipakai cukup biarkan namanya sesuai asalnya
* Untuk memberikan label kelompok mapel, ketikkan nama kelompok mapel diikuti tanda # sebelum nama mapel contoh:
* Kelompok A#Pendidikan Agama dan Budi Pekerti
* contoh di atas adalah memberikan nama mapel yaitu Pendidikan Agama dan Budi Pekerti, ke dalam kelompok A. 
* agar mapel nomor 2 juga masuk ke dalam kelompok A, cukup ketikkan 'Pendidikan Pancasila dan Kewarganegaraan' di bawah nya
* Untuk mapel muatan lokal, cara penulisannya adalah seperti contoh pada array di bawah ini 
**/
$nama_mapel = array(
	'Muatan Nasional#Pendidikan Agama dan Budi Pekerti',
					'Pendidikan Pancasila dan Kewarganegaraan',
					'Bahasa Indonesia',
					'Matematika',
					'Sejarah Indonesia',
					'Bahasa Inggris dan Bahasa Asing lainnya',
	'Muatan Kewilayahan#Seni Budaya',
					   'Penjaskes',
					   '[]Muatan Lokal@a. Mulok 1',
									  'b. Mulok 2',
									  'c. Mulok 3',
	'Muatan Peminatan Kejuruan#Simkomdig',
							  'Fisika',
							  'IPA',
							  'Kimia',
							  'Dasar Program Keahlian',
							  'Kompetensi Keahlian',
	'Mapel 18',
	'Mapel 19',
	'Mapel 20',
	'Mapel 21',
	'Mapel 22',
	'Mapel 23',
	'Mapel 24',
	'Mapel 25',
	'Mapel 26',
	'Mapel 27',
	'Mapel 28',
	'Mapel 29',
	'Mapel 30'
);

// ukuran gambar / logo pada kop SKL
$ukuran_kopimg_atas = '410px';
$ukuran_kopimg_kiri = '66px';
$ukuran_kopimg_kanan = '58px';


// gambar pada kop SKL
// upload gambar yang dibutuhkan pada folder cache/logo

// gambar paling atas pada kop SKL (kosongkan apabila tidak dibutuhkan, seperti contoh di bawah)
// $topimg = '';
$topimg = '';

// gambar sebelah kiri pada kop SKL
$leftimg = '../../cache/logo/xz-logo.png';

// gambar sebelah kanan pada kop SKL (kosongkan apabila tidak dibutuhkan)
// $rightimg='';
$rightimg='../../cache/logo/gounbk-logo.png';

// gambar tanda tangan pejabat
// untuk gambar stempel tidak terpisah, silakan tandatangan diedit terlebih dahulu pada aplikasi lain, lalu gabungkan dengan stempel.
// atau bisa juga dengan cara men-scan tanda tangan yang sudah berstempel
// jangan khawatir, tampilan gambar tandantangan yang berstempel akan tetap di bawah sehingga tidak menutupi nama pejabat atau keterangan lainnya.
$ttd_img='../../cache/logo/ttd-xamzone.png';

// random quote ditampilkan pada saat halaman SKL belum dibuka
$quotes = array(
    "\"Semua pasti berubah, mau tidak mau. Semua pasti berpisah, ingin tidak ingin. Semua pasti berakhir, siap tidak siap.\"",
    "\"Selamat tinggal hanya untuk mereka yang mencintai dengan mata mereka. Karena bagi mereka yang mencintai dengan hati dan jiwa tidak ada yang namanya perpisahan. \" - Rumi",
    "\"Harapanku untukmu adalah agar hidup ini berjalan sesuai keinginanmu. Impianmu tetap besar, kegelisahanmu selalu kecil, dan kau tak akan mendapatkan beban yang melebihi kemampuanmu.\"- Rascal Flatts",
    "\"Perpisahan semanis apapun, seindah apapun, tetaplah perpisahan. Ada cerita yang sejak detik itu harus berubah menjadi kenangan.\"",
    "\"Renungkanlah setiap detik penuh makna, setiap menit diiringi canda tawa, kini waktu telah memisahkan kita. Semoga persahabatan kita selalu terjaga selamanya.\"",
    "\"Ingat aku dengan senyum dan tawa, untuk itulah aku akan mengingatmu. Jika kamu hanya dapat mengingatku dalam kesedihan dan air mata, maka jangan ingat aku sama sekali.\"",
    "\"Kita sudah saling kenal sepanjang hidup kita dan sekarang kita akan berpisah. Beberapa akan mengingat dan beberapa akan saling melupakan, tetapi kita akan selalu memiliki bagian dari satu sama lain di dalam diri kita. \"",
    "\"Sahabat itu seperti bintang, dia memang tidak selalu terlihat. Tapi dia selalu ada untukmu.\"",
    "\"Sahabat ibarat mata dan tangan, saat mata menangis tangan mengusap. Saat tangan terluka mata menangis.\"",
    "\"Sahabat bukan hanya mereka yang telah berada lama disampingmu, tetapi mereka yang telah lama berada dihatimu.\"",
    "\"Good friends never say goodbye. They simply say \"See you soon\"\"",
    "\"This is not goodbye. It`s only the time when we have to close the door to the past to open the door to the future.\"",
    "\"It is not forever, it is not the end. It just means that we`ll soon meet again!\""
);

/////////////// AKHIR KONFIGURASI SKL ////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////

// DATA SKL USER ADMIN
// ini hanyalah data dummy untuk sekedar menguji coba SKL
// data ini bisa juga diisi melalui template Excel dengan mencantumkan username admin pada kolom username
$admin['prodi'] 		= 'Teknik Komputer dan Informatika'; // prodi diisi bila SMK. selain SMK diisi angka 0
$admin['kompetensi']	= 'Teknik Komputer dan Jaringan'; // kompetensi diisi bila SMK. selain SMK diisi angka 0
$admin['peminatan']		= 0; // peminatan diisi bila SMA. selain SMA diisi angka 0
$admin['j_kekhususan']	= 0; // jenis kekhususan diisi bila SMALB, SMPLB, SDLB. selain itu diisi dengan angka 0
$admin['ortu']			= 'Daryono'; // diisi nama orang tua
$admin['nis'] 			= '18.0001'; // diisi nis
$admin['nisn'] 			= '1111111111'; // diisi nisn
$admin['nil1']			= 100; 
$admin['nil2']			= 100;
$admin['nil3']			= 100;
$admin['nil4']			= 100;
$admin['nil5']			= 100;
$admin['nil6']			= 100;
$admin['nil7']			= 100;
$admin['nil8']			= 100;
$admin['nil9']			= 100;
$admin['nil10']			= 100;
$admin['nil11']			= 100;
$admin['nil12']			= 100;
$admin['nil13']			= 100;
$admin['nil14']			= 100;
$admin['nil15']			= 100;
$admin['nil16']			= 100;
$admin['nil17']			= 100;
$admin['nil18']			= 0;
$admin['nil19']			= 0;
$admin['nil20']			= 0;
$admin['nil21']			= 0;
$admin['nil22']			= 0;
$admin['nil23']			= 0;
$admin['nil24']			= 0;
$admin['nil25']			= 0;
$admin['nil26']			= 0;
$admin['nil27']			= 0;
$admin['nil28']			= 0;
$admin['nil29']			= 0;
$admin['nil30']			= 0;

// semua kode pada baris di bawah ini boleh dimodifikasi namun Anda harus memahami segala resiko yang ditimbulkan apabila terjadi kesalahan / error. 
if($tampilkan_tabel_nilai){
	$tabel_nilai_class='class=""';
	$tabel_nilai_classpub='';
	$dot='';
}else{
	$tabel_nilai_class='class="hidden"';
	$tabel_nilai_classpub='hidden';
	$dot='.';
}
$tglskl=$data_date_skl;
$tgl_skl=strtotime($tglskl);
if(time() < $tgl_skl){
    //echo date("H:i:s");
    echo '<!DOCTYPE html><html lang="en"><head>';
	echo '<link rel="stylesheet" href="'.K_SITE_STYLE.'">';
	echo '<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
echo "<style>
body {
	text-align:center; 
	background-color: var(--col-1);
	padding:1rem;
}
.quote {font-style: italic;
    color: var(--col-7);
    background: rgba(0,0,0,0.05);
    display: inline-block;
    padding: 5px 10px;
    border-radius: 5px;
	margin:10px 0 50px 0}
h3 #demo span{margin:10px 5px}
h3 #demo span:last-child{background:var(--col-7)}

</style>
</head>
<body>
<span style='color:var(--col-12);font-size:100px;display:inline-block;margin:50px 0' class='icon-warning'></span><br/><h1 style='padding:0;color:var(--col-7)'>Akses ke halaman pengambilan SKL akan dibuka setelah</h1><h3 style='line-height:1.5;color:#ffeb3b;padding:0;margin:0'><span id='demo'>";

    echo '</span></h3><p style="color:#B0BEC5"><span class="quote">'.$quotes[array_rand($quotes)].'<br/>&mdash; &#9675; &mdash;</span></p><p style="color:var(--col-4);padding-bottom:20px">Presented by<br/><b>'.K_SITE_AUTHOR.'</b><br/>Copyright &copy; '.date('Y').'</p>';
    ?>

    <script>
// Set the date we're counting down to
var countDownDate = new Date("<?php echo date("F", strtotime($data_date_skl)); ?> <?php echo date("d", strtotime($data_date_skl)); ?>, <?php echo date("Y", strtotime($data_date_skl)); ?> <?php echo date("H:i:s", strtotime($data_date_skl)); ?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  if(days == 0){
	var hidedays = "style='display:none'";
	if(hours == 0){
		var hidehours = "style='display:none'";
		if(minutes == 0){
			var hidemin = "style='display:none'";
		}
	}
  }



  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML = "<span class='xmlbutton' "+hidedays+">"+ days + " hari</span><span class='xmlbutton' "+hidehours+">" + hours + " jam</span><span class='xmlbutton' "+hidemin+">"
  + minutes + " menit</span><span class='xmlbutton'>" + seconds + " detik</span>";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "<span class='xmlbutton'>tunggu sebentar</span>";
    location.reload();
  }
}, 1000);
</script>

    <?php
    echo "</body>";
    die();
}

require_once('../config/tce_config.php');
if(isset($_REQUEST['id']) and $_REQUEST['id']!=null){
	$pagelevel = 0;
}else{
	$pagelevel = K_AUTH_PUBLIC_TEST_EXECUTE;
}
$thispage_title = "Surat Keterangan Lulus";
$thispage_description = $l['hp_test_execute'];
require_once('../../shared/code/tce_authorization.php');
require_once('../../shared/code/tce_functions_form.php');
require_once('../../shared/code/tce_functions_test.php');
require_once('../code/tce_page_header.php');
?>
<style>
#skl{font-size:<?php echo $ukuran_font_global; ?>}

.break {line-height:0.3;display:block}
table {border-collapse: collapse; width:100%}
td, th {padding: 0px 10px}
.center {text-align:center}
div#alamat_skl span{font-size:<?php echo $ukuran_info_alamat; ?>}
.splbl_skl {width: 240px; display: inline-block}
.shadow_skl {box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.5); padding:30px 30px 30px 30px}
<?php

if($siap_publikasi){
	echo 'div#skl.shadow_skl{display:none}';
}
?>
<?php
if($siap_publikasi){
	echo 'div#hamdalah{'.K_NEWLINE;
    echo 'position: relative;'.K_NEWLINE;
    echo 'top: -700px;'.K_NEWLINE;
	echo '}'.K_NEWLINE;
}
?>

.img_user{
	margin-top:<?php echo $margin_atas; ?>;
	margin-left:<?php echo $margin_kiri; ?>;
	position:absolute;
	z-index:1;
	padding:0px;
	width:<?php echo $lebar_foto; ?> !important;
	height:<?php echo $tinggi_foto; ?> !important;
}
 
.ttd_skl {
    margin-left: <?php echo $margin_kiri_ttd; ?>;
    position: relative;
    top: <?php echo $margin_atas_ttd; ?>;
    z-index: 1;
    padding: <?php echo $padding_atas_ttd; ?> 0 <?php echo $padding_bawah_ttd; ?> 0;
    height: <?php echo $ukuran_ttd_img; ?>;
}
.print_skl {/**width: 734px;**/ margin:0 auto; margin-bottom: 10px}

.subcont {padding:10px 30px 20px 30px; background: #fff; border-radius:0 0 5px 5px; border:1px solid var(--bor-col1)!important}
div#qrcode {position:absolute}
div#qrcode img {width:137px}
.spvalue {color:#fff; border-radius: 5px; padding:5px 13px; display:inline-block}
.red {background: #f44336}
.blue {background: #336799}
.green {background: #009688}
.purple {background: #9c27b0}
.orange {background: #ff9800}
.fuchsia {background: #e91e63}

#table_nilai td {
    font-size: <?php echo $ukuran_font_tabel_nilai; ?>;
    padding-top: <?php echo $padding_vertical_font_tabel_nilai; ?>px;
    padding-bottom: <?php echo $padding_vertical_font_tabel_nilai+2; ?>px;
}

@media print {
    div#skl.shadow_skl {display:block}
	div.print_skl, div.header, div.footer {display: none}
	div.body {background-color: #ffffff; padding:0px; margin:0px; width:100%}
	body {background-color: #fff}
	.shadow_skl {box-shadow: 0 0 0 0 rgba(0,0,0,0); padding: 20px 0px 0px 0px !important}
	div.scrollmenu ul {display:none}
	#nm_ks, #nip_ks {top:-64px !important}
	div#menuShow{display:none}
	.print_skl {width: 734px}
}
</style>
<?php
$base64id=base64_encode("SKL ".K_INSTITUTION_NAME.", ".$_SESSION['session_user_id']);
$url = K_PATH_HOST.K_PATH_TCEXAM."public/code/tmf_skl.php?id=".$base64id;
// echo $url;
require_once('../../shared/tcpdf/tcpdf_barcodes_2d_tmf_skl.php');
$qrcode = new TCPDF2DBarcode($url, 'QRCODE,H');

$userskldata = array();
$sqlusrdata = 'SELECT user_birthdate,user_birthplace,user_ssn FROM '.K_TABLE_USERS.' WHERE user_id='.$_SESSION['session_user_id'].' LIMIT 1';
if ($r = F_db_query($sqlusrdata, $db)) {
        while ($m = F_db_fetch_array($r)) {
			$userskldata['user_birthdate']=$m['user_birthdate'];
			$userskldata['user_birthplace']=$m['user_birthplace'];
			$userskldata['user_ssn']=$m['user_ssn'];
		}
}else {
	F_display_db_error();
}

// var_dump($userskldata);

if(($siap_publikasi==false)and($_SESSION['session_user_level']<10)){
	echo '<div class="container">'.K_NEWLINE;
	echo '<div class="subcont" id="bismillahbox">SKL belum dipublikasikan. <a href="index.php" class="xmlbutton">Klik disini</a> untuk kembali ke beranda.</div>'.K_NEWLINE;
	echo '</div>'.K_NEWLINE;
	die();
}

echo '<div class="container" style="line-height:'.$ukuran_spasi_baris.'">'.K_NEWLINE;
echo '<div class="x-scrollable" style="overflow-x:auto; padding-bottom:10px">'.K_NEWLINE;
echo '<div class="print_skl">
<div class="subcont" id="bismillahbox">'.K_NEWLINE;

// echo $_SESSION['session_user_id'];
if((strlen($userskldata['user_ssn'])<1) and ($_SESSION['session_user_id']==2)){
	// $sqlu = 'UPDATE '.K_TABLE_USERS.' SET user_ssn="Teknik Komputer dan Informatika,Teknik Komputer dan Jaringan,Daryono,18.0001,1111111111,0,0,80.50,80.51,80.52,80.53,80.54,80.55,80.56,80.57,80.58,80.59,80.60,80.61,80.62,80.63,81.64,80.65,75,0,0,0,0,0,0,0,0,0,0,0,0,0" WHERE user_id=2';
	
	// F_db_query($sqlu, $db);
	
	$userskldata['user_ssn']=$admin['prodi'].','.$admin['kompetensi'].','.$admin['ortu'].','.$admin['nis'].','.$admin['nisn'].','.$admin['peminatan'].','.$admin['j_kekhususan'].','.$admin['nil1'].','.$admin['nil2'].','.$admin['nil3'].','.$admin['nil4'].','.$admin['nil5'].','.$admin['nil6'].','.$admin['nil7'].','.$admin['nil8'].','.$admin['nil9'].','.$admin['nil10'].','.$admin['nil11'].','.$admin['nil12'].','.$admin['nil13'].','.$admin['nil14'].','.$admin['nil15'].','.$admin['nil16'].','.$admin['nil17'].','.$admin['nil18'].','.$admin['nil19'].','.$admin['nil20'].','.$admin['nil21'].','.$admin['nil22'].','.$admin['nil23'].','.$admin['nil24'].','.$admin['nil25'].','.$admin['nil26'].','.$admin['nil27'].','.$admin['nil28'].','.$admin['nil29'].','.$admin['nil30'];
}

if(isset($_REQUEST['id']) and $_REQUEST['id']!=null){
	echo '<style>
		table.testlist tr td, table.userselect tr td{height:auto}
		table.testlist tr td{width:auto;vertical-align:top}
		tbody tr td:nth-child(2){text-align:left}
		div.header{display:none !important}
	</style>'.K_NEWLINE;
	echo '<div style="line-height:1.5">'.K_NEWLINE;
	$id=base64_decode($_REQUEST['id']);

	$str_arr = preg_split ("/\,/", $id);
	$teks1 = $str_arr[0];
	$user_id = $str_arr[1];

	$sqlsu = 'SELECT * FROM '.K_TABLE_USERS.' WHERE user_id='.$user_id.' LIMIT 1';
	if($r = F_db_query($sqlsu, $db)){
		if ($m = F_db_fetch_array($r)){
			echo '<div style="background-image:url(\'../../images/'.K_INSTITUTION_LOGO.'\'); background-repeat: no-repeat; background-position:right top; opacity:0.2; width:202px; height:224px; display: inline-block; position: absolute; background-size: 202px; right: 60px"></div>'.K_NEWLINE;
			echo '<h3 style="padding: 0 0 0.5em 0;border-bottom: 1px solid #336799;color: var(--col-2)"><span class="icon-star"></span> SKL VALID</h3>'.K_NEWLINE;
			echo '<p>Surat Keterangan Lulus ini didapatkan secara sah dari laman resmi pengambilan SKL '.K_INSTITUTION_NAME.' dengan rincian data sebagai berikut :</p>'.K_NEWLINE;
			// echo "<span class='splbl_skl'>Nomor Peserta </span>: <span class='spvalue blue'>".$m['user_name']."</span><br/><br/>";
			echo "<div class='d-flex jc-sb fwrap'>";
			echo "<div>";
			echo "<span class='splbl_skl'>Nama Lengkap </span>: <span class='spvalue fuchsia'>".$m['user_firstname']."</span><br/><br/>";

			$user_birthdate = date("j F Y", strtotime($m['user_birthdate']));
			$user_birthdate = str_replace('January', 'Januari', $user_birthdate);
			$user_birthdate = str_replace('February', 'Februari', $user_birthdate);
			$user_birthdate = str_replace('March', 'Maret', $user_birthdate);
			$user_birthdate = str_replace('May', 'Mei', $user_birthdate);
			$user_birthdate = str_replace('June', 'Juni', $user_birthdate);
			$user_birthdate = str_replace('July', 'Juli', $user_birthdate);
			$user_birthdate = str_replace('August', 'Agustus', $user_birthdate);
			$user_birthdate = str_replace('October', 'Oktober', $user_birthdate);
			$user_birthdate = str_replace('December', 'Desember', $user_birthdate);

			echo "<span class='splbl_skl'>Tempat, Tanggal Lahir </span>: <span class='spvalue green'>".$m['user_birthplace'].", ".$user_birthdate."</span><br/><br/>";

			$c_array = urldecode($m['user_ssn']);
			// print_r($c_arraysss);
			// ssssssssss
			// $c_array = str_replace('%2C', ',', $m['user_lastname']);
			// $c_array = str_replace('+', ' ', $c_array);
			$str_arr = preg_split ("/\,/", $c_array);

			$nis = $str_arr[3];
			$nisn = $str_arr[4];

			echo "<span class='splbl_skl'>NIS / NISN </span>: <span class='spvalue purple'>".$nis." / ".$nisn."</span><br/><br/>";
			if((strlen($str_arr[0])>1) or ($str_arr[0]!=0)){
				echo "<span class='splbl_skl'>Program Studi Keahlian </span>: <span class='spvalue orange'>".$str_arr[0]."</span><br/><br/>";
			}
			if((strlen($str_arr[1])>1) or ($str_arr[1]!=0)){
				echo "<span class='splbl_skl'>Kompetensi Keahlian </span>: <span class='spvalue red'>".$str_arr[1]."</span><br/><br/>";
			}
			if((strlen($str_arr[5])>1) or ($str_arr[5]!=0)){
				echo "<span class='splbl_skl'>Peminatan </span>: <span class='spvalue red'>".$str_arr[5]."</span><br/><br/>";
			}
			if((strlen($str_arr[6])>1) or ($str_arr[6]!=0)){
				echo "<span class='splbl_skl'>Jenis Kekhususan </span>: <span class='spvalue red'>".$str_arr[6]."</span><br/>";
			}
			//$ortu = str_replace("%27", " '", $str_arr[1]);
			echo "</div>".K_NEWLINE;
			// echo "</div>".K_NEWLINE;
			echo "<div style='align-self:start'>";
			
			if(@file_get_contents(K_PATH_CACHE.'photo/'.$m['user_name'].'.jpg')){
				$userphoto = $m['user_name'];
			}else{
				$userphoto = 'default';
			}

			echo "<img src='../../cache/photo/".$userphoto.".jpg'>";
			echo "</div>".K_NEWLINE;
			echo "</div>".K_NEWLINE;
			echo "<br/>";
			// echo 'xxx'.$str_arr[7];
			
			$mapel = array();
			$i=0;
			foreach ($nama_mapel as $datamapel){
				if($str_arr[7+$i]!=0){
					$mapel[] = array($datamapel,$str_arr[7+$i]);
				}
				$i++;
			}
			
			
			
			echo '<span class="splbl_skl '.$tabel_nilai_classpub.'">Data perolehan nilai </span><span class="'.$tabel_nilai_classpub.'">:</span>';			
			echo '<table class="testlist mt-10 '.$tabel_nilai_classpub.'">';
			echo '<tr style="border-bottom:3px solid #336799"><th width="25px">No</th><th>Nama Mata Pelajaran</th><th width="60px">Nilai</th></tr>';
			
			$no=1;
			$sum_nil=array();
			/* foreach ($mapel as $data){
				$sum_nil[]=$data[1];
				echo '<tr><td class="center">'.$no++.'</td><td>'.$data[0].'</td><td class="center">'.number_format($data[1],$decnum,',','.').'</td></tr>';
			} */
			foreach ($mapel as $data){
			$sum_nil[]=$data[1];
			if(strpos($data[0],'#')){
				$xxx = preg_split ("/\#/", $data[0]);
				$data[0] = strstr($data[0], '#');
				$data[0] = str_replace('#','',$data[0]);
				$newtr = '<tr style="text-align: left;background: var(--col-4);color: #fff;"><td colspan="2" class="ft-bold">'.$xxx[0].'</td><td></td></tr>';
			}else{
				$xxx = array('','');
				$newtr = '';
			}
			
			if(strpos($data[0],'@')){
				$yyy = preg_split ("/\@/", $data[0]);
				$data[0] = strstr($data[0], '@');
				$data[0] = str_replace('@','',$data[0]);
				
				if(strpos($yyy[0],']')){
					$aaa = preg_split ("/\]/", $yyy[0]);
					$yyy[0] = strstr($yyy[0], ']');
					$yyy[0] = str_replace(']','',$yyy[0]);
					$newtr2 = '<tr><td class="ta-center">'.$aaa[0].'</td><td>'.$yyy[0].'</td><td></td></tr>';
				}else{
					$newtr2 = array('','');
				}	
			}else{
				$yyy = array('','');
				$newtr2 = '';
			}
			
			if(strpos($data[0],']')){
				$zzz = preg_split ("/\]/", $data[0]);
				$data[0] = strstr($data[0], ']');
				$data[0] = str_replace(']','',$data[0]);
			}else{
				$zzz = array('','');
			}
			
			$no++;
			echo $newtr2.$newtr.'<tr><td class="ta-center">'.$zzz[0].'</td><td>'.$data[0].'</td><td class="center">'.number_format($data[1],0,',','.').'</td></tr>';
		}
			
			echo '<tr class="ft-bold ta-center" style="background:var(--col-1) !important;color:var(--col-7)"><td colspan=2>RATA-RATA</td><td class="ta-center ft-bold">'.number_format(array_sum($sum_nil)/($no-1),$decnum,',','.').'</td></tr>';
			echo '</table>';
			
		}else{
			echo '<h3 style="text-align:center; color:#f44336"><span class="icon-warning"></span> <br/><br/>SKL TIDAK VALID !!!</h3>'.K_NEWLINE;
		}
	}else{
		echo '<h3 style="text-align:center; color:#f44336"><span class="icon-warning"></span> <br/><br/>SKL TIDAK VALID !!!</h3>'.K_NEWLINE;
	}
	//echo '</div>'.K_NEWLINE;
	die();
}

if($_SESSION['session_user_level']<2){
	?>
	<script>window.location.replace("index.php");</script>
	<?php
}

if(strlen($userskldata['user_ssn'])<1){
	echo 'Data SKL untuk <strong>'.$_SESSION['session_user_firstname'].'</strong> belum disiapkan. Silakan import data user terlebih dahulu menggunakan template yang telah disediakan. <a href="index.php" class="xmlbutton">Klik disini</a> untuk kembali ke beranda.';
	die();
}

echo '<p>'.$text_siap.'</p>
<a href="#" id="bismillah" class="xmlbutton">'.$text_tombol_siap.'</a><br/>
</div>
'.K_NEWLINE;

// echo date("F", strtotime("04"));
// date("j F Y", strtotime($str_arr[2])
$firstname = urldecode($_SESSION['session_user_firstname']);
// $firstname = str_replace("+"," ", $_SESSION['session_user_firstname']);
// $firstname = str_replace("%27"," '", $firstname);

if($_SESSION['session_user_level']>=4){
	$text_keputusan = $text_lulus;
	$textclass='';
	$text_syukur=$text_syukur_lulus;
}elseif($_SESSION['session_user_level']==3){
	$text_keputusan = $text_lulusbs;
	$textclass='';
	$text_syukur=$text_syukur_lulusbs;
}elseif($_SESSION['session_user_level']==2){
	$text_keputusan = $text_gagal;
	$textclass='hidden';
	$text_syukur=$text_syukur_gagal;
}

echo '<div class="subcont" id="hamdalah"><p><b>'.$text_syukur.'</b>, <br/>'.$firstname.', Anda '.$text_keputusan.'.<br/><br/><span class="'.$textclass.'" style="background:var(--col-4t);display: inline-block;padding: 1em;border-radius: 5px;border-left: 3px solid var(--col-4)">Anda bisa mencetak tanda bukti kelulusan dengan menekan tombol Print / PDF di bawah ini. Apabila tombol tersebut tidak berfungsi pada perangkat handphone / smartphone, silakan tekan menu setting pada browser Anda, tekan Share / Bagikan, kemudian tekan menu Cetak / Print.</span></p>
<a class="'.$textclass.' xmlbutton" href="#" id="print_skl" class="xmlbutton">Print / Cetak</a>&nbsp;<a class="'.$textclass.' xmlbutton" href="#" id="unduh_skl" class="xmlbutton">Unduh PDF</a></div></div>'.K_NEWLINE;

echo '<div id="skl" class="shadow_skl" style="line-height:'.$ukuran_spasi_baris.'; background:#ffffff; width:669px; height:auto; margin: 0 auto">'.K_NEWLINE;
//echo $_SESSION['session_user_name'].K_NEWLINE;

if(strlen($topimg)>0){
	$topimg_class = '';
}else{
	$topimg_class = 'class="hidden"';
}
if(strlen($rightimg)>0){
	$rightimg_class = '';
}else{
	$rightimg_class = 'class="hidden"';
}
echo "<center ".$topimg_class.">
<div style='width:100%; display:inline-block'><img ".$topimg_class." width='".$ukuran_kopimg_atas."' src='".$topimg."' /></div>
</center>".K_NEWLINE;
echo "<div style='margin: 0 0 ".$spasi_atas_alamat_sekolah." 0;display: flex;justify-content: space-between;align-items: center;text-align: center'><div style='width:".$ukuran_kopimg_kiri."; display:inline-block'><img src='".$leftimg."' /></div>
<div style='font-weight:bold; width:275px; display:inline-block'><span style='font-size:".$ukuran_kopline1."'>".$kopline1."</span><br/><span style='font-size:".$ukuran_kopline2."'>".$kopline2."</span><br/><span style='font-size:".$ukuran_kopline3."'>".$kopline3."</span><br/><span style='font-size:".$ukuran_kopline4."'>".$kopline4."</span></div>
<div style='width:".$ukuran_kopimg_kanan."; display:inline-block'><img ".$rightimg_class." src='".$rightimg."' /></div>
</div>".K_NEWLINE;

echo "<center><div id='alamat_skl' style='border-top: ".$ukuran_bordertebal_atas_alamat." solid #000000; border-bottom: ".$ukuran_bordertebal_bawah_alamat." solid #333333'><span style='width:100%; display:inline-block;margin-top:1px;padding-top:3px; border-top:".$ukuran_bordertipis_atas_alamat." solid #333'>".$infoline1."</span><br/><span style='width:100%; display:inline-block;margin-bottom:1px;padding-bottom:3px; border-bottom: ".$ukuran_bordertipis_bawah_alamat." solid #333'>".$infoline2."</span></div></center><br/>".K_NEWLINE;
echo "<center><b>".$docname."</b></center>".K_NEWLINE;
echo "<center><b>".strtoupper(K_INSTITUTION_NAME)."</b></center>";

$c_array = urldecode($userskldata['user_ssn']);
$str_arr = preg_split ("/\,/", $c_array);
if((strlen($str_arr[0])>1) or ($str_arr[0]!=0)){
	echo "<center style='text-transform:uppercase'><b>PROGRAM STUDI KEAHLIAN : ".$str_arr[0]."</b></center>";
}
if((strlen($str_arr[1])>1) or ($str_arr[1]!=0)){
	echo "<center style='text-transform:uppercase'><b>KOMPETENSI KEAHLIAN : ".$str_arr[1]."</b></center>";
}
if((strlen($str_arr[5])>1) or ($str_arr[5]!=0)){
	echo "<center style='text-transform:uppercase'><b>PEMINATAN : ".$str_arr[5]."</b></center>";
}
if((strlen($str_arr[6])>1) or ($str_arr[6]!=0)){
	echo "<center style='text-transform:uppercase'><b>JENIS KEKHUSUSAN : ".$str_arr[6]."</b></center>";
}

echo "<center><b>TAHUN PELAJARAN ".$tahun_pelajaran."</b><br/><br/>".$docnumber."<br/><br/></center>";

echo $text_skl1.K_NEWLINE;
echo "<span class='break'>&nbsp;</span>";
echo "<span class='break'>&nbsp;</span>";

echo "<span class='splbl_skl'>Nama </span>: <span style='text-transform:uppercase'>".$firstname."</span><br/>".K_NEWLINE;
// $user_birthdate = date("j F Y", strtotime($str_arr[2]);
// echo $str_arr[2];
// echo '<br/>';
$user_birthdate = date("j F Y", strtotime($userskldata['user_birthdate']));
// $user_birthdate = date("Y-m-d", strtotime("2005-12-31"));
$user_birthdate = str_replace('January', 'Januari', $user_birthdate);
$user_birthdate = str_replace('February', 'Februari', $user_birthdate);
$user_birthdate = str_replace('March', 'Maret', $user_birthdate);
$user_birthdate = str_replace('May', 'Mei', $user_birthdate);
$user_birthdate = str_replace('June', 'Juni', $user_birthdate);
$user_birthdate = str_replace('July', 'Juli', $user_birthdate);
$user_birthdate = str_replace('August', 'Agustus', $user_birthdate);
$user_birthdate = str_replace('October', 'Oktober', $user_birthdate);
$user_birthdate = str_replace('December', 'Desember', $user_birthdate);
echo "<span class='splbl_skl'>Tempat dan Tanggal Lahir </span>: ".$userskldata['user_birthplace'].", ".$user_birthdate."<br/>".K_NEWLINE;

// $c_array = urldecode($_SESSION['session_user_lastname']);
// $c_array = str_replace('%2C', ',', $_SESSION['session_user_lastname']);
// $c_array = str_replace('+', ' ', $c_array);
// $str_arr = preg_split ("/\,/", $c_array);

$nis = $str_arr[3];
$nisn = $str_arr[4];
$ortu = urldecode($str_arr[2]);

$mapel = array();
$i=0;
foreach ($nama_mapel as $datamapel){
	if($str_arr[7+$i]!=0){
		$mapel[] = array($datamapel,$str_arr[7+$i]);
	}
	$i++;
} 

echo "<span class='splbl_skl'>Nama Orang Tua / Wali </span>: ".$ortu."<br/>".K_NEWLINE;
echo "<span class='splbl_skl'>Nomor Induk Siswa </span>: ".$nis."<br/>".K_NEWLINE;
echo "<span class='splbl_skl'>Nomor Induk Siswa Nasional </span>: ".$nisn.K_NEWLINE;
echo "<span class='break'>&nbsp;</span>";
echo "<span class='break'>&nbsp;</span>";

echo '<div style="margin-bottom:5px">'.$text_keputusan.$dot.'<span '.$tabel_nilai_class.'>, dengan nilai sebagai berikut :</span></div>'.K_NEWLINE;

?>
<table id="table_nilai" cellspacing="0" style="border-collapse: collapse; border:2px solid" <?php echo $tabel_nilai_class; ?>>
<!--tr style="border-bottom:2px solid"><th width="25px">No</th><th>Nama Mata Pelajaran</th><th width="60px">Nilai</th></tr-->
<tr><th style="border-right:0.1px solid black" width="25px">No</th><th style="border-right:0.1px solid black;padding:5px">Mata Pelajaran<br/><?php echo '( '.$jenis_kurikulum.' )'; ?></th><th width="95px">Nilai Ujian Sekolah</th></tr>
<?php
$on=1;
$no=1;
$sum_nil=array();
foreach ($mapel as $data){
	$sum_nil[]=$data[1];
	if(strpos($data[0],'#')){
		$no=0;
		$xxx = preg_split ("/\#/", $data[0]);
		$data[0] = strstr($data[0], '#');
		$data[0] = str_replace('#','',$data[0]);
		$newtr = '<tr><td style="border-top:0.1px solid black; border-right:0.1px solid black" colspan="2" class="ft-bold">'.$xxx[0].'</td><td style="border-top:0.1px solid black"></td></tr>';
	}else{
		$xxx = array('','');
		$newtr = '';
	}
	
	if(strpos($data[0],'@')){
		$yyy = preg_split ("/\@/", $data[0]);
		$data[0] = strstr($data[0], '@');
		$data[0] = str_replace('@','',$data[0]);
		
		if(strpos($yyy[0],']')){
			$aaa = preg_split ("/\]/", $yyy[0]);
			$yyy[0] = strstr($yyy[0], ']');
			$yyy[0] = str_replace(']','',$yyy[0]);
			$newtr2 = '<tr><td style="border-top:0.1px solid black; border-right:0.1px solid black" class="ta-center">'.($no+1).'</td><td style="border-top:0.1px solid black; border-right:0.1px solid black">'.$yyy[0].'</td><td style="border-top:0.1px solid black"></td></tr>';
			// break;
			$no=-100;
			if($no<0){
				$no='<span class="hidden">xxx</span>';
			}
		}else{
			$newtr2 = array('','');
		}	
	}else{
		$yyy = array('','');
		$newtr2 = '';
	}
	
	if(strpos($data[0],']')){
		$zzz = preg_split ("/\]/", $data[0]);
		$data[0] = strstr($data[0], ']');
		$data[0] = str_replace(']','',$data[0]);
	}else{
		$zzz = array('','');
	}
	
	$no++;
	$on++;
	echo $newtr2.$newtr.'<tr><td style="border-top:0.1px solid black; border-right:0.1px solid black" class="ta-center">'.$no.'</td><td style="border-top:0.1px solid black; border-right:0.1px solid black">'.$data[0].'</td><td style="border-top:0.1px solid black" class="center">'.number_format($data[1],0,',','.').'</td></tr>';
}
?>
<tr><th style="border-top:0.1px solid black; border-right:0.1px solid black" colspan=2>RATA-RATA</th><td style="border-top:0.1px solid black" class="center ft-bold"><?php echo number_format(array_sum($sum_nil)/($on-1),$decnum,',','.'); ?></td></tr>
</table>
<?php
echo "<span class='break'>&nbsp;</span>";
echo $text_skl2."<br/><br/>".K_NEWLINE;
//echo "<span style='margin-left:445px'>Wonopringgo, 2 Mei 2020</span>".K_NEWLINE;

if($tampilkan_qrcode){
	$qrcode_class='';
}else{
	$qrcode_class='hidden';
}
echo "<div id='qrcode' class='".$qrcode_class."'>";
//echo $qrcode->getBarcodeHTML(2, 2, 'black');
//echo '<img src="data:image/png;base64, '.base64_decode($qrcode->getBarcodePNGNoHeader(3, 3, array(0,0,0))).'" />';
//imagepng(imagecreatefrompng($qrcode->getBarcodePNGNoHeader(3, 3, array(0,0,0))));
$qrcodePNG = $qrcode->getBarcodePNGNoHeader(3, 3, array(0,0,0));
echo '<img id="qrcodePNG" src="data:image/png;base64, '.base64_encode($qrcodePNG).'" />';
echo "</div>";

echo "<span style='margin-left:".$margin_kiri_nm_pejabat."; position:relative; z-index: 9'>".$tt_skl."</span>".K_NEWLINE;
//echo "<span style='margin-left:445px'>Kepala SMK Gondang</span><br/>".K_NEWLINE;
echo "<span style='margin-left:".$margin_kiri_nm_pejabat."; position:relative; z-index: 9'>".$jabatan_ttd_skl."</span><br/>".K_NEWLINE;
if($tampilkan_tanda_tangan){
	$stylettd='';
}else{
	$stylettd='style="visibility:hidden"';
}

if($tampilkan_foto_user){
	$stylefoto='';
}else{
	$stylefoto='style="visibility:hidden;display:none"';
}

if(@file_get_contents(K_PATH_CACHE.'photo/'.$_SESSION['session_user_name'].'.jpg')){
	$userphoto = $_SESSION['session_user_name'];
}else{
	$userphoto = 'default';
}
echo "<img ".$stylefoto." class='img_user' src='../../cache/photo/".$userphoto.".jpg' /><br/>";
echo "<img ".$stylettd." class='ttd_skl' src='".$ttd_img."' /><br/>";
echo "<span id='nm_ks' style='position:relative; margin-left:".$margin_kiri_nm_pejabat."; font-weight: bold; text-decoration:underline; display:inline-block; top: -64px; z-index:9'>".$nama_ttd_skl."</span>".K_NEWLINE;
echo "<span id='nip_ks' style='position:relative; margin-left:".$margin_kiri_nm_pejabat."; font-weight: bold; text-decoration:none; display:inline-block; top: -64px; z-index:9'>NIP. ".$nip_ttd_skl."</span>".K_NEWLINE;


echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

//echo '<p>Scan QR-Codes di bawah ini untuk memeriksa keabsahan SKL ini</p>'.K_NEWLINE;
// comma separated list of user's groups
$grp = '';
$sqlg = 'SELECT *
	FROM '.K_TABLE_GROUPS.', '.K_TABLE_USERGROUP.'
	WHERE usrgrp_group_id=group_id
		AND usrgrp_user_id='.$_SESSION['session_user_id'].'
	ORDER BY group_name';
if ($rg = F_db_query($sqlg, $db)) {
	while ($mg = F_db_fetch_array($rg)) {
		$grp .= $mg['group_name'].', ';
	}
} else {
	F_display_db_error();
}

$grp = rtrim($grp, ', ');
// echo $grp;


require_once('../code/tce_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
?>
<script src="../../shared/jscripts/html2pdf.bundle.min.js"></script>
<script>
	const thispage_title = "<?php echo $thispage_title; ?>"
	const firstname = "<?php echo $firstname; ?>"
	const groups = "<?php echo $grp; ?>"
	
	var element = document.getElementById('skl');
	var opt = {
	  margin:       0,
	  filename:     thispage_title+'-'+firstname+'-'+groups+'.pdf',
	  image:        { type: 'jpeg', quality: 1 },
	  html2canvas:  { scale: 4 },
	  jsPDF:        { unit:'in', format:[8.2, 13], orientation:'portrait' }
	};

	// New Promise-based usage:
	function unduhPDF(){
		backdrop("1","1");
		document.getElementById("backdrop").style.background = 'black';
		element.style.display = 'block';
		html2pdf().set(opt).from(element).save().then(function(){
			element.style.display = 'none';
			backdrop("0","1");
			document.getElementById("backdrop").style.background = 'rgba(0,0,0,.5)';
			document.body.removeAttribute("style");
		});
		// html2pdf(element, opt);
		// element.style.display = 'none';
	}
	
	
</script>
<script>
	function xyz(){
		this.innerHTML="<div style='display:flex'><div class='anim-rotate'><span class='icon-spinner11'></span></div><span style='margin-left:1em'><?php echo $text_tunggu; ?></span></div>";
		setTimeout(function(){
			document.getElementById("bismillahbox").style.display = "none";
			document.getElementById("hamdalah").style.top = "0px";
		},3000);
	}
	function printSKL(){
		document.getElementById("skl").setAttribute("style","line-height: <?php echo $ukuran_spasi_baris; ?>;background: rgb(255, 255, 255);width: 669px;height: auto;margin: 0px auto;");
		window.print();
	}
	document.getElementById("unduh_skl").addEventListener("click", unduhPDF);
	document.getElementById("bismillah").addEventListener("click", xyz);
	document.getElementById("print_skl").addEventListener("click", printSKL);
	document.querySelector("title").textContent = thispage_title+" - "+firstname+" - "+groups;
</script>
