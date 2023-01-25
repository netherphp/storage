<?php

namespace Nether\Storage;

use Nether\Common\Datastore;

class Manager {

	public Datastore
	$Locations;

	public function
	__Construct(Datastore $Config) {

		$this->Locations = new Datastore;

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
		$this->Locations->Shove($Inst->Name, $Inst);

		return;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	Exists(string $Mount, string $Path):
	bool {

		if(!$this->Locations->HasKey($Mount))
		return FALSE;

		return $this->Locations[$Mount]->Exists($Path);
	}

	public function
	Get(string $Mount, string $Path):
	mixed {

		if(!$this->Locations->HasKey($Mount))
		throw new Error\MountInvalidError($this, $Mount);

		if(str_starts_with($Path, '/'))
		$Path = ltrim($Path, '/');

		return $this->Locations[$Mount]->Get($Path);
	}

	public function
	Put(string $Mount, string $Path, mixed $Data):
	static {

		if(!$this->Locations->HasKey($Mount))
		throw new Error\MountInvalidError($this, $Mount);

		if(str_starts_with($Path, '/'))
		$Path = ltrim($Path, '/');

		$this->Locations[$Mount]->Put($Path, $Data);

		return $this;
	}

	public function
	Delete(string $Mount, string $Path):
	static {

		if(!$this->Locations->HasKey($Mount))
		throw new Error\MountInvalidError($this, $Mount);

		if(str_starts_with($Path, '/'))
		$Path = ltrim($Path, '/');

		$this->Locations[$Mount]->Delete($Path);

		return $this;
	}

}
