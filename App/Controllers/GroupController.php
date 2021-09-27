<?php

namespace App\Controllers;


use Flasher\Prime\Flasher;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class GroupController extends Controller
{
    public function show()
    {
    	$groups = $this->database->all('groups');
    	view('Groups/view.twig', ['groups' => $groups, 'flasher' => $this->flasher]);
    }

	public function addForm()
	{
		view('Groups/add.twig', ['flasher' => $this->flasher]);
	}

    public function edit($id)
	{
		$group = $this->database->findById('groups', $id);
		view('Groups/edit.html.twig', ['group' => $group, 'flasher' => $this->flasher]);
	}

	public function update($id)
	{
		validateStringField('name', '5', '10');

		$data = ['name' => $_POST['name']];

		$this->database->update('groups', $id, $data);
		$this->flasher->success('Группа успешно обновлена!');


		return redirect('/groups');
	}

	public function store()
	{
		$data = ['name' => $_POST['name']];

		validateStringField('name', '5', '10');

		$this->database->create('groups', $data);
		$this->flasher->success('Группа успешно добавлена!');

		return back();
	}

	public function remove($id)
	{
		$this->database->delete('groups', $id);
		$this->flasher->error('Группа успешно удалена!');

		return back();
	}


}