<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once './../vendor/autoload.php';

use DBUnt1tled\RandomAvatar\RAvatar;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Example</title>
</head>
<body>
<h1>Random Avatar</h1>
<p>Generate random avatars or banners.</p>
<h2>Features</h2>
<ul>
    <li>Custom Fonts</li>
    <li>Save PNG & JPG format</li>
    <li>Supported shapes <strong>ellipse</strong>(circle), <strong>rectangle</strong>(square)</li>
    <li>Supported drivers GD, ImageMagic</li>
</ul>
<h2>Usage</h2>
<p>Minimal usage</p>
<?php
$avatar = (new RAvatar())
    ->setText('RB')
    ->saveFile(realpath(__DIR__).'/0.jpg', 100);
?>
<pre>
<code>
    $avatar = (new RAvatar())
        ->setText('RB')
        ->saveFile(realpath(__DIR__).'/0.jpg', 100);
</code>
</pre>
<img src="0.jpg" alt="avatar">
<p>Avatar - full random colors</p>
<?php

$avatar = (new RAvatar())
    ->setText('Igor Snow',null, 60)
    ->setInitials(2)
    ->setShape('rectangle',90,90)
    ->setBorder(3)
    ->saveFile(realpath(__DIR__).'/1.jpg', 100);

?>
<pre>
<code>
    $avatar = (new RAvatar())
        ->setText('Igor Snow',null, 60) // name, color (null - random), size
        ->setInitials(2) // convert text to initials (2 - count letters)
        ->setShape('rectangle',90,90) // shape , width, height, color (random)
        ->setBorder(3) // width, color (random)
        ->saveFile('1.jpg', 100); // path, quality
</code>
</pre>
<img src="1.jpg" alt="avatar">
<?php

$avatar = (new RAvatar())
    ->setShape('rectangle',300,90)
    ->setText('Igor Snow',null, 60)
    ->setInverseColorText()
    ->setBorder(1)
    ->saveFile(realpath(__DIR__).'/2.jpg', 100);

?>
<p>Avatar - random background color and reverse text color based on background (black or white)</p>
<pre>
<code>
    $avatar = (new RAvatar())
        ->setShape('rectangle',300,90)
        ->setText('Igor Snow',null, 60)
        ->setInverseColorText()
        ->setBorder(1)
        ->saveFile('2.jpg', 100);
</code>
</pre>
<img src="2.jpg" alt="avatar">
</body>
</html>