<?php

namespace Nether\Storage;

class Adaptor {

	public string
	$Name;

	public string
	$Root;

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	__Construct(string $Name, string $Root='/') {
		$this->Name = $Name;
		$this->Root = $Root;
		return;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	Exists(string $Path):
	bool {

		return FALSE;
	}

	public function
	Get(string $Path):
	mixed {

		throw new Error\ReadError($this, $Path);

		return NULL;
	}

	public function
	Put(string $Path, mixed $Data):
	static {

		throw new Error\WriteError($this, $Path);

		return $this;
	}

	public function
	Delete(string $Path):
	static {

		throw new Error\DeleteError($this, $Path);

		return $this;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	GetPath(string $Path):
	string {

		$Path = ltrim($Path, '/');

		return sprintf('%s/%s', $this->Root, $Path);
	}

}
