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

	public function
	Size(string $Path):
	int {

		throw new Error\ReadError($this, $Path);

		return 0;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	GetDirPath(string $Path):
	string {

		$Dir = dirname($Path);

		if($Dir === '.')
		$Dir = '';

		return $Dir;
	}

	public function
	GetFileObject(string $Path):
	File {

		return new File($this, $Path);
	}

	public function
	GetStorageURL(string $Path):
	string {

		return sprintf(
			'storage://%s/%s',
			$this->Name,
			$Path
		);
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	// ...

}
