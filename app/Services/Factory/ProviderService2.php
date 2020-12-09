<?php

namespace App\Services;

use App\Contact;
use App\Call;
use App\Interfaces;

class ProviderService2 implements CarrierInterface
{
	
	public function dialContact(Contact $contact)
	{
        return true;
	}

	public function makeCall(string $number): Call
	{
		return Call();
	}

	public function sendSMS($name, $body)
	{
        return true;
	}
}