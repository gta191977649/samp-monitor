<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignatureAPIController extends Controller
{
    //
    function generate($ip,$port) {
        $img = imagecreate(400, 80);
        $bg = imagecolorallocate($img, 255, 255, 255);
        $textcolor = imagecolorallocate($img, 0, 0, 255);
        
        // Write the string at the top left
        imagestring($img, 5, 0, 0, '你好时节', $textcolor);
        
        header('Content-Type: image/png');
        imagepng($img);
        exit;
    }
}
