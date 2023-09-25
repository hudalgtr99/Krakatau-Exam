<?php

require_once('../config/tce_config.php');

$pagelevel = 5;
require_once('../../shared/code/tce_authorization.php');
require_once('../../shared/code/tce_functions_form_admin.php');
require_once('../../shared/code/tce_functions_tcecode.php');
require_once('tce_functions_filemanager.php');

$thispage_title = 'MS Word to XML Converter';
$thispage_title_icon = '<i class="fas fa-file-word icon-gradient bg-sunny-morning"></i> ';

require_once('../code/tce_page_header.php');

echo '<div class="mb-3">'.K_NEWLINE;

echo '<div class="card">'.K_NEWLINE;

echo '<div class="card-body">'.K_NEWLINE;
?>
<h3>Langkah menggunakan konverter:</h3>
<ol class="px-3 mx-2">
<li>Download Format MS Word <a href="https://drive.google.com/file/d/1YB7m56snLBaDKy0dBEJ5JULBt9vKABRe/view">disini</a></li>
<li>Setelah didownload ubah sesuai dengan keinginan, perhatikan beberapa contoh soal. Ada tipe soal MCSA, MCMA, Isian singkat, Uraian Panjang, maupun Ordering</li>
<li>Setelah selesai, simpan soal</li>
<li>Buka Halaman Web Konverter online <a href="https://pemdas.yayasan-gondang.com/simple-word2tcexml" target="blank">disini</a></li>
<li>Buka soal yang telah anda susun di Microsoft Word, tekan CTRL+A untuk menseleksi semua soal.</li>
<li>Tekan CTRL+C untuk menyalin/mengcopy semua soal.</li>
<li>Paste semua soal yang ada pada MS Word ke form yang disediakan</li>
<li>Silakan Review soal yang telah masuk ke editor. Apabila ada yang belum sesuai silakan lakukan perubahan seperlunya (edit kembali soal yang ada pada Microsoft Word)</li>
<li>Klik tombol PROCEED untuk mulai memproses soal ke dalam sistem</li>
<li>Daftar soal yang telah masuk akan ditampilkan, dan Anda bisa mereview ulang. Apabila butuh mengulangi proses pengubahan silakan klik tombol Retry di bawah.</li>
<li>Apabila sudah merasa bahwa soal yang telah masuk sudah sesuai, silakan klik tombol Convert and Download XML Format</li>
<li>Anda dapat menggunakan file XML ini untuk diimportkan ke TCExam Anda masing-masing.</li>
</ol>
<h3>Untuk mengimport file XML ke TCExam caranya adalah :</h3>
<ol class="px-3 mx-1">
<li>Masuk ke menu <span class="font-weight-bold">Modul <i class="fa fa-arrow-right"></i> Import Soal</span></li>
<li>Pada form yang disediakan klik Choose File untuk memilih File XML yang tadi telah kita Download</li>
<li>Kemudian klik tombol <span class="font-weight-bold">Kirim</span> untuk memasukkan soal ke dalam database</li>
<li>Soal yang sudah diimport dapat diperiksa kembali melalui menu <span class="font-weight-bold">Modul <i class="fa fa-arrow-right"></i> Kelola Bank Soal</span></li>
</ol>

<div class="alert alert-info"><h5>Web Konverter Offline</h5><p>Web konverter dari format MS Word ke XML disediakan gratis untuk versi online, untuk versi offline yang bisa anda pasang di server / hosting masing-masing disediakan namun tidak gratis. Silakan hubungi pengembang jika membutuhkan <a class="badge badge-info" href="https://wa.me/628561575817">https://wa.me/628561575817</a> (Maman Sulaeman)</p></div>
<?php

echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

require_once('../code/tce_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
