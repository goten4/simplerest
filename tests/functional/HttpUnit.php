<?php

/**
* Class for sending HTTP request
*/
class HttpUnit
{
	protected $host;
	
    public function __construct($host) {
        $this->host = $host;
    }

	public function get($uri, $params = array())
	{
		$url = $this->host . $uri;
		$session = curl_init();
		curl_setopt($session, CURLOPT_URL, $url);
		curl_setopt($session, CURLOPT_HEADER, false);
		
		ob_start();
		curl_exec($session);
		$content = ob_get_contents();
		ob_end_clean();
		
		$status = curl_getinfo($session,  CURLINFO_HTTP_CODE);
		curl_close($session);
		
		return array($status, $content);
	}
}
