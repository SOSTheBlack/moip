<?php namespace SOSTheBlack\Moip;

/**
 * MoIP's API connection class
 *
 * @author Herberth Amaral
 * @author Paulo Cesar
 * @version 0.0.2
 * @license <a href="http://www.opensource.org/licenses/bsd-license.php">BSD License</a>
 */
class Client {

    /**
     * Method send()
     *
     * Send the request to API's server
     *
     * @param string $credentials Token and key to the authentication
     * @param string $xml The XML request
     * @param string $url The server's URL
     * @param string $method Method used to send the request
	 * @throws Exception
	 * @return Response
     */
    public function send($credentials, $xml, $url='https://desenvolvedor.moip.com.br/sandbox/ws/alpha/EnviarInstrucao/Unica', $method='POST') {
        $header = [];
        $header[] = "Authorization: Basic " . base64_encode($credentials);
        if (!function_exists('curl_init')){
            throw new Exception('This library needs cURL extension');
		}
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_USERPWD, $credentials);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0");
        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
        }
		if ($xml != '') curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $ret = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return new Response(array('resposta' => $ret, 'erro' => $err));
    }

    /**
	 * @param string $credentials token / key authentication Moip
	 * @param string $xml url request
	 * @param string $url url request
	 * @param string $error errors
	 * @return Response
     */
    function curlPost($credentials, $xml, $url, $error=null) 
    {
        return $this->initialCurl($credentials, $xml, $url, $error);   
    }

    /**
     * @param string $credentials token / key authentication Moip
     * @param string $url url request
     * @param string $error errors
     * @return Response
     */
    function curlGet($credentials, $url, $error=null) 
    {
        return $this->initialCurl($credentials, null, (string) $url, $error);
    }

   /**
     * @param string $credentials token / key authentication Moip
     * @param string $xml url request
     * @param string $url url request
     * @param string $error errors
     * @return Response
     */
    public function initialCurl($credentials, $xml, $url, $error)
    {
        if (!$error) {
            $header   = [];
            $header[] = "Expect:";
            $header[] = "Authorization: Basic " . base64_encode($credentials);

            $ch = curl_init();
            $options = [];
            $options[CURLOPT_URL] = $url;
            $options[CURLOPT_HTTPHEADER] = $header;
            $options[CURLOPT_SSL_VERIFYPEER] = false;
            $options[CURLOPT_RETURNTRANSFER] = true;

            if ($xml !== null) {
                $options[CURLOPT_POST] = true ;
                $options[CURLOPT_POSTFIELDS] =  $xml;
                $options[CURLINFO_HEADER_OUT] =   true;
            }

            curl_setopt_array($ch, $options);
            $ret = curl_exec($ch);
            $err = curl_error($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);            

            var_dump($info['http_code']);
            if ($info['http_code'] == "200"){
                return $this->returnResponse(null, $ret, true);
            }
            else{
                return $this->returnResponse('Errors $info["http_code"]'.$err, null);
            }
        } else {
            return $this->returnResponse($error, null);
        }
    }

    private function returnResponse($error, $ret, $response = false)
    {
        return new Response(array('response' => $response, 'error' => $error, 'xml' => $ret));
    }
}