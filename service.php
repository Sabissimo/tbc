<?php
ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);
class Log
  {
  public function __construct($log_name)
    {
    //if(!file_exists('C:\inetpub\wwwroot\tbc\log\\'.$log_name)){ $log_name='a_default_log.log'; }
    $this->log_name=$log_name;

    $this->log_file='D:\tbclog\\'.$this->log_name;
    $this->log=fopen($this->log_file,'w+');
    }
  public function log_msg($msg)
    {//the action
    //$log_line=join(' : ', array( date("YMdHms"), $this->page_name, $this->app_id, $msg ) );
    fwrite($this->log, $msg);
    }
  function __destruct()
    {//makes sure to close the file and write lines when the process ends.
    //$this->log_msg("Closing log");
    fclose($this->log);
    }
  }



class WsseAuthHeader extends SoapHeader {

	private $wss_ns = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';

	function __construct($authheader) {
	
		$auth = new stdClass();
		$auth->Username = new SoapVar($authheader->HeaderUsername, XSD_STRING, NULL, $this->wss_ns, NULL, $this->wss_ns);
		$auth->Password = new SoapVar($authheader->HeaderPassword, XSD_STRING, NULL, $this->wss_ns, NULL, $this->wss_ns);
		if($authheader->HeaderNonce != "")
		{
			$auth->Nonce = new SoapVar($authheader->HeaderNonce, XSD_STRING, NULL, $this->wss_ns, NULL, $this->wss_ns);
		}
		

		$username_token = new stdClass();
		$username_token->UsernameToken = new SoapVar($auth, SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'UsernameToken', $this->wss_ns);

		$security_sv = new SoapVar(
			new SoapVar($username_token, SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'UsernameToken', $this->wss_ns),
			SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'Security', $this->wss_ns);
		parent::__construct($this->wss_ns, 'Security', $security_sv, false);
		
	}

}

class RealSoapClient extends SoapClient {
	
	private $xsitypes;
	private $objectname;
	
    function __construct($wsdl, $options) {
		$this->xsitypes = $options["XsiTypes"];
		$this->objectname = $options["ObjectName"];

		if(isset($_GET['cert']) && !empty($_GET['cert'])) {
			// SOAP Service URL
			$serviceUrl = "https://secdbi.tbconline.ge/dbi/dbiService";

			// Convert PFX to PEM format (PersistKeySet equivalent)
			$certFile = __DIR__ . "/".$_GET['cert'].".pem";
			$keyFile  = __DIR__ . "/".$_GET['cert'].".key";

			// Create a stream context
			$streamContext = stream_context_create([
				'ssl' => [
					'local_cert'     => $certFile,  // Persisted certificate
					'local_pk'       => $keyFile,   // Persisted private key
					'verify_peer'    => false, // Disable peer verification for dev
					'verify_peer_name' => false,
					'crypto_method'  => STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT | 
										STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT | 
										STREAM_CRYPTO_METHOD_TLS_CLIENT | 
										STREAM_CRYPTO_METHOD_SSLv3_CLIENT,
				]
			]);

			$options['stream_context'] = $streamContext;
			$options['location'] = $serviceUrl; // Setting the service URL
		}
		
		parent::__construct($wsdl, $options);
    }
	
	function fixXml($xml) {
		$xml = str_replace('&','&amp;',$xml);		
		$xml = str_replace('xmlns:ns1','xmlns:myg',$xml);		
		$xml = str_replace('ns1:','myg:',$xml);
		$xml = str_replace('ns2','wsse',$xml);
		$xml = str_replace('SOAP-ENV','soapenv',$xml);
		$xml = str_replace('xmlns:myg="http://www.mygemini.com/schemas/mygemini"','xmlns:myg="http://www.mygemini.com/schemas/mygemini" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"',$xml);
		
		
		
		$idarray = json_decode($this->xsitypes, true);
		
		$xml_original_exploded = explode("<myg:".$this->objectname, $xml);
		// print_r($xml_original_exploded);
		// die();
		$xml_original_new = array();
		foreach($xml_original_exploded as $xml) {


			$position_position_start = strpos($xml, "<myg:position>");
			if($position_position_start !== false)
			{
				$position_position_end = strpos($xml, "</myg:position>", $position_position_start + 14);
				if($position_position_end !== false)
				{
					$position = substr($xml, $position_position_start + 14, $position_position_end - ($position_position_start + 14));
					if(array_key_exists($position, $idarray))
					{
						if(array_key_exists("append", $idarray[$position]))
						{
							$append_text = "";
							foreach($idarray[$position]["append"] as $key => $value)
							{
								$append_text = $append_text."<myg:".$key.">".$value."</myg:".$key.">";
							}
							$xml = str_replace('</myg:'.$this->objectname.'>', $append_text.'</myg:'.$this->objectname.'>', $xml);
						}			
						if(array_key_exists("xsitype", $idarray[$position]))
						{
							$xml = ' xsi:type="myg:'.$idarray[$position]["xsitype"].'"'.$xml;
						}			
					}
				//
				}
			}
			
			array_push($xml_original_new, $xml);	
		}

		$xml = implode('<myg:'.$this->objectname, $xml_original_new);
		
		$xml = str_replace("<myg:singlePaymentRequestId>0</myg:singlePaymentRequestId>", "", $xml);
		$xml = str_replace("<myg:batchPaymentRequestId>0</myg:batchPaymentRequestId>", "", $xml);		
		
		//$log=new Log(date("YMdHms").".log");
		//$log->log_msg($xml);
		// echo $xml;
		// die();
 
		return $xml;
	}
	
    function __doRequest($xml, $location, $action, $version, $one_way = 0) {
		
		
		return parent::__doRequest($this->fixXml($xml), $location, $action, $version);
    }
}

class Retranslator {
	
	private function retranslate($functionName, $param, $xsiappend = "", $objectname = "")
	{
		$client = new RealSoapClient("service.wsdl", array('trace' => true,"exceptions"=>1, 'XsiTypes'=>$xsiappend, 'ObjectName'=>$objectname, 'cache_wsdl' => WSDL_CACHE_NONE, "stream_context" => stream_context_create (
            array (
                'ssl' => array ('verify_peer' => false, 'verify_peer_name' => false)
            )
        )));
   
		$client->__setSoapHeaders(Array(new WsseAuthHeader($param->AuthHeader)));
		$response = $client->__soapCall($functionName, array("parameters" => $param));
			
			
		return $response;
	}
	
	public function GetAccountMovements($param)
	{
		return $this->retranslate("GetAccountMovements", $param);
	}
	
	public function GetAccountStatement($param)
	{
		return $this->retranslate("GetAccountStatement", $param);
	}
	
	public function GetMessagesFromPostbox($param)
	{
		return $this->retranslate("GetMessagesFromPostbox", $param);
	}
	
	public function AcknowledgePostboxMessages($param)
	{
		return $this->retranslate("AcknowledgePostboxMessages", $param);
	}
	
	public function GetBatchPaymentId($param)
	{
		return $this->retranslate("GetBatchPaymentId", $param);
	}
	
	public function GetSinglePaymentId($param)
	{
		return $this->retranslate("GetSinglePaymentId", $param);
	}
	
	public function GetPaymentOrderStatus($param)
	{
		return $this->retranslate("GetPaymentOrderStatus", $param);
	}
	
	public function ImportBatchPaymentOrder($param)
	{
		return $this->retranslate("ImportBatchPaymentOrder", $param, $this->GenerateXsiAppend($param, "paymentOrder"), "paymentOrder");
	}
	
	public function ImportSinglePaymentOrders($param)
	{		
		return $this->retranslate("ImportSinglePaymentOrders", $param, $this->GenerateXsiAppend($param, "singlePaymentOrder"), "singlePaymentOrder");
	}
	
	public function ChangePassword($param)
	{
		return $this->retranslate("ChangePassword", $param);
	}
	
	private function GenerateXsiAppend($param, $objectname)
	{
		$paymentOrders = json_decode(json_encode($param), true);
		$xsiappend = array();
		if(array_key_exists($objectname,$paymentOrders))
		{
			if(count($paymentOrders[$objectname]) > 0)
			{
				if(array_key_exists("xsitype",$paymentOrders[$objectname]))
				{
					$xsiappend = $this->GenerateXsiAppendArray($paymentOrders[$objectname],$xsiappend);
				}
				else
				{
					foreach($paymentOrders[$objectname] as $paymentOrder)
					{
						$xsiappend = $this->GenerateXsiAppendArray($paymentOrder,$xsiappend);
					}	
				}
			}
		}
		return json_encode($xsiappend);
	}
	
	private function GenerateXsiAppendArray($paymentOrder, $xsiappend)
	{
		$appendable_xsitype = array_key_exists("xsitype",$paymentOrder);
						
		$appendable_append = false;
		$appendable_append_array = array();
		foreach($paymentOrder as $key => $paymentOrderProperty)
		{
			if(substr($key,0,7) == "Append_" && !empty($paymentOrderProperty))
			{
				$appendable_append_array[substr($key,7)] = $paymentOrderProperty;
				$appendable_append = true;
			}					
		}			
		if($appendable_xsitype||$appendable_append)
		{
			$appendarray = array();
			if($appendable_xsitype)
			{
				$appendarray["xsitype"] = $paymentOrder["xsitype"];
			}
			if($appendable_append)
			{
				$appendarray["append"] = $appendable_append_array;
			}
			$xsiappend[$paymentOrder["position"]] = $appendarray;
		}
		
		return $xsiappend;
	}

}


if(isset($_GET['cert']) && !empty($_GET['cert'])) {
	$location = "http://".$_SERVER['HTTP_HOST'].str_replace("service.php", "retranslator.php", $_SERVER['PHP_SELF'])."?cert=".$_GET['cert'];
} else {
	$location = "http://".$_SERVER['HTTP_HOST'].str_replace("service.php", "retranslator.php", $_SERVER['PHP_SELF']);
}

$options= array('uri'=>'./service.php');
$server=new \SoapServer($location, $options);
$server->setClass('Retranslator');
$server->handle();
?>