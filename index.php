<?php
    $fileName = 'data.json';

    if(file_exists($fileName)){
        $jsonString = file_get_contents($fileName);
        $topics = json_decode($jsonString);
    }else{
        $topics = [];
    }


    

    
    if(isset($_POST['action'])){
        $lastID = 0;
        if(!empty($topics)){
            $lastItem = end($topics);
            $lastID = $lastItem->id;
        }
        $newID = $lastID+1;

        if($_POST['action']=='add')
        {
       array_push($topics, 
        (object)[
            "id" => $newID,
            "name" => $_POST['topic']
        ]);
       $jsonString = json_encode($topics, JSON_PRETTY_PRINT);
       file_put_contents($fileName, $jsonString);
        }
    }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fórum</title>
</head>
<body>
    
    <h1>Témák:</h1>
    <ol>
    <?php
        foreach ($topics as $value) {
            echo '<li>' . $value->name .'
            <form method="post">
            <input type="hidden" name="topic"  value="'. $value->id. '">
            <input type="hidden" name="action" value="delete">
            <input type=submit value="törlés">
            </form>
            ';
        }
    ?>
    </ol>
    <form action="" method="post">
        <input type="hidden" name="action" value="add">
        <input type="text" name="topic">
        <input type="submit" value="Add">



    </form>
</body>
</html>