<?php
class ApiRequest
{
    private $apiUrl;
    private $headers;
    private $curl;

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
        $this->headers = [];
        $this->curl = curl_init($this->apiUrl);
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function sendRequest($method = 'POST', $data = null)
    {
        // Set cURL options
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);

        if ($data) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        // Execute the cURL request
        $response = curl_exec($this->curl);

        if ($response === false) {
            throw new Exception(curl_error($this->curl));
        }

        // Close cURL session
        curl_close($this->curl);

        return $response;
    }
}
try {
    $apiUrl = 'https://demo.flexmms.com/v3/api/incidents';
    $headers = [
        'Content-Type: application/json',
        'api-key: Bearer SzVlZGUwYzdjMTg1Y2M4LjM2NTM5MzYw',
    ];
	
    $apiRequest = new ApiRequest($apiUrl);
    $apiRequest->setHeaders($headers);
	
	$date = new DateTime('01/01/2015'); 
	$startdate = $date->format('U');	
		
	$today = new DateTime('now');
	$enddate = $today->format('U');
		
   
    $postData = ['view' => 'detailed','start'=>$startdate,'end'=>$enddate];
    $postResponse = $apiRequest->sendRequest('POST', $postData);

    var_dump($postResponse);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>