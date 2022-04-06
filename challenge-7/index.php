<?php
$deliveries = [
    'morning' => 10,
    'afternoon' => 20,
    'evening' => 30,
    'night' => 40
];

function validateData(): array
{
    $errors = [];
    $regexCoordinates = '/^(-?\d+(\.\d+)?).\s*(-?\d+(\.\d+)?)$/';
    global $deliveries;

    if(empty($_POST['startLat']) || empty($_POST['startLng'])){
        $errors[] = 'Vous devez saisir la latititude et la longitude du point de départ';
    }else if(!preg_match($regexCoordinates, $_POST['startLat']) || !preg_match($regexCoordinates, $_POST['startLng'])){
        $errors[] = 'Les coordonnées du point de départ ne sont pas valides';
    }

    if(empty($_POST['endLat']) || empty($_POST['endLng'])){
        $errors[] = 'Vous devez saisir la latititude et la longitude du point d\'arrivée';
    }else if(!preg_match($regexCoordinates, $_POST['endLat']) || !preg_match($regexCoordinates, $_POST['endLng'])){
        $errors[] = 'Les coordonnées du point d\'arrivée ne sont pas valides';
    }

    if(empty($_POST['weight'])){
        $errors[] = 'Vous devez saisir le point du colis';
    }else if(!is_numeric($_POST['weight'])){
        $errors[] = 'Le poids doit être un nombre';
    }else if($_POST['weight'] < 100){
        $errors[] = 'Le poids minimum par colis est de 100g';
    }else if($_POST['weight'] > 300000){
        $errors[] = 'Le poids maximum par colis est de 300kg';
    }

    if(empty($_POST['delivery'])){
        $errors[] = 'Veuillez séléctionner une plage de livraison';
    }else if(!array_key_exists($_POST['delivery'], $deliveries)){
        $errors[] = 'Veuillez séléctionner une plage de livraison valide';
    }

    return $errors;
}

function process(): float
{
    $departure = [
        'lat' => $_POST['startLat'],
        'lng' => $_POST['startLng'],
    ];

    $arrival = [
        'lat' => $_POST['endLat'],
        'lng' => $_POST['endLng'],
    ];

    $weight = $_POST['weight'];
    $delivery = $_POST['delivery'];

    return calculatePrice($departure, $arrival, $weight, $delivery);
}

function calculatePrice(array $start, array $end, int $weight, string $delivery): float
{
    global $deliveries;

    $pricePerKM = 15 + ceil($weight / 1000);
    $distance = calculateDistance($start, $end);

    $price = ceil($distance / 1000) * $pricePerKM;
    $price += $deliveries[$delivery];

    return round($price, 2);
}

function calculateDistance(array $from, array $to): int
{
    $earthRadius = 6371000;

    $latFrom = deg2rad($from['lat']);
    $lonFrom = deg2rad($from['lng']);
    $latTo = deg2rad($to['lat']);
    $lonTo = deg2rad($to['lng']);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return round($angle * $earthRadius);
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $errors = validateData();

    if(count($errors) === 0){
        $price = process();
    }
}
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Challenge 7</title>
    </head>
    <body>
        <h1>Estimez vos couts de transport</h1>

        <?php if(!empty($errors)){ ?>
            <ul>
                <?php foreach ($errors as $error){ ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php }else if(isset($price)){ ?>
            <p>Votre transport coutera <?php echo $price; ?>€</p>
        <?php } ?>

        <form method="post">
            <div>
                Point de départ<br>
                <label for="startLat">Latitude</label>
                <input type="text" name="startLat" id="startLat">
                <label for="startLng">Longitude</label>
                <input type="text" name="startLng" id="startLng">
            </div>
            <div>
                Point d'arrivée<br>
                <label for="endLat">Latitude</label>
                <input type="text" name="endLat" id="endLat">
                <label for="endLng">Longitude</label>
                <input type="text" name="endLng" id="endLng">
            </div>
            <div>
                <label for="weight">Poids du colis</label>
                <input type="number" name="weight" id="weight" placeholder="Poids en gramme">
            </div>
            <div>
                <label for="delivery">Livraison</label>
                <select name="delivery" id="delivery">
                    <option value="morning">Matin</option>
                    <option value="afternoon">Après-midi</option>
                    <option value="evening">Soir</option>
                    <option value="night">Nuit</option>
                </select>
            </div>
            <div>
                <button>Estimer</button>
            </div>
        </form>
    </body>
</html>
