<?php

namespace Nether\Storage;

use FileEye;

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
		return substr($this->Path, (strrpos($this->Path, '.') + 1));

		NULL;
	}

	public function
	GetStorageURL():
	string {

		return $this->Storage->GetStorageURL($this->Path);
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

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	Read():
	mixed {

		return $this->Storage->Get($this->Path);
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
