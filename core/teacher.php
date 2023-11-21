<?php
require_once __DIR__ . "/../config/config.php";

class Teacher {
	public function all_groups($uid) {
		$query = DB::get()->prepare("SELECT groups.* FROM subjects LEFT JOIN subjects_in_group ON subjects_in_group.subject_id = subjects.id LEFT JOIN groups ON subjects_in_group.group_id = groups.id WHERE subjects.teacher_id = ? ORDER BY groups.id");
        $query->execute([$uid]);
        return $query->fetchAll();
	}

	public function subject_teacher($uid) {
		$query = DB::get()->prepare("SELECT * FROM subjects WHERE teacher_id = ?");
        $query->execute([$uid]);
        return $query->fetch();
	}

	public function group($id) {
		$query = DB::get()->prepare("SELECT * FROM groups WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch();
	}

	public function all_students($id, $subject_id) {
		$query = DB::get()->prepare("SELECT users.*, marks.mark FROM users LEFT JOIN marks ON marks.student_id = users.id AND marks.subject_id = ? WHERE `group` = ? ORDER BY users.id");
        $query->execute([$subject_id, $id]);
        return $query->fetchAll();
	}

	public function write_mark($student_id, $subject_id, $pazymys) {
		for ($i = 0; $i < count($student_id); $i++) {
			$query = DB::get()->prepare("DELETE FROM marks WHERE student_id = ? AND subject_id = ?");
			$query = $query->execute([$student_id[$i], $subject_id]);

			$query = DB::get()->prepare("INSERT INTO marks (student_id, mark, subject_id) VALUES (?, ?, ?)");
			$query = $query->execute([$student_id[$i], $pazymys[$i], $subject_id]);
		}

		$this->send_message('Pažymiai buvo sėkmingai atnaujinti.', 'success');
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	public function send_message($message, $type) {
		session_start();
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
	}
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$teacher = new Teacher();
	if (isset($_POST["studentId"]) && isset($_POST["subjectId"]) && isset($_POST["pazymys"])) {
		$teacher->write_mark($_POST["studentId"], $_POST["subjectId"], $_POST["pazymys"]);
	}
}
?>