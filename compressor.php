<?php
function my_image_resize($width, $height, $path) //32x32
{
    //Оригінал висота і ширина
    list($w,$h)= getimagesize($path); //204x247
    $maxSize=0;
    if(($w>$h) and ($width>$height))
        $maxSize=$width;
    else
        $maxSize=$height;
    $width=$maxSize;
    $height=$maxSize;
    $ration_orig=$w/$h;
    if(1>$ration_orig)
    {
        $width=ceil($height*$ration_orig);
    }
    else
    {
        $height=ceil($width/$ration_orig);
    }
    $imgString=file_get_contents($path);
    $image=imagecreatefromstring($imgString);
    $tmp=imagecreatetruecolor($width,$height);
    imagecopyresampled($tmp,$image,
        0,0,
        0,0,
        $width, $height,
        $w,$h
    );
    imagejpeg($tmp,$path,30);
    return $path;
    imagedestroy($image);
    imagedestroy($tmp);
}