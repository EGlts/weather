<?php

$ville = $_GET['q'];
$string = "https://api.openweathermap.org/data/2.5/weather?q=" . $ville . "&appid=e735e314922a933d68ea45ee818d87c8&lang=fr&units=metric";
$data = json_decode(file_get_contents($string),true);

if ($data['cod'] == NULL || $data['cod'] == 404)
{
	$var = 404;
	echo "<script>window.location.replace('index.php?var=$var')</script>";
}
// Heure GMT + timezone
$heure = gmdate("M d Y H:i:s", time()+($data['timezone']));

//Heure Local au format H:i
$heureLocal = gmdate("H:i", time()+($data['timezone']));

// Stockage des données du json
$ville =  $data['name'];
$pays =  $data['sys']['country'];
$desc = $data['weather'][0]['description'];
$icone = $data['weather'][0]['icon'];
$temperature =  number_format($data['main']['temp'],0,'0',' ');
$min =  number_format($data['main']['temp_min'],0,'0',' ');
$max =  number_format($data['main']['temp_max'],0,'0',' ');
$nuage = $data['clouds']['all'];
$humidite = $data['main']['humidity'];
$visibilite = $data['visibility'];
$vent = number_format($data['wind']['speed'], '0');
$ventDegre = $data['wind']['deg'];

//Convertion de degré en direction cardinale.
function direction($ventDegre) {
    $directionCardi = array(
        'N' => array(348.75, 360),
        'N' => array(0, 11.25),
        'NNE' => array(11.25, 33.75),
        'NE' => array(33.75, 56.25),
        'ENE' => array(56.25, 78.75),
        'E' => array(78.75, 101.25),
        'ESE' => array(101.25, 123.75),
        'SE' => array(123.75, 146.25),
        'SSE' => array(146.25, 168.75),
        'S' => array(168.75, 191.25),
        'SSo' => array(191.25, 213.75),
        'SW' => array(213.75, 236.25),
        'OSO' => array(236.25, 258.75),
        'O' => array(258.75, 281.25),
        'ONO' => array(281.25, 303.75),
        'NO' => array(303.75, 326.25),
        'NNO' => array(326.25, 348.75)
    );
    foreach ($directionCardi as $direction => $angles) {
        if ($ventDegre >= $angles[0] && $ventDegre < $angles[1]) {
            $cardinal = $direction;
        }
    }
    return $cardinal;
}

$ventDirection = direction($ventDegre);

$pression = $data['main']['pressure'];

$lever = date('H:i', $data['sys']['sunrise']+$data['timezone']);
$coucher = date('H:i', $data['sys']['sunset']+$data['timezone']);

include_once 'header.php';

?>

<div class="card m-auto">

	<div class="card-header text-muted">

		<?= "Le " . gmdate("d/m/Y" . " à " . "H:i:s", time()+($data['timezone'])); ?>

	</div>

	<div class="card-img">

		<img src="img/weather.jpg" alt="" style="width: 500px; height: 250px;">
		
	</div>
	
	<div class="card-body">

		<h2 class="card-title mb-0"><?= $ville . " (" . $pays . ")"; ?></h2>
		<p class="text-capitalize"><?= $desc; ?></p>

		<div class="row align-items-center mb-3">
			<div class="offset-2 col-md-4">
				<img src='http://openweathermap.org/img/w/<?= $icone; ?>.png' style="height: 70px; width: 70px;">
			</div>

			<div class="col-md-4 font-weight-bold h3">
				<?= $temperature;?> °C<br>
			</div>
		</div>

		<div class="card-text">

			<!-- Ligne 0 -->
			<div class="row">
				<div class="col-md-6">
					<small>Min : </small><?= $min; ?> °C<br>

				</div>

				<div class="col-md-6">
					<small>Max : </small><?= $max; ?> °C<br>
				</div>
			</div>

			<!-- Ligne 1 -->
			<div class="row">
				<div class="col-md-6">
					<small>Lever : </small><?= $lever; ?><br>

				</div>

				<div class="col-md-6">
					<small>Coucher : </small><?= $coucher; ?><br>
				</div>
			</div>


			<!-- Ligne 2 -->
			<div class="row">
				<div class="col-md-6">
					<small>Humidité : </small><?= $humidite; ?> %<br>

				</div>

				<div class="col-md-6">
					<small>Heure local : </small><?= $heureLocal; ?><br>
				</div>
			</div>

			<!-- Ligne 3 -->
			<div class="row">
				<div class="col-md-6">
					<small>Vent : </small><?= $vent; ?> km/h<br>

				</div>

				<div class="col-md-6">
					<small>Orientation vent : </small><?= $ventDirection; ?><br>
				</div>
			</div>

			<!-- Ligne 4 -->
			<div class="row">
				<div class="col-md-6">
					<small>Pression : </small><?= $pression; ?> hPa<br>

				</div>

				<div class="col-md-6">
					<small>Visibilité : </small><?= number_format($visibilite/1000, '0'); ?> km<br>
				</div>
			</div>

		</div>




	</div>

	<div class="card-footer text-muted">

		<a href="index.php" class="btn btn-warning">Retour <i class="fas fa-undo"></i></a>

	</div>

</div>

<?php include_once 'footer.php';
