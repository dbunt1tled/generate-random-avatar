# Random Avatar

Generate random avatars or banners.

## Install

`composer require dbunt1tled/generate-random-avatar`

## Features

*   Custom Fonts
*   Save PNG & JPG format
*   Supported shapes **ellipse**(circle), **rectangle**(square)
*   Supported drivers GD, ImageMagic

## Usage

Minimal usage

        $avatar = (new RAvatar())
            ->setText('RB')
            ->saveFile(realpath(__DIR__).'/0.jpg', 100);

![avatar](/example/0.jpg)

Avatar - full random colors

        $avatar = (new RAvatar())
            ->setText('Igor Snow',null, 60) // name, color (null - random), size
            ->setInitials(2) // convert text to initials (2 - count letters)
            ->setShape('rectangle',90,90) // shape , width, height, color (random)
            ->setBorder(3) // width, color (random)
            ->saveFile('1.jpg', 100); // path, quality

![avatar](/example/1.jpg)

Avatar - random background color and reverse text color based on background (black or white)

        $avatar = (new RAvatar())
            ->setShape('rectangle',300,90)
            ->setText('Igor Snow',null, 60)
            ->setInverseColorText()
            ->setBorder(1)
            ->saveFile('2.jpg', 100);

![avatar](/example/2.jpg)