<?php
namespace App;

use App\Interfaces\CarrierInterface;
use App\Services\ContactService;
use App\Services\Factory\ProviderFactory;

class Mobile
{

	protected $provider;
	
	function __construct(CarrierInterface $provider)
	{
		$this->provider = $provider;
	}

	public function makeCallByName($name = '')
	{
		if( empty($name) ) return;

		$contact = ContactService::findByName($name);

		if(empty($contact)) return;
		
		$this->provider->dialContact($contact);
		return $this->provider->makeCall();
	}

	public function sendSMSByNumber($number, $body) {
		$validNumber = ContactService::validateNumber($number);

		if (empty($body)) return;

		if ($validNumber) {
			return $this->provider->sendSMS($number, $body);
		}
	}
}
