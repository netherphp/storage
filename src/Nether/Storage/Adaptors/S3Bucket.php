<?php

namespace Nether\Storage\Adaptors;

use Aws;
use Nether\Storage;

class S3Bucket
extends Storage\Adaptor {

	public string
	$Bucket;

	public string
	$Root;

	protected
	$Client;

	public function
	__Construct(string $Name, string $Bucket, string $Root='/') {
		parent::__Construct($Name, $Root);

		$this->Bucket = $Bucket;
		//$this->Client = new Aws\S3\S3Client([]);

		return;
	}

}
