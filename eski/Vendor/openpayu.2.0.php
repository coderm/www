<?php
class OpenPayU_Configuration {
	public static $SignatureKey;
	public static $Environment;
	
	public function setEnvironment($val) {
		self::$Environment = $val;
	}

	
	public function setSignatureKey($val) {
		self::$SignatureKey = $val;
	}
}

class OpenPayU_Order {
	public function create($val) {
		if ( $val['MerchantPosId'] == null || $val['MerchantPosId'] =="" ) {
			throw new Exception("MerchantPosId should not be null or empty.");
		}
		$account = $val['MerchantPosId'];
		$secretKey = OpenPayU_Configuration::$SignatureKey;
		
		$openPayuEndPointUrl = OpenPayU_Configuration::$Environment."order.xml";
		$doc = OpenPayU::buildOpenPayUDocument($val,'OrderCreateRequest');
		//die($openPayuEndPointUrl);
		return OpenPayU::sendOpenPayuDocumentAuth($doc,$account,$secretKey,$openPayuEndPointUrl);

	}
}


class OpenPayU {
	public static function buildOpenPayUDocument($data, $startElement, $request = 1, $xml_version = '1.0', $xml_encoding = 'UTF-8') {
		if(!is_array($data)){
			return false;
		}

		$xml = new XmlWriter();
		$xml->openMemory();
		$xml->startDocument($xml_version, $xml_encoding);
		$xml->startElementNS(null, 'OpenPayU', 'http://www.openpayu.com/openpayu.xsd');

				// message level - open
				$xml->startElement($startElement);
				
				OpenPayU::arr2xml($xml, $data, $startElement);

				// message level - close
				$xml->endElement();
				
		// document level - close
		$xml->endElement();
		
		return $xml->outputMemory(true);
	}
	

	public static function arr2xml(XMLWriter $xml, $data)
		{
			if (!empty($data) && is_array($data)) {
				foreach ($data as $key => $value) {
					if (is_array($value)) {
						if (is_numeric($key)) {
							self::arr2xml($xml, $value);
						} else {
							$xml->startElement($key);
							self::arr2xml($xml, $value);
							$xml->endElement();
						}
						continue;
					}
					$xml->writeElement($key, $value);
				}
			}
		}

	public static function sendOpenPayuDocumentAuth($doc, $merchantPosId, $signatureKey, $openPayuEndPointUrl ) {
		
		if ($openPayuEndPointUrl == "") {
			throw new Exception("OpenPayuEndPointUrl is empty");
		}
		
		if ( $signatureKey == null || $signatureKey == "" ) {
			throw new Exception("Merchant Signature Key should not be null or empty.");
		}

		if ( $merchantPosId== null || $merchantPosId=="" ) {
			throw new Exception("MerchantPosId should not be null or empty.");
		}		
		$tosigndata = $doc.$signatureKey;
		
		$xml = urlencode($doc);
		$signature = hash("sha256",$tosigndata);
		
		$authData = 'sender='.$merchantPosId.
					';signature='.$signature.
					';algorithm=SHA256'.
					';content=DOCUMENT';
		$response = '';

		if (OpenPayU::isCurlInstalled()) {
			$response = OpenPayU::sendDataAuth( $openPayuEndPointUrl, "DOCUMENT=".$xml, $authData);
		} else {
			throw new Exception("curl is not available");
		}
		
		return $response;
	}
	
	public static function sendDataAuth( $url, $doc,$authData) {
	
		$ch = curl_init($url );
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $doc);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch,CURLOPT_HTTPHEADER,array('OpenPayu-Signature:'.$authData));
		
		$response = curl_exec($ch);

		return $response;
	}
	
	private static function isCurlInstalled() {
		if  (in_array  ('curl', get_loaded_extensions())) {
			return true;
		}
		else{
			return false;
		}
	}	
	
	
	public static function outputXmlAsJson($response) {
		header('Content-type: application/json');
		echo json_encode(new SimpleXMLElement($response));
		die();
	}
	
	function gen_uuid() {
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

			// 16 bits for "time_mid"
			mt_rand( 0, 0xffff ),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand( 0, 0x0fff ) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand( 0, 0x3fff ) | 0x8000,

			// 48 bits for "node"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
		);
	}

}

?>