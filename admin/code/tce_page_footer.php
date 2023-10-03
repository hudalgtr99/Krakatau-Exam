<?php

function TMF_scrollToTop(){
	$res = '<button id="keatas" class="d-print-none btn position-fixed rounded-circle text-white p-0" style="background:rgba(63,106,216,0.8);width:30px;height:30px;right:15px;bottom:10px;display:none;z-index:1000"><i class="fa fa-arrow-up"></i></button>';
	return $res;
}

echo K_NEWLINE;
echo '</div>'.K_NEWLINE; //close div.content
// echo '</div>'.K_NEWLINE; //close div.body
// echo '</div>'.K_NEWLINE; //close div#menuBody

echo TMF_scrollToTop();

echo '<div id="footer" class="d-print-none app-wrapper-footer">'.K_NEWLINE;
echo '<div class="app-footer">'.K_NEWLINE;
echo '<div class="app-footer__inner small d-flex justify-content-center">'.K_NEWLINE;
// include('../../shared/code/tce_page_userbar.php'); // display user bar
echo '<span class="copyright" ';
if(isset($_SESSION['session_user_level']) and $_SESSION['session_user_level']<1 and strlen(LOGIN_BG_IMAGE)>0){
	echo ' style="color:var(--col-11)!important"';
}
echo '><a href="http://www.tcexam.org" ';
if(isset($_SESSION['session_user_level']) and $_SESSION['session_user_level']<1 and strlen(LOGIN_BG_IMAGE)>0){
	echo ' style="color:var(--col-11)!important;border:1px solid var(--col-15t);border-radius:50em;padding:0.05em 0.35em"';
}
echo '>TCExam</a> ver. '.html_entity_decode(K_TCEXAM_VERSION).' - Copyright &copy; 2004-2020 Nicola Asuni - <a href="http://www.tecnick.com" ';
if(isset($_SESSION['session_user_level']) and $_SESSION['session_user_level']<1 and strlen(LOGIN_BG_IMAGE)>0){
	echo ' style="color:var(--col-11)!important;border:1px solid var(--col-15t);border-radius:50em;padding:0.05em 0.35em"';
}
echo '>Tecnick.com LTD</a> - <a href="https://github.com/xamzone/tmfajax" target="blank" class="tmfpatch">tmfpatch v'.file_get_contents('../../TMFPATCHVERSION').'</a> by <a href="https://xamzonelinux.blogspot.com" target="blank" class="tmfpatch">Xamzone</a></a></span>';
echo ' - Krakatau CBT</a> - <a href="https://github.com/hudalgtr99/Krakatau-Exam" target="blank" class="tmfpatch">Krakatau CBT Exam v'.file_get_contents('../../KRAKATAUCBTPATCHVERSION').'</a> - this site is authored by - <a class="tmfpatch" href="mailto:'.K_SITE_REPLY.'">'.K_SITE_AUTHOR.'</a></span>';
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE; //close div.body

echo '<!-- '.base64_decode(K_KEY_SECURITY).' -->'.K_NEWLINE;
// echo '<script src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/jscripts/vendor/modernizr-3.11.2.min.js"></script>'.K_NEWLINE;
// echo '<script src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/jscripts/plugins.js"></script>'.K_NEWLINE;
// echo '<script src="'.K_PATH_HOST.K_PATH_TCEXAM.'admin/jscripts/main.js"></script>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<script>
	document.querySelector(".mm-show").parentElement.setAttribute("class","mm-active");
	document.querySelector(".mm-show").previousSibling.setAttribute("class","mm-active")
</script>'.K_NEWLINE;

echo '<script type="text/javascript" src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/assets/vendor/jquery/jquery.min.js"></script>'.K_NEWLINE;
echo '<script type="text/javascript" src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/assets/vendor/popper/popper.min.js"></script>'.K_NEWLINE;
echo '<script type="text/javascript" src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/assets/vendor/bootstrap/bootstrap.min.js"></script>'.K_NEWLINE;
echo '<script type="text/javascript" src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/assets/vendor/metismenu/metisMenu.min.js"></script>'.K_NEWLINE;
echo '<script type="text/javascript" src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/assets/vendor/toastr/toastr.min.js"></script>'.K_NEWLINE;
echo '<script type="text/javascript" src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>'.K_NEWLINE;
echo '<script type="text/javascript" src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/assets/vendor/app.js"></script>'.K_NEWLINE;
echo '<script type="text/javascript" src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/assets/vendor/demo.js"></script>'.K_NEWLINE;
echo '<script type="text/javascript" src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/assets/vendor/scrollbar.js"></script>'.K_NEWLINE;
echo '<script src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/jscripts/vendor/select2.min.js"></script>'.K_NEWLINE;
echo '<script src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/jscripts/vendor/jquery-scrolltofixed-min.js"></script>'.K_NEWLINE;
echo '<script defer src="'.K_PATH_HOST.K_PATH_TCEXAM.'admin/jscripts/tmf_main.js"></script>'.K_NEWLINE;
// echo '<script src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/jscripts/vendor/selectize.min.js"></script>'.K_NEWLINE;
echo '<script>'.K_NEWLINE;
?>
if($("#fprintmsg")){
	var msgType = $("#msg_type").html();
	var msgTitle = $("#msg_title").html();
	var msgContent = $("#msg_content").html();
	toastr.options = {
		closeButton: !0,
		debug: !1,
		newestOnTop: !0,
		progressBar: !0,
		positionClass: "toast-top-right",
		preventDuplicates: !1,
		onclick: null,
		showDuration: "300",
		hideDuration: "1000",
		timeOut: "5000",
		extendedTimeOut: "1000",
		showEasing: "swing",
		hideEasing: "linear",
		showMethod: "fadeIn",
		hideMethod: "fadeOut"
	}
	
	toastr[msgType](msgContent,msgTitle)
}
<?php
echo '</script>'.K_NEWLINE;
?>
<script>
$(document).ready(function(){
	$('.select2-single').select2({
		theme: 'bootstrap4'
	});
	
	$('.select2-multiple').select2({
		theme: 'bootstrap4',
		multiple: 'multiple'
	});
	
	$(window).scroll(function(){
		if($(window).scrollTop() > $('body').height() / 3){
			$('#keatas').fadeIn();
		}else if($(window).scrollTop() > $('body').height() / 10){
			$('#keatas').fadeOut();
		}
	})
	
	$("#keatas").click(function(){
		$("html, body").animate({
			scrollTop: $("#atas").offset().top
		},500);
	})
	
	if ($(".login_box")[0]){
		$(".login_box > *").addClass("d-none");
		$(".page-title-wrapper").addClass("d-none");
		$(".login_box").html("<div class='card card-body mb-3'>Anda tidak diperkenankan mengakses halaman ini</div>");
	}
	

})
	
	


/*
	$(document).on('select2:open', () => {
		// $('.select2-search__field').click();
		document.querySelector('.select2-search__field').focus();
		// $('.select2-search__field').hide();
	});
*/	
	/* $('#user_groups,#form_testeditor #subject_id[multiple]').selectize({
		plugins: ['remove_button']
	}); */
</script>
<?php

echo '</body>'.K_NEWLINE;
echo '</html>';

if(isset($thispage_help)){
		echo '<div class="modal fade" id="modalPagehelp" tabindex="-1" role="dialog" aria-labelledby="modalPagehelpLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPagehelpLabel"><i class="fa fa-info-circle"></i> Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">'.htmlspecialchars($thispage_help, ENT_NOQUOTES, $l['a_meta_charset']).'</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>'.K_NEWLINE;

	}
//============================================================+
// END OF FILE
//============================================================+