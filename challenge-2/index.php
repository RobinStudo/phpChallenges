<?php
$numbers = range(0, 9);
shuffle($numbers);
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Challenge 2</title>

        <style>
            .keypad{
                max-width: 200px;
                display: flex;
                flex-wrap: wrap;
                margin: 30px auto;
                gap: 10px;
            }

            .keypad button{
                border: 2px solid #f39c12;
                background-color: transparent;
                width: 30px;
                height: 30px;
                border-radius: 50%;
            }
        </style>
    </head>
    <body>
        <div class="keypad">
            <?php foreach($numbers as $number){ ?>
                <button><?php echo $number; ?></button>
            <?php } ?>
        </div>
    </body>
</html>
