<?php include_once 'header.php';;?>

<form class="form-city" method="get" action="get.php">

	<!--<img class="mb-4" src="img/weather.png" alt="" width="72" height="72">-->

	<h1 class="h3 mb-3 font-weight-normal">Météo</h1>

	<label for="meteo" class="sr-only"></label>
	<input type="text" name="q" class="form-control" placeholder="Exemple : Paris ou Paris,FR" required autofocus>

	<button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Chercher <i class="fas fa-search"></i></button>

    <?php if (isset($_GET['var']) && $_GET['var'] == 404) { ?>

		<div class="alert alert-danger mt-3" role="alert">
			Erreur lors de la recherche.<br>
			<small>Merci de respecter le format.</small>
		</div>

    <?php } ?>

</form>

<?php

include_once 'footer.php';
