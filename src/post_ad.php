<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $contact = $_POST['contact'];

    $targetDir = "images/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $imagePath = null;
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $imageTmpPath = $_FILES['product_image']['tmp_name'];
        $imageName = $_FILES['product_image']['name'];
        $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);

        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        if (in_array(strtolower($imageExtension), $allowedExtensions)) {
            $newImageName = uniqid() . '.' . $imageExtension;
            $imagePath = $targetDir . $newImageName;

            if (!move_uploaded_file($imageTmpPath, $imagePath)) {
                echo "<script>alert('Error uploading image.');</script>";
                $imagePath = null;
            }
        } else {
            echo "<script>alert('Invalid format. Upload jpg, jpeg, or png.');</script>";
        }
    }

    $sql = "INSERT INTO dds (title, description, category, price, contact, image)
            VALUES ('$title', '$description', '$category', '$price', '$contact', '$imagePath')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Advertisement posted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post an Advert</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }


        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 15px 20px;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .navbar a:hover {
            background-color: #575757;
            border-radius: 5px;
        }

        .container {
            padding: 40px 20px;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 18px;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"], input[type="number"], textarea {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        input[type="file"] {
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #575757;
        }

        #imagePreview {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }

        @media screen and (max-width: 768px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-brand">
            <a href="index.php">Divyadeep Advertisements</a>
        </div>
        <div class="nav-links">
            <a href="index.php">Home</a>
        </div>
    </div>

    <div class="container">
        <h1>Post an Ad</h1>
        <form method="post" action="post_ad.php" enctype="multipart/form-data">
            <label>Title:</label>
            <input type="text" name="title" required><br>

            <label>Description:</label>
            <textarea name="description" required></textarea><br>

            <label>Category:</label>
            <input type="text" name="category" required><br>

            <label>Price:</label>
            <input type="number" name="price" step="0.01" required><br>

            <label>Contact Info:</label>
            <input type="text" name="contact" required><br>

            <label>Product Image:</label>
            <input type="file" name="product_image" accept="image/*" onchange="previewImage(event)"><br>

            <img id="imagePreview" style="display: none;" alt="Image Preview"><br>

            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.style.display = 'block';
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
