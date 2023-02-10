<?php

namespace Nether\Storage\Adaptors;

use Nether\Common;
use Nether\Storage;

class Local
extends Storage\Adaptor {

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

		$Bytes = file_put_contents($Fullpath, $Data);

		if($Bytes === FALSE)
		throw new Storage\Error\WriteError($this, $Path);

		return $this;
	}

	public function
	Delete(string $Path):
	static {

		$Fullpath = $this->GetPath($Path);
		$Dir = dirname($Fullpath);

		////////

		if(is_dir($Fullpath)) {
			Common\Filesystem\Util::RmDir($Fullpath);
			return $this;
		}

		////////

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

	public function
	Rename(string $Old, string $New):
	static {

		$OldPath = $this->GetPath($Old);
		$NewPath = $this->GetPath($New);
		$Dir = dirname($NewPath);

		////////

		if(!file_exists($OldPath))
		throw new Storage\Error\ReadError($this, $OldPath);

		if(!is_dir($Dir))
		if(!Common\Filesystem\Util::MkDir($Dir))
		throw new Storage\Error\WriteError($this, $Dir);

		////////

		rename($OldPath, $NewPath);

		if(!file_exists($NewPath))
		throw new Storage\Error\WriteError($this, $NewPath);

		return $this;
	}

	public function
	Chmod(string $Path, int $Mode):
	static {

		$UMask = umask(0);
		chmod($this->GetPath($Path), $Mode);
		umask($UMask);

		return $this;
	}

	public function
	Append(string $Path, mixed $Data):
	static {

		$Fullpath = $this->GetPath($Path);

		if(!file_exists($Fullpath))
		throw new Storage\Error\ReadError($this, $Fullpath);

		if(!is_writable($Fullpath))
		throw new Storage\Error\WriteError($this, $Fullpath);

		////////

		file_put_contents($Fullpath, $Data, FILE_APPEND);
		return $this;
	}

	public function
	Size(string $Path):
	int {

		$Fullpath = $this->GetPath($Path);

		if(!file_exists($Fullpath))
		throw new Storage\Error\ReadError($this, $Fullpath);

		return filesize($Fullpath);
	}

}

