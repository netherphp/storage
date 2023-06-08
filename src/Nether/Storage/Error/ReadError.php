<?php

namespace Nether\Storage\Error;

use Nether\Storage;

use Exception;

class ReadError
extends Exception {

	public function
	__Construct(?Storage\Adaptor $Adaptor, string $Path) {
		parent::__Construct("Error reading {$Path} from {$Adaptor->Name}");
		return;
	}

}
