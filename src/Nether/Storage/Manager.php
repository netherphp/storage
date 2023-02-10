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

}
