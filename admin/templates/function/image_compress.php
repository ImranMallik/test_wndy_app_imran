<?php
function compressImage($source, $destination) {

    $size = filesize($source);

    switch (true) {
        case $size <= 2097152:
            $quality = 70;
            break;
    
        case $size <= 5242880:
            $quality = 40;
            break;
    
        case $size > 5242880 :
            $quality = 10;
            break;
    
        default:
            $quality = 10;
            break;
    }

    $quality = 10;

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

}
?>