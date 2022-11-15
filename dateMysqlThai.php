<?php
function mysql2thaidate($date, $format = 'short'){
    if($date == 0) return '';

    $month_list['long'] = array('01'=>'มกราคม','02'=>'กุมภาพันธ์','03'=>'มีนาคม','04'=>'เมษายน','05'=>'พฤษภาคม',
    '06'=>'มิถุนายน','07'=>'กรกฏาคม','08'=>'สิงหาคม','09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤษจิกายน','12'=>'ธันวาคม');
    $month_list['short'] = array('01'=>'ม.ค.','02'=>'ก.พ.','03'=>'มี.ค.','04'=>'เม.ย.','05'=>'พ.ค.',
    '06'=>'มิ.ย.','07'=>'ก.ค.','08'=>'ส.ค.','09'=>'ก.ย.','10'=>'ต.ค.','11'=>'พ.ย.','12'=>'ธ.ค.');

    $date = new DateTime($date);
    //$result = $date->format('Y-m-d H:i:s');
    $year = $date->format('Y');
    $year += 543;
    $Y['long'] = $year;
    $Y['short'] = substr($year, -2);
    $m = $date->format('m');
    $d = $date->format('d');

    return $d.' '.$month_list[$format][$m].' '.$Y[$format];
}

function mysql2thaidatetime($date, $format = 'short'){
    if($date == 0) return '';
    
    $ymd = mysql2thaidate($date, $format);
    $date = new DateTime($date);
    $time = $date->format('H:i:s');

    return $ymd . ' เวลา ' . $time;
}
function thaidate2mysql($date){

    list($d,$m,$Y) = explode('/',$date);
	$d = str_pad($d,2,"0",STR_PAD_LEFT);
	$m = str_pad($m,2,"0",STR_PAD_LEFT);
    //$Y = $Y-543;
    //return $Y.'-'.$m.'-'.$d;
    return $Y.$m.$d;
}

function month_thai ($m = ''){
    $month_list = array('01'=>'มกราคม','02'=>'กุมภาพันธ์','03'=>'มีนาคม','04'=>'เมษายน','05'=>'พฤษภาคม',
    '06'=>'มิถุนายน','07'=>'กรกฏาคม','08'=>'สิงหาคม','09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤษจิกายน','12'=>'ธันวาคม');

    if(empty($m)){
        return $month_list[date("m")];
    }else{
        return $month_list[$m];
    }
}
function yymm_thai ($ym = ''){
    $mm_list = array('01'=>'มกราคม','02'=>'กุมภาพันธ์','03'=>'มีนาคม','04'=>'เมษายน','05'=>'พฤษภาคม',
    '06'=>'มิถุนายน','07'=>'กรกฏาคม','08'=>'สิงหาคม','09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤษจิกายน','12'=>'ธันวาคม');

    if(strlen($ym) == 6){
        $yy = $ym[0].$ym[1].$ym[2].$ym[3];
        $mm = $ym[4].$ym[5];

        return $mm_list[$mm] . ' ' . ($yy+543);
    }else{
        return '';
    }
}
?>
