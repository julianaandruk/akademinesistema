<?php
require_once __DIR__ . "/../config/config.php";

class Admin {
	public function all_groups() {
		$query = DB::get()->prepare("SELECT * FROM groups ORDER BY id");
        $query->execute();
        return $query->fetchAll();
	}

	public function all_subjects() {
		$query = DB::get()->prepare("SELECT * FROM subjects ORDER BY id");
        $query->execute();
        return $query->fetchAll();
	}

	public function all_teachers() {
		$query = DB::get()->prepare("SELECT users.*, subjects.name AS subject_name FROM users LEFT JOIN subjects ON subjects.teacher_id = users.id WHERE role = 2 ORDER BY users.id");
        $query->execute();
        return $query->fetchAll();
	}

	public function all_students() {
		$query = DB::get()->prepare("SELECT users.*, groups.name AS group_name FROM users LEFT JOIN groups ON users.group = groups.id WHERE ISNULL(users.role) ORDER BY users.id");
        $query->execute();
        return $query->fetchAll();
	}

	public function remove_subject($id) {
		$query = DB::get()->prepare("DELETE FROM subjects WHERE id=?");
		$query = $query->execute([$id]);

		$query = DB::get()->prepare("DELETE FROM subjects_in_group WHERE subject_id = ?");
		$query = $query->execute([$id]);

		$query = DB::get()->prepare("DELETE FROM marks WHERE subject_id = ?");
		$query = $query->execute([$id]);

		header('Location: '. $_SERVER['PHP_SELF']);
	}

	public function make_subject($name) {
		try {
			$query = DB::get()->prepare("INSERT INTO subjects (name) VALUES (?)");
			$query = $query->execute([$name]);
			$this->send_message('Dėstomas dalykas buvo sėkmingai sukurtas.', 'success');
		} catch (PDOException $e) {
        	if ($e->getCode() == 23000) {
        		$this->send_message("Dėstomas dalykas tokiu pavadinimu jau egzistuoja!", 'danger');
        	} else {
        		$this->send_message($e->getMessage(), 'danger');
        	}
        }

		header('Location: '. $_SERVER['HTTP_REFERER'] . '/../subjects.php');
	}

	public function remove_group($id) {
		$query = DB::get()->prepare("DELETE FROM groups WHERE id=?");
		$query = $query->execute([$id]);

		$query = DB::get()->prepare("DELETE FROM subjects_in_group WHERE group_id=?");
		$query = $query->execute([$id]);

		$query = DB::get()->prepare("UPDATE users SET group = ? WHERE group = ?");
		$query = $query->execute([null, $id]);

		header('Location: '. $_SERVER['PHP_SELF']);
	}

	public function remove_teacher($id) {
		$query = DB::get()->prepare("DELETE FROM users WHERE id=?");
		$query = $query->execute([$id]);

		$query = DB::get()->prepare("UPDATE subjects SET teacher_id = ? WHERE teacher_id = ?");
		$query = $query->execute([null, $id]);

		header('Location: '. $_SERVER['PHP_SELF']);
	}

	public function remove_student($id) {
		$query = DB::get()->prepare("DELETE FROM users WHERE id = ?");
		$query = $query->execute([$id]);

		$query = DB::get()->prepare("DELETE FROM marks WHERE student_id = ?");
		$query = $query->execute([$id]);

		header('Location: '. $_SERVER['PHP_SELF']);
	}

	public function make_group($name, $subjects) {
		try {
			$query = DB::get()->prepare("INSERT INTO groups (name) VALUES (?)");
			$query = $query->execute([$name]);
			$id = DB::get()->lastInsertId();

        	foreach ($subjects as $subject) {
				$query = DB::get()->prepare("INSERT INTO subjects_in_group (subject_id, group_id) VALUES (?, ?)");
        		$query->execute([$subject, $id]);
			}

			$this->send_message('Grupė buvo sėkmingai sukurta.', 'success');
		} catch (PDOException $e) {
        	if ($e->getCode() == 23000) {
        		$this->send_message("Grupė tokiu pavadinimu jau egzistuoja!", 'danger');
        	} else {
        		$this->send_message($e->getMessage(), 'danger');
        	}
        }

		header('Location: '. $_SERVER['HTTP_REFERER'] . '/../groups.php');
	}

	public function make_teacher($username) {
		try {
			$query = DB::get()->prepare("INSERT INTO users (name, lastname, username, password, role) VALUES (?, ?, ?, ?, ?)");
			$query = $query->execute([ucfirst(explode(".", $username)[0]), ucfirst(explode(".", $username)[1]), $username, password_hash(explode(".", $username)[1], PASSWORD_DEFAULT), 2]);
			$this->send_message('Dėstytojo profilis buvo sėkmingai sukurtas.', 'success');
		} catch (PDOException $e) {
        	if ($e->getCode() == 23000) {
        		$this->send_message("Vartotojas su tokiu prisijungimu jau egzistuoja!", 'danger');
        	} else {
        		$this->send_message($e->getMessage(), 'danger');
        	}
        }

		header('Location: '. $_SERVER['HTTP_REFERER'] . '/../teachers.php');
	}

	public function make_student($username, $group) {
		try {
			$query = DB::get()->prepare("INSERT INTO users (name, lastname, username, password, `group`) VALUES (?, ?, ?, ?, ?)");
			$query = $query->execute([ucfirst(explode(".", $username)[0]), ucfirst(explode(".", $username)[1]), $username, password_hash(explode(".", $username)[1], PASSWORD_DEFAULT), ($group == -1 ? null : $group)]);
			$this->send_message('Studento profilis buvo sėkmingai sukurtas.', 'success');
		} catch (PDOException $e) {
        	if ($e->getCode() == 23000) {
        		$this->send_message("Vartotojas su tokiu prisijungimu jau egzistuoja!", 'danger');
        	} else {
        		$this->send_message($e->getMessage(), 'danger');
        	}
        }

		header('Location: '. $_SERVER['HTTP_REFERER'] . '/../students.php');
	}

	public function get_group($id) {
		$query = DB::get()->prepare("SELECT * FROM groups WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch();
	}

	public function get_user($id) {
		$query = DB::get()->prepare("SELECT * FROM users WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch();
	}

	public function get_available_subjects($uid) {
		$query = DB::get()->prepare("SELECT * FROM subjects WHERE teacher_id = ? OR ISNULL(teacher_id)");
        $query->execute([$uid]);
        return $query->fetchAll();
	}

	public function get_subject($id) {
		$query = DB::get()->prepare("SELECT * FROM subjects WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch();
	}

	public function subjects_in_group($group) {
		$query = DB::get()->prepare("SELECT subject_id FROM subjects_in_group WHERE group_id = ?");
        $query->execute([$group]);
        return $query->fetchAll(PDO::FETCH_COLUMN);
	}

	public function update_group($id, $name, $subjects) {
		try {
			$query = DB::get()->prepare("UPDATE groups SET name = ? WHERE id = ?");
        	$query->execute([$name, $id]);

        	$query = DB::get()->prepare('DELETE FROM subjects_in_group WHERE group_id = ?');
			$query->execute([$id]);

        	foreach ($subjects as $subject) {
				$query = DB::get()->prepare("INSERT INTO subjects_in_group (subject_id, group_id) VALUES (?, ?)");
        		$query->execute([$subject, $id]);
			}

        	$this->send_message('Grupė buvo sėkmingai atnaujinta.', 'success');
        } catch (PDOException $e) {
        	if ($e->getCode() == 23000) {
        		$this->send_message("Grupė tokiu pavadinimu jau egzistuoja!", 'danger');
        	} else {
        		$this->send_message($e->getMessage(), 'danger');
        	}
        }

		header('Location: '. strtok($_SERVER['HTTP_REFERER'], "?") . '/../groups.php');
	}

	public function update_subject($id, $name) {
		try {
			$query = DB::get()->prepare("UPDATE subjects SET name = ? WHERE id = ?");
	        $query->execute([$name, $id]);
	        $this->send_message('Dėstomas dalykas buvo sėkmingai atnaujintas.', 'success');
	    } catch (PDOException $e) {
        	if ($e->getCode() == 23000) {
        		$this->send_message("Dėstomas dalykas tokiu pavadinimu jau egzistuoja!", 'danger');
        	} else {
        		$this->send_message($e->getMessage(), 'danger');
        	}
        }

		header('Location: '. strtok($_SERVER['HTTP_REFERER'], "?") . '/../subjects.php');
	}

	public function update_teacher($id, $name, $lastname, $username, $password, $subject) {
		try {
			$query = DB::get()->prepare("UPDATE users SET name = ?, lastname = ?, username = ? WHERE id = ?");
	        $query->execute([$name, $lastname, $username, $id]);

	        if ($password) {
	        	$query = DB::get()->prepare("UPDATE users SET password = ? WHERE id = ?");
	        	$query->execute([password_hash($password, PASSWORD_DEFAULT), $id]);
	        }

	        if ($subject != -1) {
	        	$query = DB::get()->prepare("UPDATE subjects SET teacher_id = ? WHERE teacher_id = ?");
	        	$query->execute([null, $id]);

	        	$query = DB::get()->prepare("UPDATE subjects SET teacher_id = ? WHERE id = ?");
	        	$query->execute([$id, $subject]);
	        } else if ($subject == -1) {
	        	$query = DB::get()->prepare("UPDATE subjects SET teacher_id = ? WHERE teacher_id = ?");
	        	$query->execute([null, $id]);
	        }

	        $this->send_message('Dėstytojo profilis buvo sėkmingai atnaujintas.', 'success');
	    } catch (PDOException $e) {
        	if ($e->getCode() == 23000) {
        		$this->send_message("Vartotojas su tokiu prisijungimu jau egzistuoja!", 'danger');
        	} else {
        		$this->send_message($e->getMessage(), 'danger');
        	}
        }

		header('Location: '. strtok($_SERVER['HTTP_REFERER'], "?") . '/../teachers.php');
	}

	public function update_student($id, $name, $lastname, $username, $password, $group) {
		try {
			$query = DB::get()->prepare("UPDATE users SET name = ?, lastname = ?, username = ? WHERE id = ?");
	        $query->execute([$name, $lastname, $username, $id]);

	        if ($password) {
	        	$query = DB::get()->prepare("UPDATE users SET password = ? WHERE id = ?");
	        	$query->execute([password_hash($password, PASSWORD_DEFAULT), $id]);
	        }

	        if ($group != -1) {
	        	$query = DB::get()->prepare("UPDATE users SET `group` = ? WHERE id = ?");
	        	$query->execute([$group, $id]);
	        } else if ($group == -1) {
	        	$query = DB::get()->prepare("UPDATE users SET `group` = ? WHERE id = ?");
	        	$query->execute([null, $id]);
	        }

	        $this->send_message('Studento profilis buvo sėkmingai atnaujintas.', 'success');
	    } catch (PDOException $e) {
        	if ($e->getCode() == 23000) {
        		$this->send_message("Vartotojas su tokiu prisijungimu jau egzistuoja!", 'danger');
        	} else {
        		$this->send_message($e->getMessage(), 'danger');
        	}
        }

		header('Location: '. strtok($_SERVER['HTTP_REFERER'], "?") . '/../students.php');
	}

	public function send_message($message, $type) {
		session_start();
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
	}
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$admin = new Admin();

	if (isset($_POST["groupName"])) {
		$admin->make_group($_POST["groupName"], (isset($_POST["groupSubjects"]) ? $_POST["groupSubjects"] : []));
	} else if (isset($_POST["subjectName"])) {
		$admin->make_subject($_POST["subjectName"]);
	} else if (isset($_POST["newGroupName"]) && isset($_POST["newGroupId"])) {
		$admin->update_group($_POST["newGroupId"], $_POST["newGroupName"], (isset($_POST["newGroupSubjects"]) ? $_POST["newGroupSubjects"] : []));
	} else if (isset($_POST["newSubjectName"]) && isset($_POST["newSubjectId"])) {
		$admin->update_subject($_POST["newSubjectId"], $_POST["newSubjectName"]);
	} else if (isset($_POST["teacherUsername"])) {
		$admin->make_teacher($_POST["teacherUsername"]);
	} else if (isset($_POST["newTeacherId"]) && isset($_POST["newTeacherName"]) && isset($_POST["newTeacherLastname"]) && isset($_POST["newTeacherUsername"]) && isset($_POST["newTeacherSubject"])) {
		$admin->update_teacher($_POST["newTeacherId"], $_POST["newTeacherName"], $_POST["newTeacherLastname"], $_POST["newTeacherUsername"], $_POST["newTeacherPassword"], $_POST["newTeacherSubject"]);
	} else if (isset($_POST["newStudentId"]) && isset($_POST["newStudentName"]) && isset($_POST["newStudentLastname"]) && isset($_POST["newStudentUsername"]) && isset($_POST["newStudentGroup"])) {
		$admin->update_student($_POST["newStudentId"], $_POST["newStudentName"], $_POST["newStudentLastname"], $_POST["newStudentUsername"], $_POST["newStudentPassword"], $_POST["newStudentGroup"]);
	} else if (isset($_POST["studentUsername"]) && isset($_POST["studentGroup"])) {
		$admin->make_student($_POST["studentUsername"], $_POST["studentGroup"]);
	}
}
?>