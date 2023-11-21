<?php
require_once __DIR__ . "/../config/config.php";

class User {
	private $uid;

	function __construct($uid) {
		$this->uid = $uid;
	}

	public function get() {
		$query = DB::get()->prepare("SELECT * FROM users WHERE id=?");
        $query->execute([$this->uid]);
        return $query->fetch();
	}

	public function group($profile) {
		$query = DB::get()->prepare("SELECT * FROM groups WHERE id=?");
		$query->execute([$profile["group"]]);
		return $query->fetch();
	}

	public function marks() {
		$query = DB::get()->prepare("SELECT * FROM marks WHERE student_id=?");
		$query->execute([$this->uid]);
		return $query->fetchAll();
	}

	public function subject($mark) {
		$query = DB::get()->prepare("SELECT * FROM subjects WHERE id=?");
		$query->execute([$mark["subject_id"]]);
		return $query->fetch();
	}
}
?>