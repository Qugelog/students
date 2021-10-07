<?php

namespace App\Services;


use Aura\SqlQuery\QueryFactory;
use PDO;

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

	/**
	 * @param string $table
	 * @param int|null $limit
	 * @return array|false
	 */
	public function all(string $table, int $limit = null)
	{
		$select = $this->queryFactory->newSelect();
		$select->cols(['*'])
			->from($table)
			->limit($limit);

		$sth = $this->pdo->prepare($select->getStatement());

		$sth->execute($select->getBindValues());

		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * @param $table
	 * @param $id
	 * @return mixed
	 */
	public function findById($table, $id)
	{
		$select = $this->queryFactory->newSelect();
		$select->cols(['*'])
			->from($table)
			->where('id = :id')
			->bindValue('id', $id);

		$sth = $this->pdo->prepare($select->getStatement());

		$sth->execute($select->getBindValues());

		return $sth->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * @param $table
	 * @param $cols
	 * @return mixed
	 */
	public function find($table, $cols)
	{
		$select = $this->queryFactory->newSelect();
		$select->cols($cols)
			->fromRaw($table);

		$stn = $this->pdo->prepare($select->getStatement());

		var_dump($stn);

		$stn->execute($select->getBindValues());

		return $stn->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * @param $table
	 * @param $data
	 * @return string
	 */
	public function create($table, $data)
	{
		$insert = $this->queryFactory->newInsert();
		$insert
			->into($table)
			->cols($data);

		$sth = $this->pdo->prepare($insert->getStatement());

		$sth->execute($insert->getBindValues());

		$name = $insert->getLastInsertIdName('id');
		return $this->pdo->lastInsertId($name);
	}

	/**
	 * @param $table
	 * @param $id
	 * @param $data
	 */
	public function update($table, $id, $data)
	{
		$update = $this->queryFactory->newUpdate();

		$update
			->table($table)                  // update this table
			->cols($data)
			->where('id = :id')
			->bindValue('id', $id);

		$sth = $this->pdo->prepare($update->getStatement());

		$sth->execute($update->getBindValues());
	}

	/**
	 * @param $table
	 * @param $id
	 */
	public function delete($table, $id)
	{
		$delete = $this->queryFactory->newDelete();

		$delete
			->from($table)
			->where('id = :id')
			->bindValue('id', $id);

		$sth = $this->pdo->prepare($delete->getStatement());

		$sth->execute($delete->getBindValues());
	}
}