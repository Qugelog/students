<?php

namespace App\Controllers;

class GroupsSubjectsController extends Controller
{

	public function show()
	{

		$groups = $this->database->all('groups');

		$select = $this->queryFactory->newSelect();

		$select->cols(['groups.id AS gid, subjects.id AS sid, groups.name AS gname, subjects.name AS sname'])
			  ->from('groups_subjects')
			  ->join('LEFT', 'groups', 'groups.id = groups_subjects.group_id')
			  ->join('LEFT', 'subjects', 'subjects.id = groups_subjects.subject_id')
			  ->where('groups.id = :id')
			  ->bindValue('id', (int) $_POST['group']);

		$stn= $this->pdo->prepare($select->getStatement());
		$stn->execute($select->getBindValues());
		$data = $stn->fetchAll(\PDO::FETCH_ASSOC);


		view('GroupsSubjects/show.twig', ['data' => $data, 'groups' => $groups]);

	}

	public function view()
	{

		$groups = $this->database->all('groups');

		view('GroupsSubjects/view.twig', ['groups' => $groups]);

	}

}