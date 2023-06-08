<?php

namespace Nether\Storage\Struct;

use Nether\Common;

use Nether\Storage\Library;

class LibraryConfigInfo {

	public Common\Datastore
	$ConfigKeys;

	public Common\Datastore
	$Services;

	public function
	__Construct() {

		$this->ConfigKeys = new Common\Datastore([
			'Storage\Library::ConfStorageLocations' => 'array<Storage\Adaptor>'
		]);

		$this->Services = new Common\Datastore([
			'Local Filesystem'
			=> new ServiceConfigInfo([
				'Class'      => 'Storage\Adaptors\Local',
				'ConfigKeys' => new Common\Datastore([
					'Name' => 'string (Alias used to query Storage Manager)',
					'Root' => 'string (Directory to store data)',
					'URL'  => 'string (Template using {Path} to generate public URLs)'
				])
			]),
			'S3 Bucket'
			=> new ServiceConfigInfo([
				'Class'      => 'Storage\Adaptors\S3Bucket',
				'ConfigKeys' => new Common\Datastore([
					'Name'    => 'string (Alias used to query Storage Manager)',
					'Bucket'  => 'string',
					'Region'  => 'string',
					'ACL'     => 'string',
					'URL'     => 'string (Template using {Bucket}, {Region}, and {Path})',
					'PubKey'  => 'string',
					'PrivKey' => 'string'
				])
			]),
			'DigitalOcean Space'
			=> new ServiceConfigInfo([
				'Class'      => 'Storage\Adaptors\DOBucket',
				'ConfigKeys' => new Common\Datastore([
					'Name'    => 'string (Alias used to query Storage Manager)',
					'Bucket'  => 'string',
					'Region'  => 'string',
					'ACL'     => 'string',
					'URL'     => 'string (Defaulted for DigitalOcean [non-CDN]. Same template tokens as S3Bucket.)',
					'PubKey'  => 'string',
					'PrivKey' => 'string'
				])
			])
		]);

		return;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////


}
