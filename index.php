<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<?php include("navbar.php");?>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Image</th>
        <th scope="col">Email</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $user="dummy";
    $pass="dummy";
    include("connection_database.php");

    $stmt = $dbh->query("SELECT * FROM `tbl_user`");
    while ($row = $stmt->fetch()) {
        $img=$row['image'];
        $email=$row['email'];
        echo "
<tr>
         <td><img src='uploads/$img' style='height: 100px; width: 100px;border-radius: 50%'/> </td>
        <td>$email</td>
    </tr>
            
            
            ";
        //echo $row['email']."<br />\n";
    }
    ?>

    </tbody>
</table>

<script src="node_modules/jquery/dist/jquery.min.js" />
<script src="node_modules/popper.js/dist/popper.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>
