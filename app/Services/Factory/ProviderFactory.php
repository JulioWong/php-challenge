<?php
namespace App\Services\Factory;

use App\Services;

class ProviderFactory {

	public static function getProvider($name) {
		switch($name) {
			case 'Provider1':
				return new ProviderService1();
				break;
			case 'Provider2':
				return new ProviderService2();
				break;
		}
	}
}