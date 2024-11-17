<?php
session_start();

if (!isset($_SESSION['accessCount'])) {
    $_SESSION['accessCount'] = 0;
}
$_SESSION['accessCount']++;

$text = "";
$processedText = "";
$wordCount = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST['textarea'];

    $removeSpaces = isset($_POST['remove']);
    $replaceWord = isset($_POST['specific']);
    $capitalizeWords = isset($_POST['capitalize']);
    $showWordCount = isset($_POST['total']);
    $removeHTMLtags = isset($_POST['tags']);

    //Word replacement
    if ($replaceWord && !empty($_POST['text']) && !empty($_POST['word'])) {
        $searchWord = $_POST['text'];
        $replaceWith = $_POST['word'];
        $text = str_ireplace($searchWord, $replaceWith, $text);
    }

    // Remove extra spaces
    if ($removeSpaces) {
        $text = preg_replace('/\s+/', ' ', $text);
    }

    //Capitalize each word
    if ($capitalizeWords) {
        $text = ucwords(strtolower($text));
    }

    //Remove HTML tags
    if ($removeHTMLtags) {
        $text = strip_tags($text);
    }

    //Calculate word count
    if ($showWordCount) {
        $wordCount = str_word_count($text);
    }

    $processedText = htmlspecialchars($text);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rinor Berisha - Exercise 10</title>
</head>

<body>
    <h1>Interactive Word-Based Text Processing Tool</h1>
    <form action="" method="POST">
        <!--Text Area-->
        <label for="text">Enter your text here:</label><br />
        <textarea
            name="textarea"
            id="textarea"
            rows="10"
            cols="100"
            required></textarea>
        <br />
        <br />

        <!--Operations to Perform-->
        <label for="name">Choose Operations to Perform:</label><br />
        <input type="checkbox" id="remove" name="remove" />
        <label for="remove">Remove Extra Spaces Between Words</label><br />

        <input type="checkbox" id="specific" name="specific" />
        <label for="specific">Replace Specific Word</label><br />

        <input type="checkbox" id="capitalize" name="capitalize" />
        <label for="capitalize">Capitalize Each Word</label><br />

        <input type="checkbox" id="total" name="total" />
        <label for="total">Display Total Word Count</label><br />

        <input type="checkbox" id="tags" name="tags" />
        <label for="tags">Remove HTML Tags</label><br /><br />

        <!--Replacement-->
        <label for="replace">Word to replace (if selected):</label>
        <input type="text" id="replace" name="text" /><br />

        <label for="word">Replace with:</label>
        <input type="text" id="word" name="word" /><br /><br />

        <!--Submition button-->
        <input type="submit" value="Process Text" />
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") ?>
    <h2>Processed Text:</h2>
    <textarea readonly rows="10" cols="100"><?php echo $processedText; ?></textarea><br><br>

    <?php if ($showWordCount): ?>
        <p>Total Word Count: <?php echo $wordCount; ?> </p>
    <?php endif; ?>
    <p>Page accessed <?php echo $_SESSION['accessCount']; ?> times in this session. </p>

</body>

</html>