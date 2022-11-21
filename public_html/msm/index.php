<html lang="en">

<head>
    <title>Wallpapers I guess</title>
</head>

<body>

<?php
//header("Location: https://yoshi-web-store.com/Wallpaper");
$files = scandir("./");
$file_count = count($files);
$hidden = [".", "..", "error_log", "index.php"];
for ($i = 0; $i < $file_count; $i++) {
    if (!in_array($files[$i], $hidden));
    {
        echo "<img alt=\"" . $files[$i] . "\" importance=\"auto\" loading=\"auto\" src=\"" . $files[$i] . "\">"; // srcset="https://i.pinimg.com/236x/59/43/15/594315c2b8927d172491c6e3fde034b6.jpg 1x, https://i.pinimg.com/474x/59/43/15/594315c2b8927d172491c6e3fde034b6.jpg 2x, https://i.pinimg.com/736x/59/43/15/594315c2b8927d172491c6e3fde034b6.jpg 3x, https://i.pinimg.com/originals/59/43/15/594315c2b8927d172491c6e3fde034b6.jpg 4x">
    }
}
?>

</body>
</html>