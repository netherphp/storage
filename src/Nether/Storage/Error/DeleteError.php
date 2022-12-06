<?php

namespace Nether\Storage\Error;

use Nether\Storage;

use Exception;

class DeleteError
extends Exception {

	public function
	__Construct(Storage\Adaptor $Adaptor, string $Path) {
		parent::__Construct("Error deleting {$Path} from {$Adaptor->Name}");
		return;
	}

}
