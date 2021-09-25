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
    	view('Groups/view.html.twig', ['groups' => $groups, 'flasher' => $this->flasher]);
    }

	public function addForm()
	{
		view('Groups/add.html.twig', ['flasher' => $this->flasher]);
	}

    public function edit($id)
	{
		$group = $this->database->findById('groups', $id);
		view('Groups/edit.html.twig', ['group' => $group, 'flasher' => $this->flasher]);
	}

	public function update($id)
	{
		$validator = v::key('name', v::stringType()->notEmpty()->length(5, 10));
		$this->validate($validator);

		$data = ['name' => $_POST['name']];

		$this->database->update('groups', $id, $data);
		$this->flasher->success('Группа успешно обновлена!');


//		return redirect('/groups');
	}

	public function store()
	{
		$data = ['name' => $_POST['name']];

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

	private function validate($validator)
	{
		try
		{
			$validator->assert('Привет');
		} catch (ValidationException $exception)
		{
			$exception->getMessage();
			$this->flasher->error('');

			return redirect('/groups');
		}
	}


}