<?php

namespace Nether\Storage;

use Nether\Common;
use Nether\Common\Datastore;

class Library
extends Common\Library {

	public const
	ConfStorageLocations = 'Nether.Storage.Locations';

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	OnLoad(...$Argv):
	void {

		static::$Config->BlendRight([
			static::ConfStorageLocations => []
		]);

		return;
	}

}
