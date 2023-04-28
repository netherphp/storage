<?php

namespace Nether\Storage\Adaptors;

use Aws;
use Nether\Common;
use Nether\Storage;

class S3Bucket
extends Storage\Adaptor {

	const
	AccessPublic = 'public-read',
	AccessPrivate = 'private';

	public string
	$Bucket;

	protected string
	$PubKey;

	protected string
	$PrivKey;

	protected string
	$Region;

	protected string
	$ACL;

	protected
	$Client;

	public function
	__Construct(
		string $Name,
		string $Bucket,
		string $PubKey,
		string $PrivKey,
		string $Region,
		string $ACL=self::AccessPublic,
		string $Root='/',
		?string $URL=NULL
	) {

		$this->Name = $Name;
		$this->Root = $Root;
		$this->URL = $URL;

		$this->Bucket = $Bucket;
		$this->PubKey = $PubKey;
		$this->PrivKey = $PrivKey;
		$this->Region = $Region;
		$this->ACL = $ACL;
		$this->Client = $this->GetClient();

		$this->OnReady();
		return;
	}

	public function
	__DebugInfo():
	array {

		return [
			'Name'    => $this->Name,
			'Bucket'  => $this->Bucket,
			'Region'  => $this->Region,
			'ACL'     => $this->ACL,
			'PubKey'  => Common\Values::DebugProtectValue($this->PubKey),
			'PrivKey' => Common\Values::DebugProtectValue($this->PrivKey)
		];
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	Exists(string $Path):
	bool {

		$Exists = $this->Client->DoesObjectExistV2(
			$this->Bucket,
			$Path
		);

		return $Exists;
	}

	public function
	Put(string $Path, mixed $Data):
	static {

		// it seems like directories are just kind of magic in the s3
		// buckets so not testing for them atm.

		$this->Client->PutObject([
			'Bucket' => $this->Bucket,
			'ACL'    => $this->ACL,
			'Key'    => ltrim($Path, '/'),
			'Body'   => $Data
		]);

		return $this;
	}

	public function
	Get(string $Path):
	mixed {

		if(!$this->Exists($Path))
		return NULL;

		////////

		$Result = $this->Client->GetObject([
			'Bucket' => $this->Bucket,
			'Key'    => $Path
		]);

		if(!$Result || !isset($Result['Body']))
		throw new Storage\Error\ReadError($this, $Path);

		////////

		$Data = $Result['Body']->GetContents();
		//var_dump($Data);

		return $Data;
	}

	public function
	Delete(string $Path):
	static {

		$this->Client->DeleteObject([
			'Bucket' => $this->Bucket,
			'ACL'    => $this->ACL,
			'Key'    => ltrim($Path, '/')
		]);

		return $this;
	}

	public function
	Size(string $Path):
	int {

		$Head = $this->Client->HeadObject([
			'Bucket' => $this->Bucket,
			'Key'    => ltrim($Path, '/')
		]);

		return $Head['ContentLength'];
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	GetClient():
	Aws\S3\S3Client {

		return
		new Aws\S3\S3Client([
			'version'     => 'latest',
			'region'      => $this->Region,
			'credentials' => [
				'key'    => $this->PubKey,
				'secret' => $this->PrivKey
			]
		]);
	}

	public function
	GetPublicURL(string $Path):
	string {

		$Path = parent::GetPublicURL($Path);

		$Tokens = [
			'{Bucket}' => $this->Bucket,
			'{Region}' => $this->Region
		];

		$Path = array_reduce(
			array_keys($Tokens),
			fn(string $P, string $T)=> str_replace($T, $Tokens[$T], $P),
			$Path
		);

		return $Path;
	}

	public function
	GetAdaptorDescription():
	string {

		return sprintf('%s (%s)', $this->Name, $this->Bucket);
	}

}
