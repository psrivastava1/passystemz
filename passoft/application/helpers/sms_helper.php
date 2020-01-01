<?php
function sms($number,$msg)
{  
//$url="http://bulksms.niktechsoftware.com/vendorsms/pushsms.aspx?user=PASS&password=pass12&msisdn=".$number."&sid=PASYSM&msg=".urlencode($msg)."&fl=0&gwid=2";
	$url="http://zapsms.co.in/vendorsms/pushsms.aspx?user=PASS&password=pass1212&msisdn=".$number."&sid=PASYSM&msg=".urlencode($msg)."&fl=0&gwid=2";
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	$output=curl_exec($ch);
	curl_close($ch);
}
function checkBalSms()
{ 
//$url = "http://bulksms.niktechsoftware.com/vendorsms/CheckBalance.aspx?user=PASS&password=pass12";
$url = "http://zapsms.co.in/vendorsms/CheckBalance.aspx?user=PASS&password=pass1212";
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
$output=curl_exec($ch);
curl_close($ch);
return $output;
}




function getAge($dob) {
	$today = date("Y-m-d");
	$diff = date_diff(date_create($dob), date_create($today));
	return $diff->format('%yYears, %mMonths, %dDays');
}

function highlightText($text, $keywords) {
	$color = "yellow";
	$background = "red";
	foreach($keywords as $keyword) {
		$highlightWord = "<strong style='background:".$background.";color:".$color."'>" . $keyword . "</strong>";
		$text = preg_replace ("/" . trim($keyword) . "/", $highlightWord, $text);
	}
	$keywords = array("Coding 4 Developers","Coding for developers");
	echo highlightText($text, $keywords);
	return $text;
}


