
<?php
function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
}
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $email = $_POST["email"];
    $password = $_POST['password'];
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);

    if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        $error="Занадто слабкий пароль";
    }else{
        $error="";
        $user="dbtestreg";
        $pass="Uc06JyRe4~-Y";
        include("connection_database.php");

        $stmt = $dbh->query("SELECT * FROM `tbl_user`");
        while ($row = $stmt->fetch()) {
            if($row['email']==$email){
                $error="Данний юзер вже зареєстрований";
            }
            //echo $row['email']."<br />\n";
        }
        if($error=="")
        {


            $target_dir = "uploads/";

            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    //$error= "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    $error= "File is not an image.";
                    $uploadOk = 0;
                }
            }

// Check if file already exists
            if (file_exists($target_file)) {
                $error= "Sorry, file already exists.";
                $uploadOk = 0;
            }

// Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                $error= "Sorry, your file is too large.";
                $uploadOk = 0;
            }

// Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                $error= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            $image=getGUID().".jpg";
            //$path = dirname($_SERVER['PHP_SELF']);
            //$position = strrpos($path,'/') + 1;
            //$error=getcwd();

            $path= $_SERVER['DOCUMENT_ROOT']."/uploads/".$image;
            $error=$image;
            if ($uploadOk == 0) {
                //$error= "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
            } else {

                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $path)) {
                    //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                    $sql = "INSERT INTO `tbl_user` (`email`, `password`, `image`) VALUES (?, ?, ?);";
                    $stmt= $dbh->prepare($sql);
                    $stmt->execute([$email, $password,$image]);
                    echo '<script>window.location.href = "index.php";</script>';
                } else {
                    //$error= "Sorry, there was an error uploading your file.";
                }
            }


        }

        //echo "<script>alert('POST JS".$email."'); </script>";
    }

}
else{
    $email="";
    $password="";
    $error="";
}
?>
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
<div class="container">
    <div class="row">
        <h1 class="col-12 text-center">Реєстрація</h1>
    </div>
    <div class="row">
        <form class="col-12 " action="register.php" method="post" enctype="multipart/form-data">
            <label class="offset-3 col-6 " style="color: red"><?php echo $error ?></label>
            <div class="offset-3 col-6 form-group">
                <label for="email">Електронна пошта</label>
                <input required type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>" aria-describedby="emailHelp">
            </div>
            <div class="offset-3 col-6 form-group">
                <label for="password">Пароль</label>
                <input required type="password" value="<?php echo $password ?>" class="form-control" id="password" name="password">
            </div>
            <div class="offset-3 col-6 mb-3 input-group mt-2">
                <div class="input-group mb-3">

                    <div class="custom-file">
                        <input required type="file" onchange="loadFile(event)"  class="custom-file-input" name="fileToUpload" id="fileToUpload" aria-describedby="fileToUpload">
                        <label class="custom-file-label" for="fileToUpload">Choose file</label>
                    </div>
                </div>

            </div>
            <img id="output" src="uploads/noimage.jpeg" class="offset-4" style="border-radius: 50%; height: 250px;width: 250px;"/>
            <script>
                var loadFile = function(event) {
                    var output = document.getElementById('output');
                    output.src = URL.createObjectURL(event.target.files[0]);
                    output.onload = function() {
                        URL.revokeObjectURL(output.src) // free memory
                    }
                };
            </script>
            <div class="offset-3 form-group mt-2 form-check">
                <input required type="checkbox" class="form-check-input" name="fileToUpload" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Я буду ходити в магазин в масці</label>
            </div>

            <button type="submit" name="submit" class="offset-8 btn btn-primary">Реєстрація</button>
        </form>
    </div>
</div>


<script src="node_modules/jquery/dist/jquery.min.js" />
<script src="node_modules/popper.js/dist/popper.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>
