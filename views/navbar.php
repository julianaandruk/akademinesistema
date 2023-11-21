<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <div class="container d-flex flex-wrap">
        <a class="navbar-brand" href="<?=BASE_URL . "/views/dashboard.php"?>">Akademinė sistema</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto">
                <?php if ($profile["role"] == 1) {?>
                <li class="nav-item">
                    <a class="nav-link<?php if ((basename($_SERVER['SCRIPT_FILENAME'], '.php') == "groups") || (basename($_SERVER['SCRIPT_FILENAME'], '.php') == "new_group") || (basename($_SERVER['SCRIPT_FILENAME'], '.php') == "edit_group")) { echo " active";}?>" href="groups.php">Studentų grupės</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link<?php if ((basename($_SERVER['SCRIPT_FILENAME'], '.php') == "subjects") || (basename($_SERVER['SCRIPT_FILENAME'], '.php') == "new_subject") || (basename($_SERVER['SCRIPT_FILENAME'], '.php') == "edit_subject")) { echo " active";}?>" href="subjects.php">Dėstomi dalykai</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle<?php if ((basename($_SERVER['SCRIPT_FILENAME'], '.php') == "teachers") || (basename($_SERVER['SCRIPT_FILENAME'], '.php') == "new_teacher") || (basename($_SERVER['SCRIPT_FILENAME'], '.php') == "edit_teacher") || (basename($_SERVER['SCRIPT_FILENAME'], '.php') == "students") || (basename($_SERVER['SCRIPT_FILENAME'], '.php') == "new_student") || (basename($_SERVER['SCRIPT_FILENAME'], '.php') == "edit_student")) { echo " active";}?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Vartotojai</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item<?=(basename($_SERVER['SCRIPT_FILENAME'], '.php') == "teachers" ? " active" : "")?>" href="teachers.php">Dėstytojai</a></li>
                        <li><a class="dropdown-item<?=(basename($_SERVER['SCRIPT_FILENAME'], '.php') == "students" ? " active" : "")?>" href="students.php">Studentai</a></li>
                    </ul>
                </li>
                <?php } ?>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?=$profile["name"]?></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?=BASE_URL?>/views/logout.php">Atsijungti</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>