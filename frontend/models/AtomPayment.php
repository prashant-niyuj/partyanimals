<?php
namespace frontend\models;
use yii\db\Query;
use Yii;

class AtomPayment {

	var $url = "https://payment.atomtech.in/paynetz/epi/fts";
	

	function sendInfo($order_id,$gross_total){
		$datenow = date("d/m/Y h:m:s");
		$modifiedDate = str_replace(" ", "%20", $datenow);
		$Login="18748";
		$payment_url = "https://payment.atomtech.in/paynetz/epi/fts";
		$Password="INFINITE@123";
		$MerchantName="ATOM";
		$TxnCurr="INR";
		$TxnScAmt="0";
		$ttype = "NBFundTransfer";
		$prodid = "INFINITE";
		$clientcode = "mnm";
		$account_no= "9611745416";
		$ru= "http://partyanimals.in/beta/frontend/web/index.php?r=site/thankyou&b_id=".$order_id;

		$postFields  = "";
		$postFields .= "&login=".$Login;
		$postFields .= "&pass=".$Password;
		$postFields .= "&ttype=".$ttype;
		$postFields .= "&prodid=".$prodid;
		$postFields .= "&amt=".$gross_total;
		$postFields .= "&txncurr=".$TxnCurr;
		$postFields .= "&txnscamt=11";
		$postFields .= "&clientcode=".$clientcode;
		$postFields .= "&txnid=".$order_id;
		$postFields .= "&date=".$modifiedDate;
		$postFields .= "&custacc=".$account_no;
		

		$connection = \Yii::$app->db;
		$model = $connection->createCommand('SELECT CASE cb.booked_type WHEN "1" THEN g.email_address ELSE u.email END as email, n.booking_name as name, n.mobile_no from club_booking cb left join user u on u.id = cb.user_id left join guest_user g on g.id = cb.user_id left join club_booking_names n on n.club_booking_id = cb.id and n.mobile_no <> "" where cb.id = '.$order_id.'	group by email');
		$arr_result = $model->queryAll();
		$return_array = $arr_result[0];
		if(count($return_array) > 1 ) {
			$postFields .= "&udf1=".$return_array['name'];
			$postFields .= "&udf2=".$return_array['email'];
			$postFields .= "&udf3=".$return_array['mobile_no'];
		}
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $payment_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_PORT , 443); 
		//curl_setopt($ch, CURLOPT_SSLVERSION,3);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

		$returnData = curl_exec($ch);

		curl_close($ch);
			return $returnData;
	}

	function writeLog($data){
		$fileName = date("Y-m-d").".txt";
		$fp = fopen("../web/log/".$fileName, 'a+');
		$data = date("Y-m-d H:i:s")." - ".$data;
		fwrite($fp,$data);
		fclose($fp);
	}

	function xmltoarray($data){
		$parser = xml_parser_create('');
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); 
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($parser, trim($data), $xml_values);
		xml_parser_free($parser);
		
		$returnArray = array();
		$returnArray['url'] = $xml_values[3]['value'];
		$returnArray['tempTxnId'] = $xml_values[5]['value'];
		$returnArray['token'] = $xml_values[6]['value'];

		return $returnArray;
	}
}