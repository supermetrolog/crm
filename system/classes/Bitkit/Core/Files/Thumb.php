<?php

namespace Bitkit\Core\Files;

class Thumb extends \Bitkit\Core\Files\File
{




    public function generateThumb(int $width = null, int $height = null, string $way = null)
    {

        $ext = $this->getFileExtension();

        if ($ext == 'gif') {
            $image = imagecreatefromgif($this->filename);
        } elseif ($ext == 'png') {
            $image = imagecreatefrompng($this->filename);
        } else {
            $image = imagecreatefromjpeg($this->filename);
        }

        $filename = $this->getFilePureName();

        if($width || $height){
            $thumb_width = $width;
            $thumb_height = $height;
        }else{
            $thumb_width = 300;
            $thumb_height = 300;
        }


        $width = imagesx($image);
        $height = imagesy($image);

        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;

        if ( $original_aspect >= $thumb_aspect ){
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        }else{
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }

        $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

        // Resize and crop
        imagecopyresampled($thumb,
            $image,
            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height);
        //imagejpeg($thumb, $filename, 100);

        

        if($way){
            imagejpeg($thumb, $way . $filename . '.' . 'jpg', 100);
        }else{
            imagejpeg($thumb);
        }

        //Удаляем ненужное
        imagedestroy($image);
        imagedestroy($thumb);


    }



}