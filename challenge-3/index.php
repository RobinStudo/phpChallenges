<?php
if(isset($_POST['startAt']) || isset($_POST['endAt'])){
    if(!empty($_POST['startAt']) && !empty($_POST['endAt'])){
        $startAt = strtotime($_POST['startAt']);
        $endAt = strtotime($_POST['endAt']);

        if($startAt > time()){
            if($startAt < $endAt){
                $diff = $endAt - $startAt;
                if($diff >= 3600 && $diff <= 86400 * 10){
                    $hours = ceil($diff / 3600);
                    $price = $hours * 2500;

                    $days = ceil($diff / 86400);
                    $price += $days * 5000;

                    $result = 'Votre location vous coute : ' . $price . '€';
                }else{
                    $result = "Votre location ne peut être inférieur à une heure et supérieur à 10 jours";
                }
            }else{
                $result = 'La date de fin doit être après la date de début';
            }
        }else{
            $result = 'Vous ne pouvez effectuer une location dans le passé';
        }
    }else{
        $result = 'Vous devez saisir une date de début et une date de fin';
    }
}
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Challenge 3</title>
    </head>
    <body>
        <h1>Location d'hélicoptère</h1>

        <?php if(isset($result)){ ?>
            <p><?php echo $result; ?></p>
        <?php } ?>

        <form method="post">
            <div>
                <label for="startAt">Date de début :</label>
                <input type="datetime-local" name="startAt" id="startAt">
            </div>
            <div>
                <label for="endAt">Date de fin :</label>
                <input type="datetime-local" name="endAt" id="endAt">
            </div>
            <div>
                <button>Calculer</button>
            </div>
        </form>
    </body>
</html>
