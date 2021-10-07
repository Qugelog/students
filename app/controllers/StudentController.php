<?php

namespace App\Controllers;


class StudentController extends Controller
{
	public function show()
	{
		$select = $this->queryFactory->newSelect();
		$select->cols(['students.id AS id', 'full_name', 'groups.name AS group'])
			->from('students')
			->join('INNER',  'groups', 'students.group_id = groups.id');


		$stn= $this->pdo->prepare($select->getStatement());

		$stn->execute($select->getBindValues());

		$students = $stn->fetchAll(\PDO::FETCH_ASSOC);

		view('Students/view.twig', ['students' => $students, 'flasher' => $this->flasher]);
	}

	public function addForm()
	{
		$groups = $this->database->all('groups');
		view('Students/add.twig', ['groups' => $groups, 'flasher' => $this->flasher]);
	}

	public function edit($id)
	{
		$select = $this->queryFactory->newSelect();
		$select->cols(['students.id AS id', 'full_name AS name', 'groups.name AS group'])
			->from('students')->where('students.id = :id')->bindValue('id', $id)
			->join('INNER',  'groups', 'students.group_id = groups.id');

		$stn= $this->pdo->prepare($select->getStatement());
		$stn->execute($select->getBindValues());
		$student = $stn->fetch(\PDO::FETCH_ASSOC);
		$groups = $this->database->all('groups');

		view('Students/edit.twig', ['student' => $student, 'flasher' => $this->flasher, 'groups' => $groups]);
	}

	public function update($id)
	{
		$data = [
			'full_name' => $_POST['name'],
			'group_id' => $_POST['group']
		];

		validateStringField('name', '5', '50', 'Заполните данные о студенте!');
		validateStringField('group', null, null, 'Выберите группу!');

		$this->database->update('students', $id, $data);
		$this->flasher->success('Студент успешно обновлен!');

		return redirect('/students');
	}

	public function store()
	{
		$data = [
			'full_name' => $_POST['name'],
			'group_id' => $_POST['group']
		];

		validateStringField('name', '5', '50', 'Заполните данные о студенте!');
		validateStringField('group', null, null, 'Выберите группу!');

		$this->database->create('students', $data);
		$this->flasher->success('Студент успешно добавлен!');

		return redirect('/students');
	}

	public function remove($id)
	{
		$this->database->delete('students', $id);
		$this->flasher->error('Студент успешно удален!');

		return back();
	}
}