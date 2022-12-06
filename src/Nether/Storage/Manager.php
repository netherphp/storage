<?php

namespace Nether\Storage;

use Nether\Object\Datastore;

class Manager {

	public Datastore
	$Locations;

	public function
	__Construct(Datastore $Config) {

		$this->Locations = new Datastore;

		$this->Prepare($Config);

		return;
	}

	public function
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

}
