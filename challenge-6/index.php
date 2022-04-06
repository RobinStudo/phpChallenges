<?php
function sortChars(string $text): array
{
    $array = str_split($text);

    $chars = [];
    foreach ($array as $char){
        if(isset($chars[$char])){
            $chars[$char]++;
        }else{
            $chars[$char] = 1;
        }
    }

    return $chars;
}

function mergeChars(array $chars, array &$mergedChars): array
{
    foreach($chars as $char => $counter){
        if(isset($mergedChars[$char])){
            $mergedChars[$char] = abs($mergedChars[$char] - $counter);
        }else{
            $mergedChars[$char] = $counter;
        }
    }
}

if(!empty($_POST['text-a']) && !empty($_POST['text-b'])){
    $textA = strtolower($_POST['text-a']);
    $textB = strtolower($_POST['text-b']);

    $charsA = sortChars($textA);
    $charsB = sortChars($textB);

    $mergedChars = [];
    mergeChars($charsA, $mergedChars);
    mergeChars($charsB, $mergedChars);

    $distance = array_sum($mergedChars);
}
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Challenge 6</title>
    </head>
    <body>
        <h1>TextDiff</h1>

        <?php if(isset($distance)){ ?>
            <p>
                Vos chaînes de caractères sont distantes de <strong><?php echo $distance; ?></strong>
            </p>
        <?php } ?>

        <form method="post">
            <div>
                <label for="text-a">Texte 1 :</label>
                <textarea name="text-a" id="text-a"></textarea>
            </div>
            <div>
                <label for="text-b">Texte 2 :</label>
                <textarea name="text-b" id="text-b"></textarea>
            </div>
            <div>
                <button>Différence</button>
            </div>
        </form>
    </body>
</html>
