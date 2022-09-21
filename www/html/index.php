<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>SQL Table</title>
</head>
<body>
<h1>Click a column header to order the table</h1>
<?php
    require_once "database.php";
    $connection = Database::getConnection();
    $fields = array('nome', 'cognome', 'citta');
    $order = NULL;

    if (isset($_GET['order'])) {
        $order = $_GET['order'];

        if (!in_array($order, $fields)) {
            $order = NULL;
        }
    }

    $result = $connection->query("SELECT * FROM persona " . ($order == NULL ? '' : 'ORDER BY ' . $order));
?>
<table>
    <thead>
        <?php foreach ($fields as $field): ?>
            <th onclick="orderBy('<?php echo $field ?>')"><?php echo $field ?></th>
        <?php endforeach; ?>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)): ?>
            <tr>
                <?php foreach ($fields as $field): ?>
                    <td><?php echo $row[$field] ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<br>
<h1>Connection stats</h1>
<?php
    $info = $connection->get_connection_stats();

    foreach ($info as $key => $value) {
        echo $key . ": " . "\"" . $value . "\"<br>";
    }
?>
<script>
    function orderBy(field) {
        let a = document.createElement('a');
        let url = strip(window.location + "");
        a.href = url + '?order=' + field;
        a.click();
    }

    function strip(url) {
        let index = url.lastIndexOf('?');
        return index == -1 ?
            url :
            url.substr(0, index);
    }
</script>
</body>
</html>