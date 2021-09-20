<?php

namespace App\Services;

use Latitude\QueryBuilder\QueryFactory;

class Database
{
	private $pdo;
	private $table;
	private $queryFactory;

	public function __construct(PDO $pdo, QueryFactory $queryFactory)
	{
		$this->pdo = $pdo;
		$this->queryFactory = $queryFactory;
	}

	public function all($table, $limit = null)
	{
		$select = $this->queryFactory->select('*')->from($table)->limit($limit)->compile();

		$stn = $this->pdo->preapere($select->sql())->execute($select->params());

		return $stn->fetchAll(\PDO::FETCH_ASSOC);
	}

}