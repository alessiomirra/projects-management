<?php 

/**
* Script I used to create a thumbnail for the user's default avatar 
*/

$newImg = imagecreatefromjpeg("sources/avatar.jpeg"); 

if (!$newImg){
    echo "COULD NOT CREATE THUMBNAIL RESOURCE";
};


$thumbnailImag = imagescale($newImg, 200);

if (!$thumbnailImag){
    echo "COULD NOT SCALE THUMBNAIL RESOURCE";
};

imagejpeg($thumbnailImag, 'sources/'.'thumb_'.'default_avatar.jpeg');