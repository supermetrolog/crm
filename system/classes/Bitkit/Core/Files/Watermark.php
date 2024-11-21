<?php
namespace Bitkit\Core\Files ;
class Watermark extends \Bitkit\Core\Files\File
{
   
    public function generateWatermark(int $width = null, int $height = null, string $way = null)
    {

        $marked_name = $this->getFilePureName();
        $ext = $this->getFileExtension();

        if($ext == 'gif') {
            $image = imagecreatefromgif($this->filename);
        } elseif ($ext == 'png') {
            $image = imagecreatefrompng($this->filename);
        } else {
            $image = imagecreatefromjpeg($this->filename);
        }

        if($width || $height){
            $thumb_width = $width;
            $thumb_height = $height;
        }else{
            $thumb_width = 300;
            $thumb_height = 300;
        }


        //Ширина оригинального изображения
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



        // Наложение ЦВЗ с прозрачным фоном
        imagealphablending($image, true);
        imagesavealpha($image, true);

	    $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );


        // Resize and crop
        imagecopyresampled($thumb,
            $image,
            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height);

	    // Создаем ресурс изображения для нашего водяного знака
	    $watermark_image = imagecreatefrompng(PROJECT_ROOT.'/img/watermark.png');

	    $watermark_scale = 0.7;
	    $watermark_width = $new_width * $watermark_scale;

	    $scaled_watermark = imagescale($watermark_image, $watermark_width);
	    $watermark_height = imagesy($scaled_watermark);

	    // Самая важная функция - функция копирования и наложения нашего водяного знака на исходное изображение

	    $x = ($new_width - $watermark_width) / 2;
	    $y = ($new_height - $watermark_height) / 2;

	    imagecopy($thumb, $scaled_watermark, $x, $y, 0, 0, $watermark_width, $watermark_height);


        // Создание и сохранение результирующего изображения с водяным знаком
        if($way){
            imagejpeg($thumb, $way . $marked_name . '.' . 'jpg',100);
        }else{
            imagejpeg($thumb);
        }

        // Уничтожение всех временных ресурсов
        imagedestroy($image);
        imagedestroy($thumb);
        imagedestroy($watermark_image);
        imagedestroy($scaled_watermark);


    }




}