<?php

namespace App\Controllers;

class RatingController extends Controller
{

	public function showAll()
	{

		$groups = $this->database->all('groups');
		view('Rating/view.twig', ['groups' => $groups, 'flasher' => $this->flasher]);
	}

	public function showRating()
	{
		$select = $this->queryFactory->newSelect();

		$select->cols(['students.id AS student_id, students.full_name AS student, subjects.id AS subject_id, subjects.name AS subject_name, AVG(scores.score) AS score'])
				->from('groups')
				->join('INNER', 'groups_subject', 'groups_subject.group_id = groups.id')
				->join('INNER', 'subjects', 'subjects.id = groups_subject.subject_id')
				->join('INNER', 'students', 'groups.id = students.group_id')
				->join('LEFT', 'scores', 'scores.student_id = students.id AND scores.subject_id = subjects.id')
				->where('groups.id = :group')
				->groupBy(['subjects.name', 'student'])
				->orderBy(['subjects.name'])
				->bindValues(['group' => $_POST['group']]);

		$stn= $this->pdo->prepare($select->getStatement());

		$stn->execute($select->getBindValues());

		$data = $stn->fetchAll(\PDO::FETCH_ASSOC);

		$groups = $this->database->all('groups');



		$subjects = [];
		$students = [];
		$ratings = [];

		foreach ($data as $datum)
		{
			$subjects[$datum['subject_id']] = $datum['subject_name'];
			$students[$datum['student_id']] = $datum['student'];
			$ratings[$datum['student_id']][$datum['subject_id']] = $datum['score'];
		}



		view('Rating/show.twig',
			[	'data' => $data,
				'groups' => $groups,
				'subjects' => $subjects,
				'students' => $students,
				'ratings' => $ratings,
				'flasher' => $this->flasher
			]);
	}
}