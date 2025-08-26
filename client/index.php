<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/main.style.css">
</head>

<body>
    <!-- header -->
    <header>
        <?php
        include '../components/navbar.php';
        // Change State login to sign up
        ?>
    </header>
    <main>
        <?php
        if (isset($_SESSION['signup']) && $_SESSION['username'] == "signup") {
            echo '<h1 class="title-container">Globe Gateways</h1>';
        } else {
            echo '<h1 class="title-container">
                  <span class="ch1">G</span>
                  <span class="ch2">l</span>
                  <span class="ch3">o</span>
                  <span class="ch4">b</span>
                  <span class="ch5">e</span>
                  <span class="ch6">&nbsp;&nbsp;</span>
                  <span class="ch7">G</span>
                  <span class="ch8">a</span>
                  <span class="ch9">t</span>
                  <span class="ch10">e</span>
                  <span class="ch11">w</span>
                  <span class="ch12">a</span>
                  <span class="ch13">y</span>
                  <span class="ch14">s</span>
                  </h1>';
        }
        ?>


        </h1>
    </main>
</body>

</html>