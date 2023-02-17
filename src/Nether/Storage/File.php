<?php

namespace Nether\Storage;

use FileEye;
use Nether\Common;

use Exception;

class File {

	public Adaptor
	$Storage;

	public string
	$Path;

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	__Construct(Adaptor $Storage, string $Path) {

		$this->Storage = $Storage;
		$this->Path = $Path;

		return;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	GetExtension():
	?string {

		if(str_contains($this->Path, '.'))
		return strtolower(substr(
			$this->Path,
			(strrpos($this->Path, '.') + 1)
		));

		NULL;
	}

	public function
	GetStorageURL():
	string {

		return $this->Storage->GetStorageURL($this->Path);
	}

	public function
	GetPublicURL():
	string {

		return $this->Storage->GetPublicURL($this->Path);
	}

	public function
	GetParentDirectory():
	string {

		return dirname($this->Path);
	}

	public function
	GetType():
	string {

		$Type = match(TRUE) {
			$this->IsImage()
			=> 'img',

			default
			=> 'file'
		};

		return $Type;
	}

	public function
	GetSize():
	int {

		return $this->Storage->Size($this->Path);
	}

	public function
	GetSizeReadable():
	string {

		$Bytes = new Common\Units\Bytes($this->GetSize());

		return $Bytes->Get();
	}

	public function
	IsImage():
	bool {

		try {
			$Ext = new FileEye\MimeMap\Extension(
				$this->GetExtension() ?? 'txt'
			);

			if(str_starts_with($Ext->GetDefaultType(), 'image/'))
			return TRUE;
		}

		catch(Exception $Error) { }

		return FALSE;
	}

	public function
	SetName(string $Name):
	static {

		$this->Path = sprintf('%s/%s', dirname($this->Path), $Name);
		return $this;
	}

	public function
	SetPath(string $Path):
	static {

		$this->Path = $Path;
		return $this;
	}

	public function
	New(string $Name):
	static {

		$Output = clone($this);
		$Output->SetName($Name);

		return $Output;
	}


	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	Read():
	mixed {

		return $this->Storage->Get($this->Path);
	}

	public function
	Write(string $Data):
	void {

		$this->Storage->Put($this->Path, $Data);
		$this->Storage->Chmod($this->Path, 0666);

		return;
	}

	public function
	Delete():
	void {

		$this->Storage->Delete($this->Path);
		return;
	}

	public function
	DeleteParentDirectory():
	void {

		$Dir = $this->Storage->GetDirPath($this->Path);
		//print_r($Dir);

		$this->Storage->Delete($Dir);
		return;
	}

}
