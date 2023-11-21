<?php
session_start();

require_once __DIR__ . "/../../config/config.php";

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    require_once __DIR__ . "/../../core/user.php";
    $user = new User($_SESSION["uid"]);
    $profile = $user->get();
}
?>
<!doctype html>
<html lang="lt">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Akademinė sistema - Juliana Andrukonis</title>
        <base href="<?=BASE_URL?>">
        <link href="css/custom.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    </head>
    <body class="bg-body-tertiary">
        <?php
        require_once __DIR__ . "/../../views/navbar.php";
        ?>
        <div class="container p-5">
        	<?php if (count($user->marks())) { ?>
        	<h4><b><?=$user->group($profile)["name"];?> - <?=$profile["name"];?> <?=$profile["lastname"];?></b>, pažymių suvestinė:</h4>
            <table class="table table-hover table-bordered my-4">
  				<thead>
   					<tr>
      					<th scope="col">#</th>
      					<th scope="col">Dalykas</th>
      					<th scope="col">Pažymys</th>
    				</tr>
  				</thead>
  				<tbody>
  					<?php
  					$total = 0; $i = 0;
  					foreach($user->marks() as $index => $mark) {
  						$total += $mark["mark"]; $i++;
  						if ($user->subject($mark)) {?>
    				<tr>
      					<th scope="row"><?=$index+1?></th>
				      	<td><?=$user->subject($mark)["name"]?></td>
				      	<td><?=($mark["mark"] == 0 ? "-" : $mark["mark"])?></td>
    				</tr>
    				<?php }} ?>
  				</tbody>
			</table>
  			<footer class="d-flex flex-wrap justify-content-center align-items-center py-3 my-4 border-top">
    			<div class="align-items-center">
      				<span class="text-body-secondary">Jūsų pažymių vidurkis: <b><?=(number_format($total/$i, 2) == 0 ? "-" : number_format($total/$i, 2))?></b></span>
    			</div>
  			</footer>
  			<?php } else { ?>
  				<div class="alert alert-warning">Kolkas nėra jokių duomenų atvaizdavimui.</div>
  			<?php } ?>
    	</div>
    </body>
</html>