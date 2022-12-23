<?php
function console_log($args = false){
	$args_as_json = json_encode($args);

	$js_code = "<script>console.log('%c 💬 PHP: ','background: #474A8A; color: #B0B3D6; line-height: 2',";
	$js_code .= "{$args_as_json},";
	$js_code .= ")</script>";

	echo $js_code;
}

function dd($var=false){
	if($var!=false){

		echo '<blockquote style="padding:22px;background:lightyellow" >';
		nl2br(print_r($var));
		echo '</blockquote>';
	}
}
?>
