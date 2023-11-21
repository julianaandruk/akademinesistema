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
        $group = $admin->get_group($_GET["group_id"]);
        $subjects = $admin->all_subjects();
        $subjects_in_group = $admin->subjects_in_group($_GET["group_id"]);
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

        <div class="container p-5 my-5 bg-white border rounded-3">
            <h4>Grupės redagavimas</h4>
            <form action="<?=BASE_URL . '/core/admin.php'?>" class="form-signin w-100 m-auto" method="post">
                <div class="mt-4 my-3">
                    <div class="mb-3">
                        <input type="number" class="d-none" name="newGroupId" id="newGroupId" value="<?=$_GET['group_id']?>" hidden/>
                        <label for="newGroupName" class="form-label">Grupės pavadinimas</label>
                        <input type="text" class="form-control" name="newGroupName" id="newGroupName" placeholder="Naujas grupės pavadinimas" value="<?=$group["name"]?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="newGroupSubjects" class="form-label">Dėstomi dalykai</label>
                        <select class="form-select" name="newGroupSubjects[]" multiple>
                            <?php foreach ($subjects as $subject) {?>
                            <option value="<?=$subject["id"]?>"<?=(in_array($subject["id"], $subjects_in_group) ? " selected" : "")?>><?=$subject["name"]?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-2 w-100">Atnaujinti</button>
            </form>
        </div>

    </body>
</html>