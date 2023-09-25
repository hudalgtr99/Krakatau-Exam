<?php
//============================================================+
// File name   : tmf_help_support.php
// Begin       : 2023-01-06
// Last Update : 2023-01-06
//
// Description : Help and support information
//
// Author: Maman Sulaeman
//
// (c) Copyright:
//               Maman Sulaeman
//               TKJ SMK Gondang
//               tkj.yayasan-gondang.com
//               mamansulaeman86@gmail.com
//
/**
 */

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_INFO;
require_once('../../shared/code/tce_authorization.php');

$thispage_title = 'Bantuan dan Dukungan';
$thispage_title_icon = '<i class="pe-7s-help2 icon-gradient bg-strong-bliss"></i> ';

require_once('../code/tce_page_header.php');
require_once('../../shared/code/tce_functions_form_admin.php');

require_once('tce_page_header.php');

echo '<div class="card mb-3">'.K_NEWLINE;
echo '<div class="card-header"><i class="pe-7s-help1"></i>&nbsp;Bantuan Penggunaan Aplikasi'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<div class="card-body">'.K_NEWLINE;
echo '<p>Kami menyediakan beberapa saluran untuk membantu Anda selama menggunakan TMFCBT, antara lain sebagai berikut :</p>';
echo '<ol>';
echo '<li>Buka tutorial gratis yang kami sediakan <a target="_blank" href="https://tkj.yayasan-gondang.com/2021/05/panduan-penggunaan-aplikasi-cbt-tcexam.html" class="btn btn-sm btn-primary py-0"><i class="fa fa-book"></i>&nbsp;DISINI</a> untuk memahami aspek umum yang berkaitan dengan penggunaan TMFCBT.</li>';
echo '<li>Buka group Telegram TMFCBT di <a target="_blank" href="https://t.me/tmfcbtakm" class="btn btn-sm btn-info py-0"><i class="fa fa-paper-plane"></i>&nbsp;https://t.me/tmfcbtakm</a> untuk berdiskusi antar sesama pengguna TMFCBT. Disarankan untuk selalu posting kendala di group Telegram.</li>';
echo '<li>Jika membutuhkan layanan berbayar berupa pendampingan khusus secara langsung silakan bisa hubungi ke <a target="_blank" href="https://t.me/mamans86" class="btn btn-sm btn-dark py-0"><i class="fa fa-paper-plane"></i>&nbsp;https://t.me/mamans86</a> kami menyediakan jasa install aplikasi TMFCBT ke hosting atau jasa remote penggunaan aplikasi</li>';
echo '</ol>';
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="card mb-3">'.K_NEWLINE;
echo '<div class="card-header"><i class="pe-7s-help2"></i>&nbsp;Dukungan kepada Aplikasi'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<div class="card-body">'.K_NEWLINE;
echo '<div class="border rounded">'.K_NEWLINE;
echo '<h6 class="p-2 border-bottom font-weight-bold bg-light">Word-to-XML</h6>';
echo '<div class="p-2">';
echo '<p>TMFCBT dikembangkan dengan spirit <i>Free Open Source Software</i> kecuali <i>source code</i> aplikasi untuk konversi soal format Word ke XML.</p>';
echo '<p>Layanan konversi soal format Word ke XML disediakan gratis yang bisa diakses secara <i>online</i> <a target="_blank" href="https://pemdas.yayasan-gondang.com/simple-word2tcexml/" class="btn btn-sm btn-alternate py-0"><i class="fa fa-refresh"></i>&nbsp;disini</a></p>';
echo '<p>Apabila Anda menginginkan aplikasi konversi tersebut terpasang di server / hosting Anda masing-masing, silakan hubungi pengembang, namun lisensinya <b>tidak <i>free open source</i> (berbayar)</b>.</p>';
echo '<p>Agar TMFCBT bisa dikembangkan secara berkelanjutan dan pengembang memiliki semangat untuk terus mengupdate aplikasi, silakan mendukung TMFCBT dengan cara membeli aplikasi konverter tersebut (jika berminat)</p>';
echo '<a target="_blank" href="https://t.me/mamans86" class="btn btn-block btn-primary font-weight-bold"><i class="fa fa-paper-plane"></i>&nbsp;Hubungi Pengembang</a>';
echo '</div>';
echo '</div>';


echo '<div class="border rounded mt-2">'.K_NEWLINE;
echo '<h6 class="p-2 border-bottom font-weight-bold bg-light">Donasi Seikhlasnya</h6>';
echo '<div class="p-2">';
echo '<p>Jika belum ada minat untuk membeli namun ingin ikut membantu secara sukarela, silakan bisa berdonasi seikhlasnya ke Rekening pengembang<br/><span class="badge badge-primary">Rek. BNI 0837864878 a.n. Maman Sulaeman</span></p>';

echo '<p>Ingin membantu namun tidak punya rekening Bank? Silakan bisa menggunakan aplikasi DANA atau ShopeePay, transfer seikhlasnya ke nomor <span class="badge badge-info"><i class="fa fa-money-check"></i>&nbsp;DANA 08561575817</span> atau <span class="badge badge-danger"><i class="fa fa-shopping-bag"></i>&nbsp;ShopeePay 08561575817</span></p>';
echo '</div>';
echo '</div>';


echo '<div class="border rounded mt-2">'.K_NEWLINE;
echo '<h6 class="p-2 border-bottom font-weight-bold bg-light">Dukungan Afiliasi</h6>';
echo '<div class="p-2">';
echo '<p>Jika Anda belum berminat membeli konverter atau donasi, Anda dapat mendukung TMFCBT melalui beragam cara sebagai berikut :</p>';
echo '<ol class="list-group">';
echo '<li class="list-group-item">Membeli produk hosting yang sudah kami uji kinerjanya dengan TMFCBT, kami menyarankan Anda untuk menggunakan <b>Niagahoster</b>, silakan bisa membeli melalui link berikut ini <a target="_blank" href="https://www.niagahoster.co.id/ref/102671" class="btn btn-sm btn-success py-0"><i class="fa fa-server"></i>&nbsp;https://www.niagahoster.co.id/ref/102671</a> gunakan kode kupon <b><u>tmfcbtakm</u></b> untuk mendapatkan diskon 5%.</li>';
echo '<li class="list-group-item">Membeli produk afiliasi dari <b>Shopee</b> yang dikelola oleh pengembang pada tombol berikut <a href="https://shope.ee/2fcbalXmlt" target="_blank" class="btn btn-sm btn-danger py-0"><i class="fa fa-shopping-bag"></i>&nbsp;Shopee Murah Lebay</a> Agar komisi pembelian bisa masuk ke pengembang, maka belilah produk fisik <span class="text-danger">(jangan beli produk digital seperti paket data, pulsa, token), dan jangan pilih opsi pembayaran COD</span></li>';
echo '<li class="list-group-item">Membeli produk afiliasi dari <b>Tiktok Shop</b> yang dikelola oleh pengembang pada link berikut <a href="https://tiktok.com/@cektiktokshop" target="_blank" class="btn btn-sm btn-dark py-0"><i class="fa fa-shopping-bag"></i>&nbsp;https://tiktok.com/@cektiktokshop</a> Buka link tersebut, buka menu showcase, buka produknya dan lanjutkan proses pembelian jika Anda berminat.</li>';
$produkArr = [
'https://tokopedia.link/klYWXLsZLsb',
'https://tokopedia.link/jS2cVXvZLsb',
'https://tokopedia.link/2IMFIZSZLsb',
'https://tokopedia.link/7hNqHYVZLsb',
'https://tokopedia.link/lO7Emq31Lsb',
'https://tokopedia.link/0IAAx8XZLsb',
'https://tokopedia.link/PDnqsCa2Lsb',
'https://tokopedia.link/al1hp4b2Lsb',
'https://tokopedia.link/TF5st6d2Lsb',
'https://tokopedia.link/AEHkaHh2Lsb',
'https://tokopedia.link/TmzMg5m2Lsb',
'https://tokopedia.link/CBPw0Kp2Lsb',
'https://tokopedia.link/ZGpshPs2Lsb',
'https://tokopedia.link/XYNBokw2Lsb',
'https://tokopedia.link/f2B4nly2Lsb',
'https://tokopedia.link/G13fwiA2Lsb',
'https://tokopedia.link/0hXLzXB2Lsb',
'https://tokopedia.link/Irbq39D2Lsb',
'https://tokopedia.link/kCMN8lN2Lsb',
'https://tokopedia.link/WYYsM9T2Lsb'];
echo '<li class="list-group-item">Mengunjungi beberapa link afiliasi <b>Tokopedia</b> yang dikelola oleh pengembang. Cukup kunjungi saja beberapa link di bawah ini agar pengembang memperoleh komisi kunjungan dari Tokopedia<ol>';
foreach($produkArr as $val){
	echo '<li><a target="_blank" href="'.$val.'">'.$val.'</a></li>';
}
echo '</ol></li>';
echo '</ol>';
echo '</div>';
echo '</div>';


echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;


require_once('tce_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
