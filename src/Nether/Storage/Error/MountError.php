<?php

namespace Nether\Storage\Error;

use Nether\Storage;

use Exception;

class MountInvalidError
extends Exception {

	public function
	__Construct(?Storage\Manager $Manager, string $Mount) {
		parent::__Construct("{$Mount} is not a vaild mountpoint");
		return;
	}

}
