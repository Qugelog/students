<?php

namespace App\Controllers;


class ScoreController extends Controller
{
	public function show()
	{
		$select = $this->queryFactory->newSelect();
		$select->cols(['students.id AS student_id', 'full_name', 'subjects.name AS sname', 'subjects.id AS subject_id', 'scores.score AS score', 'scores.id AS score_id'])
			->from('students')
			->join('INNER', 'subjects')
			->join('LEFT', 'scores', 'subjects.id = scores.subject_id AND students.id = scores.student_id')
			->orderBy(['students.full_name']);

		$stn= $this->pdo->prepare($select->getStatement());

		$stn->execute($select->getBindValues());

		$scores = $stn->fetchAll(\PDO::FETCH_ASSOC);

		view('Scores/view.html.twig', ['scores' => $scores, 'flasher' => $this->flasher]);
	}

	public function addForm()
	{
		$students = $this->database->all('students');
		$subjects = $this->database->all('subjects');

		view('Scores/add.html.twig', ['students' => $students, 'subjects' => $subjects, 'flasher' => $this->flasher]);
	}

	public function edit($id)
	{

		$select = $this->queryFactory->newSelect();
		$select->cols(['*'])
			->from('scores')
			->where('id = :id')
			->bindValues(['id' => $id]);


		$stn = $this->pdo->prepare($select->getStatement());
		$stn->execute($select->getBindValues());

		$score = $stn->fetch(\PDO::FETCH_ASSOC);

		view('Scores/edit.html.twig', ['score' => $score, 'flasher' => $this->flasher]);
	}

	public function update($id)
	{

		$data = [
			'id' => $_POST['id'],
			'score' => $_POST['score']
		];

		$update = $this->queryFactory->newUpdate();
		$update->table('scores')
				->cols($data)
				->where('id = :id')
				->bindValues(['id' => $id]);

		$stn = $this->pdo->prepare($update->getStatement());

		$stn->execute($update->getBindValues());

		$this->flasher->success('Балл успешно обновлен!');

		return redirect('/scores');
	}

	public function store()
	{
		$data = [
			'student_id' => $_POST['student'],
			'subject_id' => $_POST['subject'],
			'score' => $_POST['score']
		];

		$this->database->create('scores', $data);
		$this->flasher->success('Балл успешно выставлен!');

		return back();
	}

	public function remove($id)
	{
		$this->database->delete('scores', $id);
		$this->flasher->error('Балл успешно удален!');

		return back();
	}
}