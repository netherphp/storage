<?php

namespace Nether\Storage;

use Nether\Common\Datastore;

class Manager {

	static public Datastore
	$Locations;

	public function
	__Construct(?Datastore $Config=NULL) {

		if(!isset(static::$Locations))
		static::$Locations = new Datastore;

		if($Config !== NULL)
		$this->Prepare($Config);

		return;
	}

	protected function
	Prepare(Datastore $Config):
	void {

		$Found = $Config[Library::ConfStorageLocations] ?: NULL;
		$Inst = NULL;

		if($Found)
		foreach($Found as $Inst)
		if($Inst instanceof Adaptor)
		static::$Locations->Shove($Inst->Name, $Inst);

		return;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	Location(string $Mount):
	?Adaptor {

		return static::$Locations[$Mount];
	}

	public function
	HasLocation(string $Mount):
	bool {

		return static::$Locations->HasKey($Mount);
	}

	public function
	GetLocations():
	Datastore {

		return static::$Locations->Map(fn($L)=> $L);
	}

	public function
	Exists(string $Mount, string $Path):
	bool {

		if(!static::$Locations->HasKey($Mount))
		return FALSE;

		return static::$Locations[$Mount]->Exists($Path);
	}

	public function
	Get(string $Mount, string $Path):
	mixed {

		if(!static::$Locations->HasKey($Mount))
		throw new Error\MountInvalidError($this, $Mount);

		if(str_starts_with($Path, '/'))
		$Path = ltrim($Path, '/');

		return static::$Locations[$Mount]->Get($Path);
	}

	public function
	Put(string $Mount, string $Path, mixed $Data):
	static {

		if(!static::$Locations->HasKey($Mount))
		throw new Error\MountInvalidError($this, $Mount);

		if(str_starts_with($Path, '/'))
		$Path = ltrim($Path, '/');

		static::$Locations[$Mount]->Put($Path, $Data);

		return $this;
	}

	public function
	Delete(string $Mount, string $Path):
	static {

		if(!static::$Locations->HasKey($Mount))
		throw new Error\MountInvalidError($this, $Mount);

		if(str_starts_with($Path, '/'))
		$Path = ltrim($Path, '/');

		static::$Locations[$Mount]->Delete($Path);

		return $this;
	}

	public function
	Count(string $Mount, string $Path):
	int {

		if(!static::$Locations->HasKey($Mount))
		throw new Error\MountInvalidError($this, $Mount);

		if(str_starts_with($Path, '/'))
		$Path = ltrim($Path, '/');

		return static::$Locations[$Mount]->Count($Path);
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	static public function
	GetAdaptorByURL(string $URL):
	?Adaptor {

		$RegEx = '#storage://([^/]+)#';
		$Found = NULL;

		if(!preg_match($RegEx, $URL, $Found))
		return NULL;

		if(!static::$Locations->HasKey([$Found[1]]))
		return NULL;

		return static::$Locations->Get($Found[1]);
	}

	static public function
	GetFileByURL(string $URL):
	?File {

		$RegEx = '#storage://([^/]+)(/.+)#';
		$Found = NULL;

		if(!preg_match($RegEx, $URL, $Found))
		return NULL;

		if(!static::$Locations->HasKey($Found[1]))
		return NULL;

		$Storage = static::$Locations[$Found[1]];

		if(!$Storage)
		return NULL;

		$File = $Storage->GetFileObject(ltrim($Found[2], '/'));
		if(!$File)
		return NULL;

		return $File;
	}

}
