<?php
$concerts = [
    [
        'artist' => 'Hoshi',
        'city' => 'Lille',
        'place' => 'Zenith de Lille',
        'date' => '2022-04-06',
    ],
    [
        'artist' => 'Saez',
        'city' => 'Paris',
        'place' => 'Bataclan',
        'date' => '2023-01-12',
    ],
    [
        'artist' => 'HK',
        'city' => 'Nantes',
        'place' => 'Le Tank',
        'date' => '2022-11-12',
    ],
    [
        'artist' => 'Stupeflip',
        'city' => 'Bayonne',
        'place' => 'Arêne de Bayonne',
        'date' => '2024-10-08',
    ],
    [
        'artist' => 'Pigalle',
        'city' => 'Rennes',
        'place' => 'Zenith de Rennes',
        'date' => '2022-12-12',
    ],
    [
        'artist' => 'Saez',
        'city' => 'Vannes',
        'place' => 'Zenith de Vannes',
        'date' => '2022-09-12',
    ],
];

if(!empty($_GET['query'])){
    $query = strtolower($_GET['query']);

    $results = [];
    foreach($concerts as $concert){
        $findArtist = str_contains(strtolower($concert['artist']), $query);
        $findPlace = str_contains(strtolower($concert['place']), $query);
        $findCity = str_contains(strtolower($concert['city']), $query);

        if($findArtist || $findPlace || $findCity){
            $results[] = $concert;
        }
    }
}else{
    $results = $concerts;
}

if(!empty($_GET['startAt'])){
    $startAt = strtotime($_GET['startAt']);

    foreach($results as $key => $concert){
        $date = strtotime($concert['date']);

        if($date < $startAt){
            unset($results[$key]);
        }
    }
}

if(!empty($_GET['endAt'])){
    $endAt = strtotime($_GET['endAt']);

    foreach($results as $key => $concert){
        $date = strtotime($concert['date']);

        if($date > $endAt){
            unset($results[$key]);
        }
    }
}
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Challenge 4</title>
    </head>
    <body>
        <h1>Concerts</h1>

        <form method="get">
            <div>
                <label for="query">Recherche :</label>
                <input type="text" name="query" id="query">
            </div>
            <div>
                <label for="startAt">Date de début :</label>
                <input type="date" name="startAt" id="startAt">
            </div>
            <div>
                <label for="endAt">Date de fin :</label>
                <input type="date" name="endAt" id="endAt">
            </div>
            <div>
                <button>Rechercher</button>
            </div>
        </form>

        <?php foreach ($results as $concert) { ?>
            <p>
                <?php echo $concert['artist'] . ' : ' . $concert['place'] . ' - ' . $concert['city']; ?><br>
                <?php echo $concert['date']; ?>
            </p>
        <?php } ?>
    </body>
</html>
