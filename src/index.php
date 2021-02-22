<?php
// Documentation Imagick https://www.php.net/manual/en/book.imagick.php

function domytask()
{
    $imageWidth = 600;
    $imageHeight = 600;

    // 1. create empty image
    $resultImage = new Imagick();
    $resultImage->newImage($imageWidth, $imageHeight, new ImagickPixel('black'));
    $resultImage->setImageFormat('png');

    // 2. read both photos
    $uploadedImage = new Imagick('photo1.png');
    $mask = new Imagick('mask1.png');
    // $over = new Imagick('overlay1.png');

    // 3. prepare the background layer

    // create a clone of uploaded image to manipulate it
    $uploadedImageCopy = $uploadedImage->clone();
    // resize uploadedImageCopy to the final resolution
    $uploadedImageCopy->resizeImage($imageWidth, $imageHeight, Imagick::FILTER_LANCZOS, 1);
    // apply it to the result
    $resultImage->compositeImage($uploadedImageCopy, Imagick::COMPOSITE_DEFAULT, 0, 0);
    // add a blur
    $resultImage->blurImage(5,3);

    // 4. copy the uploaded image in the center of the result
    $xCenter = $imageWidth/2 - ($uploadedImage->getImageWidth()/2);
    $yCenter =  $imageHeight/2 - ($uploadedImage->getImageHeight()/2);


    //this block is only for demonstration... should be removed
    $manipulatedUploadedImage = $uploadedImage->clone();
    $manipulatedUploadedImage->resizeImage($uploadedImage->getImageWidth()-50, $uploadedImage->getImageWidth()-70, Imagick::FILTER_LANCZOS, 1);
    $resultImage->compositeImage($manipulatedUploadedImage, Imagick::COMPOSITE_DEFAULT, $xCenter, $yCenter);

    // remove the previous 3 lines and uncomment the one below for real result
    // $resultImage->compositeImage($uploadedImage, Imagick::COMPOSITE_DEFAULT, $xCenter, $yCenter);


    // 5. Add the mask layer
    $resultImage->compositeImage($mask, Imagick::COMPOSITE_DSTIN, $xCenter, $yCenter, Imagick::CHANNEL_ALPHA);

    // Add overlay
    // $base->compositeImage($over, Imagick::COMPOSITE_DEFAULT, 0, 0);

    // write to file
    // $base->writeImage('output.png');
    // or display
    header('Content-type: image/png');
    echo $resultImage;
}
domytask();



function applySimpleMask()
{
    $base = new Imagick('photo1.png');
    $mask = new Imagick('mask1.png');
    $over = new Imagick('overlay1.png');

    // Setting same size for all images
    $base->resizeImage(274, 275, Imagick::FILTER_LANCZOS, 1);

    // Copy opacity mask
    $base->compositeImage($mask, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA);

    // Add overlay
    // $base->compositeImage($over, Imagick::COMPOSITE_DEFAULT, 0, 0);


    // add blur
    // $base->blurImage(5,3);da

    // write to file
    // $base->writeImage('output.png');
    header("Content-Type: image/png");

    echo $base;
}
// applySimpleMask()