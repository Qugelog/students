<?php

namespace App\Controllers;

class SubjectController extends Controller
{
	public function show()
	{
		$subjects = $this->database->all('subjects');
		view('Subjects/view.html.twig', ['subjects' => $subjects, 'flasher' => $this->flasher]);
	}

	public function addForm()
	{
		$subjects = $this->database->all('subjects');
		view('Subjects/add.html.twig', ['subjects' => $subjects, 'flasher' => $this->flasher]);
	}

	public function edit($id)
	{
		$subject = $this->database->findById('subjects', $id);

		view('Subjects/edit.html.twig', ['subject' => $subject, 'flasher' => $this->flasher]);
	}

	public function update($id)
	{
		$data = ['name' => $_POST['name']];

		validateStringField('name', '5', '50', 'Введите название предмета!');

		$this->database->update('subjects', $id, $data);
		$this->flasher->success('Предмет успешно обновлен!');

		return redirect('/subjects');
	}

	public function store()
	{
		$data = ['name' => $_POST['name'],];

		validateStringField('name', '5', '50', 'Введите название предмета!');

		$this->database->create('subjects', $data);
		$this->flasher->success('Предмет успешно добавлен!');

		return back();
	}

	public function remove($id)
	{
		$this->database->delete('subjects', $id);
		$this->flasher->error('Предмет успешно удален!');

		return back();
	}
}