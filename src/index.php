<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DDS Adverts</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
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
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #444;
        }

        .ads-container {
            display: flex;
            flex-wrap: wrap;
            gap: 50px;

        }

        .ad {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 30%;
            box-sizing: border-box;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .ad:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .ad img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .ad h3 {
            font-size: 18px;
            margin: 10px 0;
            color: #333;
        }

        .ad a {
            color: #333;
            text-decoration: none;
        }

        .ad p {
            color: #777;
            margin: 5px 0;
        }

        .ad .price {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }


        .footer {
            background-color: #333;
            color: #fff;
            padding: 30px 20px;
            text-align: center;
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-section {
            flex: 1;
            min-width: 250px;
            margin: 10px;
        }

        .footer-section h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .footer-section p {
            font-size: 14px;
            line-height: 1.6;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 5px;
        }

        .footer-section ul li a {
            color: #fff;
            text-decoration: none;
        }

        .footer-section ul li a:hover {
            text-decoration: underline;
        }

        .social-icons a {
            display: inline-block;
            margin: 0 10px;
        }

        .social-icons img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }

        .footer-bottom {
            margin-top: 20px;
            font-size: 14px;
            color: #bbb;
        }
        @media screen and (max-width: 768px) {
            .ads-container {
                flex-direction: column;
                align-items: center;
            }

            .ad {
                width: 80%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-brand">
            <a href="index.php">DDS Adverts</a>
        </div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="post_ad.php">Post an Advert</a>
        </div>
    </div>
    <div class="container">
        <h1>Welcome to DDS Adverts</h1>
        <h2>Latest Ads</h2>
        <div class="ads-container">
            <?php
            $sql = "SELECT * FROM dds ORDER BY date_posted DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imagePath = $row['image'];

                    echo "<div class='ad'>";
                    if ($imagePath) {
                        echo "<img src='" . $imagePath . "' alt='Advert Image'>";
                    }
                    echo "<h3><a href='ad_details.php?id=" . $row['id'] . "'>" . $row['title'] . "</a></h3>
                          <p>Category: " . $row['category'] . "</p>
                          <p class='price'>$" . $row['price'] . "</p>
                          <p>" . substr($row['description'], 0, 100) . "...</p>
                          <p>Posted on: " . $row['date_posted'] . "</p>
                      </div>";
                }
            } else {
                echo "<p>No ads available.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>About DDS Adverts</h3>
                <p>Your go-to platform for buying, selling, and discovering amazing deals on items, services, and job listings. Easy, fast, and secure!</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="post_ad.php">Post an Advert</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">About</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="#"><img src="images/facebook.svg" alt="Facebook"></a>
                    <a href="#"><img src="images/twitter-x.svg" alt="Twitter"></a>
                    <a href="#"><img src="images/instagram.svg" alt="Instagram"></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 DDS Adverts. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
