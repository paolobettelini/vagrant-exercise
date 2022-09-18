<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Table</title>
</head>
<style>
table {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

table td, table th {
    border: 1px solid #ddd;
    padding: 8px;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tr:hover {
    background-color: #ddd;
}

table th:nth-child(even) {
    background-color: lightpink;
}

table th:nth-child(odd) {
    background-color: #a0a0f2f2;
}

table th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    color: white;
}
</style>
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
		<!-- NON VA PIÙ IN PHP 8 ????????????????????????? -->
		<!-- NON VA PIÙ IN PHP 8 ????????????????????????? -->
        <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)): ?>
            <tr>
                <?php foreach ($fields as $field): ?>
                    <td><?php echo $row[$field] ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
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