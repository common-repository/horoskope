<?php
/**
 * Beschreibung des CurlWrapper
 *
 * Für diese Klasse muss das CURL PHP Modul eingebunden sein
 *
 * @co-author mhirose
 * @author m.breunig
 */
class CurlWrapper
{

	public static function getRequest($url){
		/**
		 * Soap-Aufruf via Get-Parameter
		 *
		 * @author m.breunig
		 *
		 * @params
		 * url -> die Url incl. Get-Parameter
		 *
		 * @response
		 * http_code -> Status des Soap-Servers
		 * xmlelement -> Daten der Soapschnittstelle
		 * error -> Fehlermeldung des Soap-Servers
		 */
		$http_code = NULL;
		$xmlelement = NULL;
		$errno = NULL;
		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	
		$xmlstr = curl_exec( $ch );
		$errno = curl_errno( $ch );
	
		if( !$errno ){
			$info = curl_getinfo( $ch );
			$http_code = $info["http_code"];
			if( $http_code == "200" ) {
				try {
					$xmlelement = @new SimpleXMLElement( $xmlstr );
				} catch ( Exception $e ) {
					$xmlelement = NULL;
				} 
			}
		}
		curl_close( $ch );
		return array( "http_code" => $http_code, "xmlelement" => $xmlelement, "errno" => $errno, 'data' => $xmlstr );
	}
	
	public static function postRequest( $url, $method, array $postfields )
	{
		/**
		 * Soap-Aufruf via Post-Parameter
		 *
		 * @author m.breunig
		 *
		 * @params
		 * url -> die Url incl. Get-Parameter
		 * method -> Methode, mit der die Soapschnittstelle benutzt werden soll
		 * postfields -> Post-Parameter für die Soapschnittstelle
		 *
		 * @response
		 * http_code -> Status des Soap-Servers
		 * xmlelement -> Daten der Soapschnittstelle
		 * error -> Fehlermeldung des Soap-Servers
		 */
			$http_code = NULL;
			$xmlelement = NULL;
			$errno = NULL;

			array_push( $postfields, "sf_method=" . $method );

			$ch = curl_init( $url );
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, implode( $postfields, "&" ) );
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
			curl_setopt( $ch, CURLOPT_HEADER, 0 );  // DO NOT RETURN HTTP HEADERS
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );  // RETURN THE CONTENTS OF THE CALL*/
			$xmlstr = curl_exec( $ch );
	
			$errno = curl_errno( $ch );
			if( !$errno )
			{
					$info = curl_getinfo( $ch );
					$http_code = $info["http_code"];
					if( $http_code == "200" )
					{
						try {
							$xmlelement = @new SimpleXMLElement( $xmlstr );
						} catch ( Exception $e ) {
							$xmlelement = NULL;
						} 
					}
			}
			curl_close( $ch );
	
			return array( "http_code" => $http_code, "xmlelement" => $xmlelement, "errno" => $errno, 'data' => $xmlstr );
	}

	public static function getFromString( $xmlstr ){
		/**
		 * Xml Elemente aus einem String
		 *
		 * @author m.breunig
		 *
		 * @params
		 * xmlstr -> der gesamte XML- String
		 *
		 * @response array
		 * http_code -> Status
		 * xmlelement -> Daten der Soapschnittstelle
		 * data -> XML- String
		 */
		$xmlelement = @new SimpleXMLElement( $xmlstr );
		return array( "http_code" => 200, "xmlelement" => $xmlelement, 'data' => $xmlstr );
	}
}
?>
