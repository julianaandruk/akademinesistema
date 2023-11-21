<?php
session_start();

require_once __DIR__ . "/../config/config.php";

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    header("location: dashboard.php");
    exit();
}
?>
<!doctype html>
<html lang="lt">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Akademinė sistema - Juliana Andrukonis</title>
        <base href="<?=BASE_URL?>">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">
    </head>
    <body class="d-flex align-items center py-5 bg-body-tertiary">
        <form action="core/auth.php" class="form-signin w-100 m-auto" method="post">
            <?php
            if (isset($_SESSION["error"])) {
                echo '<div class="alert alert-danger">' . $_SESSION["error"] . '</div>';
                $_SESSION["error"] = null;
            }
            ?>
            <div class="mb-3">
                <label for="usernameInput" class="form-label">Prisijungimo vardas</label>
                <input type="text" class="form-control" name="usernameInput" id="usernameInput" placeholder="vardenis.pavardenis" required>
            </div>

            <div class="mb-3">
                <label for="passwordInput" class="form-label">Slaptažodis</label>
                <input type="password" class="form-control" name="passwordInput" id="passwordInput" placeholder="**********" required>
            </div>
            
            <button type="submit" class="btn btn-primary mt-2 w-100">Prisijungti</button>
        </form>
    </body>
</html>