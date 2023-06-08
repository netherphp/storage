<?php

namespace Nether\Storage\Adaptors;

use Aws;
use Nether\Storage;

class DOBucket
extends Storage\Adaptors\S3Bucket {

	protected function
	OnReady():
	void {

		$this->URL ??= 'https://{Bucket}.{Region}.digitaloceanspaces.com/{Path}';

		return;
	}

	public function
	GetClient():
	Aws\S3\S3Client {

		return
		new Aws\S3\S3Client([
			'region'      => $this->Region,
			'endpoint'    => "https://{$this->Region}.digitaloceanspaces.com",
			'version'     => 'latest',
			'use_path_style_endpoint' => FALSE,
			'credentials' => [
				'key'    => $this->PubKey,
				'secret' => $this->PrivKey
			]
		]);
	}

}
