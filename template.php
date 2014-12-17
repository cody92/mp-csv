<html>

<body>

<table border="1">
    <tr>
        <th>Nr.crt</th>
        <th>Activitate</th>
        <?php for ($i = 1;
                   $i < $maxDepth;
                   $i++): ?>
            <th>Subactivitate</th>
        <?php endfor; ?>
        <th>Data incepere</th>
        <th>Data finalizare</th>
    </tr>
    <?php foreach ($arrayData as $key => $row) : ?>
        <?= displayRow($row, 1, $key); ?>
    <?php endforeach; ?>
</table>

</body>
</html>