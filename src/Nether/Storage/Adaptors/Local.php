<?php

namespace Nether\Storage\Adaptors;

use Nether\Storage;

class Local
extends Storage\Adaptor {

	public function
	__Construct(string $Name, string $Root) {
		parent::__Construct($Name, $Root);
		return;
	}

	public function
	Exists(string $File):
	bool {

		return file_exists($this->GetPath($File));
	}

	public function
	Get(string $File):
	mixed {

		if(!$this->Exists($File))
		return NULL;

		////////

		$Output = file_get_contents($File);

		if($Output === FALSE)
		throw new Storage\Error\ReadError($this, $File);

		////////

		return $Output;
	}

}

