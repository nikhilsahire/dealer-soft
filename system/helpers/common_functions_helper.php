<?php 

if(! function_exists('is_admin_logged_in')){
	function is_admin_logged_in()
	{
		// Get current CodeIgniter instance
		$CI =& get_instance();
		// We need to use $CI->session instead of $this->session
		$user = $CI->session->userdata('userid');
		$userrole = $CI->session->userdata('userrole');
		//echo '<pre>'; echo $userrole; die('789');
		$isLogin = $CI->session->userdata('is_login');
		//echo $isLogin; die('1234');
		if ((!isset($user) && $isLogin == '') ) { return false; } else { return true; } // || ($userrole != 'Admin')
		//if ((!isset($user) && $isLogin == '') || ($userrole == 'Sales') || ($userrole == 'Admin')) { return true; } else { return false; } // || ($userrole != 'Admin')
		}
}

if(! function_exists('is_sales_logged_in')){
	function is_sales_logged_in()
	{
		// Get current CodeIgniter instance
		$CI =& get_instance();
		// We need to use $CI->session instead of $this->session
		$user = $CI->session->userdata('userid');
		$userrole = $CI->session->userdata('userrole');
		//echo '<pre>'; echo $userrole; die('789');
		$isLogin = $CI->session->userdata('is_login');
		if ((!isset($user) && $isLogin == '') || ($userrole != 'Sales')) { return false; } else { return true; }
		}
}

if(! function_exists('is_purchase_logged_in')){
	function is_purchase_logged_in()
	{
		// Get current CodeIgniter instance
		$CI =& get_instance();
		// We need to use $CI->session instead of $this->session
		$user = $CI->session->userdata('userid');
		$userrole = $CI->session->userdata('userrole');
		//echo '<pre>'; echo $userrole; die('789');
		$isLogin = $CI->session->userdata('is_login');
		if ((!isset($user) && $isLogin == '') || ($userrole != 'Purchase')) { return false; } else { return true; }
		}
}

if(! function_exists('is_account_logged_in')){
	function is_account_logged_in()
	{
		// Get current CodeIgniter instance
		$CI =& get_instance();
		// We need to use $CI->session instead of $this->session
		$user = $CI->session->userdata('userid');
		$userrole = $CI->session->userdata('userrole');
		//echo '<pre>'; echo $userrole; die('789');
		$isLogin = $CI->session->userdata('is_login');
		if ((!isset($user) && $isLogin == '') || ($userrole != 'Accounts')) { return false; } else { return true; }
		}
}

if(! function_exists('is_stores_logged_in')){
	function is_stores_logged_in()
	{
		// Get current CodeIgniter instance
		$CI =& get_instance();
		// We need to use $CI->session instead of $this->session
		$user = $CI->session->userdata('userid');
		$userrole = $CI->session->userdata('userrole');
		//echo '<pre>'; echo $userrole; die('789');
		$isLogin = $CI->session->userdata('is_login');
		if ((!isset($user) && $isLogin == '') || ($userrole != 'Stores')) { return false; } else { return true; }
		}
}

if(! function_exists('is_qc_logged_in')){
	function is_qc_logged_in()
	{
		// Get current CodeIgniter instance
		$CI =& get_instance();
		// We need to use $CI->session instead of $this->session
		$user = $CI->session->userdata('userid');
		$userrole = $CI->session->userdata('userrole');
		//echo '<pre>'; echo $userrole; die('789');
		$isLogin = $CI->session->userdata('is_login');
		if ((!isset($user) && $isLogin == '') || ($userrole != 'QC')) { return false; } else { return true; }
		}
}


function getDay($daySelected)
{
	 $arrDays = array("1"=>"1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
	 $day ='<option value="" >Day</options>';
	 foreach($arrDays as $value => $id)
	 {
		 if($daySelected==$id)
			$day.="<option value=$id selected>$value</options>";
		else
			$day.="<option value=$id>$value</options>";
	 }
	 return $day;
}

function getMonthCombo($month)
{		$state ='<option value="">Month</options>';
	 $news=array("01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"Septeber","10"=>"October","11"=>"November","12"=>"December");
	 
	 foreach($news as $id => $value)
	 {
		 if($month==$id)
			$state.="<option value=$id selected>$value</options>";
		else
			$state.="<option value=$id>$value</options>";
	 }
	 return $state;
}

function getYear($year1)
{
	 $state='<option value="" >Year</options>';
	 $year=date("Y");
	 $year-=6;
	 $count=0;
	 while($count<=60)
	 {
		 if($year1==$year)
			$state.="<option value=$year selected>$year</options>";
		else
			$state.="<option value=$year>$year</options>";
	    $year--;
	 	$count++;
	 }
	 return $state;
}
/* Send Email function */
function sendEmail($to,$subj,$from,$fromName,$msg)
{
	$headers = '';
	$headers .= "From: ".$fromName."<".$from.">\r\n";
	$headers .= "Reply-To: ".$to."\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	@mail($to,$subj,$msg,$headers);	
}

function base64UrlEncode($data)
{
  return strtr(rtrim(base64_encode($data), '='), '+/', '-_');
}

function base64UrlDecode($base64)
{
  return base64_decode(strtr($base64, '-_', '+/'));
}


/* Functionn to convert amoiunt in text amount format */

function amountToWards($number){
	
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
  return $result. " Only." ; // . $points . " Paise"
}


?>