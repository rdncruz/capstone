<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        $upload_folder="files/";
        $uploaded_file = $upload_folder . basename($_FILES["myfile"]["name"]);

        if(file_exists($uploaded_file)) {
            echo 'The file already exist.';
            exit(1);
        }

        if(move_uploaded_file($_FILES["myfile"]["tmp_name"], $uploaded_file)) {
            echo 'File has been successfully uploaded.';

        } else {
            echo 'Error in uploading file!';
            
        }
    ?>
</body>
</html>