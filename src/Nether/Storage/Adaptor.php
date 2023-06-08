<?php

namespace Nether\Storage;

use Nether\Common;

class Adaptor {

	public string
	$Name;

	public string
	$Root;

	public ?string
	$URL;

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	__Construct(string $Name, string $Root='/opt/data', ?string $URL=NULL) {
		$this->Name = $Name;
		$this->Root = $Root;
		$this->URL = $URL;

		$this->OnReady();
		return;
	}

	protected function
	OnReady():
	void {

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
	List(string $Path):
	Common\Datastore {

		throw new Error\ReadError($this, $Path);

		$Output = new Common\Datastore;
		return $Output;
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

	public function
	Count(string $Path):
	int {

		throw new Error\ReadError($this, $Path);

		return 0;
	}

	public function
	Rename(string $Old, string $New):
	static {

		throw new Error\WriteError($this, $New);

		return $this;
	}

	public function
	Chmod(string $Path, int $Mode):
	static {

		throw new Error\WriteError($this, $Path);


		return $this;
	}

	public function
	Append(string $Path, mixed $Data):
	static {

		throw new Error\WriteError($this, $Path);

		return $this;
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

	public function
	GetPublicURL(string $Path):
	string {

		$Path = str_replace('{Path}', $Path, $this->URL);

		return $Path;
	}

	public function
	GetAdaptorDescription():
	string {

		return $this->Name;
	}

	public function
	Unroot(string $Path):
	string {

		$Result = ltrim(preg_replace(
			sprintf('#^%s#', preg_quote($this->Root, '#')),
			'',
			$Path
		),'/');

		return $Result;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	// ...

}
