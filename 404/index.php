<?php
$files = scandir("../Wallpaper");
$number = array_rand($files);
$hidden = [".", "..", "error_log", "index.php"];
while (in_array($files[$number], $hidden)) {
    $number = array_rand($files);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>404 not found</title>
</head>
<body>
<style>
    @font-face {
        font-family: Delfino;
        src: url("/Delfino.otf") format("opentype");
    }

    body {
        overflow: hidden;
        margin: 0;
        font-size: 0;
        background: #303;
        font-family: Delfino;
    }

    p {
        color: #fee;
        margin: 0;
        font-size: 2vw;
        font-family: Delfino;
        width: fit-content;
    }
    img {
        display: block;
        width: 100vw;
        height: auto;
    }
    a {
        color: mediumpurple;
    }
</style>
<p> aww, the page you requested is unavailable.</p>
<p> I suggest looking at <a href="/">the main page</a> or at this random wallpaper</p>
<?php
echo "<img id=\"wallpaper\" alt=\"" . $files[$number] . "\" importance=\"auto\" loading=\"auto\" src=\"/Wallpaper/" . $files[$number] . "\">"; // srcset="https://i.pinimg.com/236x/59/43/15/594315c2b8927d172491c6e3fde034b6.jpg 1x, https://i.pinimg.com/474x/59/43/15/594315c2b8927d172491c6e3fde034b6.jpg 2x, https://i.pinimg.com/736x/59/43/15/594315c2b8927d172491c6e3fde034b6.jpg 3x, https://i.pinimg.com/originals/59/43/15/594315c2b8927d172491c6e3fde034b6.jpg 4x">
?>

<script type="text/javascript">
    /*function change_location(var timestamp)
    {

    }*/
    let d = new Date();
    let timestamp = d.getTime();
    console.log(window.location.href);
    if (window.location.href === "https://yoshi-web-store.com/404/" || timestamp.toString() !== window.location.href.split("?")[1])
    {
        window.history.replaceState(null, document.title, '/404/?' + timestamp.toString());
    }

    // setInterval(change_location(), 100000000000000000);
</script>
<script type="text/javascript">

    // console.log(screen.height);
    // console.log(screen.width);
    if (screen.height < screen.width) {
        const img = document.getElementById("wallpaper");
        img.style.width = "auto";
        img.style.maxwidth = "100vw";
        img.style.height = "calc(100vh - 4.5vw)";
    }

</script>
</body>
</html>