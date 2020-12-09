<?php

namespace Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;

use App\Mobile;
use App\Call;
use App\Contact;

class MobileTest extends TestCase
{
	/** @test */
	public function it_returns_null_when_name_empty()
	{
		$provider = m::mock('App\Interfaces\CarrierInterface');
		$provider->shouldReceive('dialContact')->andReturn(true);

		$mobile = new Mobile($provider);
		$this->assertNull($mobile->makeCallByName(''));
	}

	/** 
	 * @test 
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled*/
	public function it_returns_call_when_name_not_empty()
	{
		$service = m::mock('overload:App\Services\ContactService');
		$service->shouldReceive('findByName')->andReturn(new Contact());

		$provider = m::mock('App\Interfaces\CarrierInterface');
		$provider->shouldReceive('dialContact')->andReturn(true);
		$provider->shouldReceive('makeCall')->andReturn(new Call());

		$mobile = new Mobile($provider);

		$this->assertEquals(new Call(), $mobile->makeCallByName('Julio Wong'));
	}

	/** 
	 * @test 
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled*/
	public function it_returns_null_when_name_not_found()
	{
		$service = m::mock('overload:App\Services\ContactService');
		$service->shouldReceive('findByName')->andReturn(null);

		$provider = m::mock('App\Interfaces\CarrierInterface');
		$provider->shouldReceive('dialContact')->andReturn(true);
		$provider->shouldReceive('makeCall')->andReturn(new Call());

		$mobile = new Mobile($provider);

		$this->assertNull($mobile->makeCallByName('Juan Perez'));
	}

	/** 
	 * @test 
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled*/
	public function it_returns_true_when_sendSMS()
	{
		$service = m::mock('overload:App\Services\ContactService');
		$service->shouldReceive('validateNumber')->andReturn(true);

		$provider = m::mock('App\Interfaces\CarrierInterface');
		$provider->shouldReceive('sendSMS')->andReturn(true);

		$mobile = new Mobile($provider);

		$this->assertEquals(true, $mobile->sendSMSByNumber('954127922', 'Mensaje de prueba'));
	}
}
