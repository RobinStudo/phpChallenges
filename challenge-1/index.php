<?php
$result = null;
if(isset($_POST['word'])){
    $word = strtolower($_POST['word']);
    $reversedWord = strrev($word);

    $result = $reversedWord === $word;
}
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Challenge 1</title>
    </head>
    <body>
        <form method="post">
            <label for="word">Saissisez un mot :</label>
            <input type="text" name="word" id="word">
            <button type="submit">Envoyer</button>
        </form>

        <?php if($result !== null){ ?>
            <p>
                Le mot <?php echo $word; ?>
                <?php if($result === true){ ?>
                    est
                <?php }else if($result === false){ ?>
                    n'est pas
                <?php } ?>
                un palindrome
            </p>
        <?php } ?>
    </body>
</html>
