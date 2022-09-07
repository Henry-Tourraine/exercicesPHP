
<?php
if($_SERVER["REQUEST_METHOD"] =="POST"){
    $target_dir = "./images/";
    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
    $target_file = $target_dir . $_POST["newName"].".".$imageFileType;
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<br/> The file ". htmlspecialchars( $_POST["newName"].".".$imageFileType). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    }
}else{
    echo <<<HTML
    
    <!DOCTYPE html>
    <html>
    <body>
    <style>
        body{
            padding: 0;
            margin: 0;
            display: flex;
            flex-flow: column;
            align-items: center;
        }
    </style>
    <form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="text" name="newName" id="newName">
    <input type="submit" value="Upload Image" name="submit">
    </form>

    <img src="" alt="Your file" id="img">
    <script>
        function onFileSelected(event) {
        var selectedFile = event.target.files[0];
        var reader = new FileReader();

        var imgtag = document.getElementById("img");
        imgtag.title = selectedFile.name;

        reader.onload = function(event) {
            imgtag.src = event.target.result;
        };

        reader.readAsDataURL(selectedFile);
        }
        let input = document.querySelector("#fileToUpload");
        input.addEventListener("change",(e)=>{
            console.log(e.target.files);
            onFileSelected(e);
        })
        </script>
    </body>
    </html>

HTML;
}
?>
