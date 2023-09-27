<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {

 public $data; 
	
	public function index()
	{
		
		$date = new DateTime('01/01/2015'); 
		$startdate = $date->format('U');	
		
		$today = new DateTime('now');
		$enddate = $today->format('U');
		
		$this->getdata($startdate,$enddate);
		
		$this->load->view('taskview');
	}
	public function getdata($startdate,$enddate) {
		
        $url = "https://demo.flexmms.com/v3/api/incidents/";
        $token = "SzVlZGUwYzdjMTg1Y2M4LjM2NTM5MzYw";

        $postData = array(
            "view" => "detailed",
            "start" => $startdate,
            "end" => $enddate
        );
        $fields = json_encode($postData);

        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_HTTPHEADER, 
            array(
                'api-key: '.$token ,
				'Content-Type: application/json', 
                ));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_CAINFO, "cacert.pem");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        curl_close($ch);
		echo $err = curl_error($ch);
		echo $result;
        return $result;
}
}
