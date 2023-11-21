<?php
session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    require_once __DIR__ . "/../../core/user.php";
    $user = new User($_SESSION["uid"]);
    $profile = $user->get();

    if ($profile["role"] != 2) {
        die("Unauthorized access");
    } else {
        require_once __DIR__ . "/../../core/teacher.php";
        $teacher = new Teacher();
        $group = $teacher->group($_GET["group_id"]);
        $subject = $teacher->subject_teacher($profile["id"]);
        $students = $teacher->all_students($_GET["group_id"], $subject["id"]);
        print_r($students);
    }
}
?>
<!doctype html>
<html lang="lt">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Akademinė sistema - Juliana Andrukonis</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    </head>
    <body class="bg-body-tertiary">
        <?php
        require_once __DIR__ . "/../../views/navbar.php";
        ?>

        <div class="container p-5">
            <?php
            if (isset($_SESSION["message"]) && isset($_SESSION["message_type"])) {
                echo '<div class="alert alert-' . $_SESSION["message_type"] . ' alert-dismissible fade show">' . $_SESSION["message"] . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                $_SESSION["message"] = null;
                $_SESSION["message_type"] = null;
            }
            ?>
            <h4><?=$group["name"]?></h4>
            <?php if (count($students)) {?>
            <form action="<?=BASE_URL . '/core/teacher.php'?>" method="post">
	            <table class="table table-hover table-bordered">
	                <thead>
	                    <tr>
	                        <th scope="col">#</th>
	                        <th scope="col">Vardas</th>
	                        <th scope="col">Pavardė</th>
	                        <th scope="col">Pažymys</th>
	                    </tr>
	                </thead>
	                <tbody>
	                <?php foreach($students as $index => $student) {?>
	                    <tr>
	                        <th scope="row"><?=$index+1?></th>
	                        <td><?=$student["name"];?></td>
	                        <td><?=$student["lastname"];?></td>
	                        <td>
	                        	<input type="number" class="d-none" name="studentId[]" id="studentId" value="<?=$student["id"]?>" hidden/>
	                        	<input type="number" class="d-none" name="subjectId" id="subjectId" value="<?=$subject["id"]?>" hidden/>
	                    		<select class="form-select" name="pazymys[]">
								  	<option selected>-</option>
								  	<option value="10"<?=($student["mark"] == 10 ? " selected" : "");?>>10</option>
								 	<option value="9"<?=($student["mark"] == 9 ? " selected" : "");?>>9</option>
								  	<option value="8"<?=($student["mark"] == 8 ? " selected" : "");?>>8</option>
								  	<option value="7"<?=($student["mark"] == 7 ? " selected" : "");?>>7</option>
								  	<option value="6"<?=($student["mark"] == 6 ? " selected" : "");?>>6</option>
								  	<option value="5"<?=($student["mark"] == 5 ? " selected" : "");?>>5</option>
								  	<option value="4"<?=($student["mark"] == 4 ? " selected" : "");?>>4</option>
								  	<option value="3"<?=($student["mark"] == 3 ? " selected" : "");?>>3</option>
								  	<option value="2"<?=($student["mark"] == 2 ? " selected" : "");?>>2</option>
								</select>
	                        </td>
	                    </tr>
	                <?php }?>
	                </tbody>
	            </table>
	            <button type="submit" class="btn btn-primary mt-2 w-100">Išsaugoti</button>
           	</form>
            <?php } else { ?>
                <div class="alert alert-warning">Nėra jokių studentų atvaizdavimui.</div>
            <?php } ?>
        </div>

    </body>
</html>