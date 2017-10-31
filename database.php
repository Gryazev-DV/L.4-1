<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
header("Content-Type: text/html; charset=utf-8");
$pdo = new PDO("mysql:host=localhost;dbname=global", "gryazev", "neto1199(neto1199)", [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$pdo->exec('SET NAMES utf8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = $_POST['isbn'];
    $name = $_POST['name'];
    $author = $_POST['author'];
    $sql = "SELECT * FROM books WHERE ((name LIKE :name) AND (isbn LIKE :isbn) AND (author LIKE :author))";
    $statement = $pdo->prepare($sql);
    $statement->execute(["name"=>"%{$name}%","isbn"=>"%{$isbn}%","author"=>"%{$author}%"]);
}else{
    $sql = "SELECT * FROM books";
    $statement = $pdo->prepare($sql);
    $statement->execute();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 </head>
<body>


<div>
    <h1>Библиотека успешного человека</h1>
    <form method="POST">
        <div>
            <div><input type="text" name="isbn" placeholder="ISBN" value="<?php if (!empty($_POST)){echo $_POST['isbn'];} ?>"></div>
            <div><input type="text" name="name" placeholder="Название книги" value="<?php if (!empty($_POST)){echo $_POST['name'];} ?>"></div>
            <div><input type="text" name="author" placeholder="Автор книги" value="<?php if (!empty($_POST)){echo $_POST['author'];} ?>"></div>
            <div><button type="submit">Поиск</button></div>
        </div>
    </form>
    <table>
        <thead>
            <tr>
                <th>Название</th>
                <th>Автор</th>
                <th>Год выпуска</th>
                <th>Жанр</th>
                <th>ISBN</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($statement as $row) : ?>
            <tr>
                <td><?=$row['name']?></td>
                <td class="uk-text-nowrap"><?=$row['author']?></td>
                <td class="uk-text-nowrap"><?=$row['year']?></td>
                <td><?=$row['genre']?></td>
                <td class="uk-text-nowrap"><?=$row['isbn']?></td>
            </tr>
        <?php endforeach;?>

        </tbody>

    </table>
</div>


</body>
</html>