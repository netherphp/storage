<?php

namespace Nether\Storage\Adaptors;

use Nether\Common;
use Nether\Storage;

class Local
extends Storage\Adaptor {

	public function
	__Construct(string $Name, string $Root) {
		parent::__Construct($Name, $Root);
		return;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	Exists(string $Path):
	bool {

		$Fullpath = $this->GetPath($Path);

		return file_exists($Fullpath);
	}

	public function
	Get(string $Path):
	mixed {

		if(!$this->Exists($Path))
		return NULL;

		////////

		$Fullpath = $this->GetPath($Path);
		$Output = file_get_contents($Fullpath);

		if($Output === FALSE)
		throw new Storage\Error\ReadError($this, $Fullpath);

		////////

		return $Output;
	}

	public function
	Put(string $Path, mixed $Data):
	static {

		$Fullpath = $this->GetPath($Path);
		$Dir = dirname($Fullpath);

		// if this dir does not exist can we make it exist?

		if(!is_dir($Dir))
		if(!Common\Filesystem\Util::MkDir($Dir))
		throw new Storage\Error\WriteError($this, $Dir);

		// if this dir exists are we allowed to write to it?

		if(!is_writable($Dir))
		throw new Storage\Error\WriteError($this, $Dir);

		// write it.

		file_put_contents($Fullpath, $Data);

		return $this;
	}

	public function
	Delete(string $Path):
	static {

		$Fullpath = $this->GetPath($Path);
		$Dir = dirname($Fullpath);

		if(!is_writable($Dir))
		throw new Storage\Error\DeleteError($this, $Dir);

		unlink($Fullpath);

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

