<?php
     $fileName = 'data.json';
    if (file_exists($fileName)) {
        $jsonString = file_get_contents($fileName);
        $topics = json_decode($jsonString);
    } else {
        $topics = [];
    }
    $time = date("H:i:s");

    if (isset($_POST['action'])) {

        # Új téma hozzáadása
        if ($_POST['action'] == 'add') {
            #region Az utolsó téma ID meghatározása
            $lastId = 0;
            if (!empty($topics)) {
                $lastItem = end($topics);
                $lastId = $lastItem->id;
            } 
            #endregion
            array_push($topics,
            (object)[
                "id" => $lastId + 1,
                "name" => $_POST['topic'],
                "time" => $time,
            ]
            );
            $JsonString = json_encode($topics,JSON_PRETTY_PRINT);
            file_put_contents($fileName,$JsonString);
        }
        # Téma törlése
        elseif (($_POST['action'] == 'delete')) 
             if (isset($_POST['check'])) {
            $id = $_POST['id'];
            foreach ($topics as $key => $topic) {
                if ($topic->id == $id) break;
            }
        
            array_splice($topics,$key,1);
            $JsonString = json_encode($topics,JSON_PRETTY_PRINT);
            file_put_contents($fileName,$JsonString);
             }else{
            echo "nem lehet törölni!";
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
    <?php
    if (!isset($_GET['topicID'])) {
echo ' <h1>Témák:</h1>
        <ol>';
    
            foreach ($topics as $value) {
            echo '<li><a href="index.php?topicID=' . $value->id . '">'. $value->name . '</a>
            <form method="post">
            <input type="hidden" name="id" value="' . $value->id . '">
            <input type="hidden" name="action" value="delete">
            <input type="checkbox" name="check">
            <input type="submit" value="Törlés">
            </form>';

        }
        echo '</ol>';
    } else {
        $id = $_GET['topicID'];
            foreach ($topics as $key => $topic) {
                if ($topic->id == $id) break;
            }
        $topic = $topics[$key];
        print_r($topics);
        echo $topic-> name . '<br>';
        echo '<a href=index.php>Vissza a témákhoz</a>';
    }
    ?>
    <form action="" method="post">
        <input type="hidden" name="action" value="add">
        <input type="text" name="topic">
        <input type="submit" value="Add">



    </form>
    <h1></h1>
    <?php
        if (isset($_GET['valami'])) {
  echo "Az utolsó kapott érték: ".$_GET['comm'];        
}

    ?>
    <form method="GET">
        <input type="text" name="comm" placeholder="Név....">
        <br>
        <br>
        <br>
        <textarea name="" id=""placeholder="mondj véleményt" ></textarea>
        <input type="submit" value="Küld">


    </form>
</body>
</html>