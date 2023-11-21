<?php
session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    require_once __DIR__ . "/../../core/user.php";
    $user = new User($_SESSION["uid"]);
    $profile = $user->get();

    if ($profile["role"] != 1) {
        die("Unauthorized access");
    } else {
        require_once __DIR__ . "/../../core/admin.php";
        $admin = new Admin();

        if (isset($_GET["remove_student"])) {
            $admin->remove_student($_GET["remove_student"]);
        }
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
            <a class="btn btn-success mb-3" href="new_student.php" role="button">Sukurti studento prisijungimą</a>
            <?php if (count($admin->all_students())) {?>
            <table class="table table-hover table-bordered my-4">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Vardas</th>
                        <th scope="col">Pavardė</th>
                        <th scope="col">Grupė</th>
                        <th scope="col">Veiksmas</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($admin->all_students() as $index => $student) {?>
                    <tr>
                        <th scope="row"><?=$index+1?></th>
                        <td><?=$student["name"];?></td>
                        <td><?=$student["lastname"];?></td>
                        <td><?=($student["group_name"] ? $student["group_name"] : "-");?></td>
                        <td>
                            <a href="edit_student.php?student_id=<?=$student["id"]?>" type="button" class="btn btn-sm btn-secondary me-1">Redaguoti</a>
                            <a href="?remove_student=<?=$student["id"]?>" onclick="return confirm('Ar tikrai norite ištrinti šią studento paskyrą?')" type="button" class="btn btn-sm btn-danger">Ištrinti</a></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
            <?php } else { ?>
                <div class="alert alert-warning">Nėra jokių studentų atvaizdavimui.</div>
            <?php } ?>
        </div>

    </body>
</html>