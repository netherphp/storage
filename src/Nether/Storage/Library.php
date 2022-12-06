<?php

namespace Nether\Storage;

use Nether\Common;
use Nether\Object\Datastore;

class Library
extends Common\Library {

	public const
	ConfStorageLocations = 'Nether.Storage.Locations';

	static public function
	Init(...$Argv):
	void {

		static::OnInit(...$Argv);
		return;
	}

	static public function
	InitDefaultConfig(?Datastore $Config=NULL):
	Datastore {

		if($Config === NULL)
		$Config = new Datastore;

		$Config->BlendRight([
			static::ConfStorageLocations => []
		]);

		return $Config;
	}

	static public function
	OnInit(?Datastore $Config=NULL, ...$Argv):
	void {

		static::InitDefaultConfig($Config);

		return;
	}

}
