<?php

namespace Nether\Storage\Error;

use Nether\Storage;

use Exception;

class WriteError
extends Exception {

	public function
	__Construct(Storage\Adaptor $Adaptor, string $Path) {
		parent::__Construct("Error writing {$Path} to {$Adaptor->Name}");
		return;
	}

}
