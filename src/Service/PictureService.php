<?php

namespace App\Service;

use function imagecreatefrompng as gd_imagecreatefrompng;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @throws \Exception
     */
    public function add(UploadedFile $picture, ?string $folder = '', ?int $width = 250, ?int $height = 250)
    {
        // We give a new name to the picture

        $file = md5(uniqid(rand(),true)). '.webp';

        // We stock pictures informations

        $pictureInfos = getimagesize($picture);

        if($pictureInfos === false)
        {
            throw new Exception('Format d\'image incorrect');
        }
        //phpinfo();
        /*var_dump(extension_loaded('gd'));
        var_dump(get_loaded_extensions());
        die;*/
        // We check mime picture
        switch ($pictureInfos['mime'])
        {
            case 'image/png':
                $pictureSource = \imagecreatefrompng($picture);
                break;
            case 'image/jpeg':
                $pictureSource = \imagecreatefromjpeg($picture);
                break;
            case 'image/webp':
                $pictureSource = \imagecreatefromwebp($picture);
                break;
            default:
                throw new Exception('Format d\'incorrect');
        }

        // Recadrage de l'image
        // we found dimension of picture
        $pictureWidth = $pictureInfos[0];
        $pictureHeight = $pictureInfos[1];

        // we check orientation of picture
        switch($pictureWidth <=> $pictureHeight)
        {
            case -1: // largeur inférieur a la hauteur = portrait
                $squareSize = $pictureWidth;
                $srcX = 0;
                $srcY = ($pictureHeight - $squareSize) / 2;
                break;
            case 0:   // largeur égal à la hauteur = carré
                $squareSize = $pictureWidth;
                $srcX = 0;
                $srcY = 0;
                break;
            case 1:   // largeur supérieur à la hauteur = paysage
                $squareSize = $pictureHeight;
                $srcX = ($pictureWidth - $squareSize) / 2 ;
                $srcY = 0;
                break;
        }

        // we create a new picture clean
        $resizedPicture = imagecreatetruecolor($width, $height);

        imagecopyresampled($resizedPicture, $pictureSource, 0, 0, $srcX, $srcY, $width, $height, $squareSize, $squareSize);

        $path = $this->params->get('images_directory') . $folder;
        
        // we create destination directory if don't exist
        
        if(!file_exists($path . '/mini/'))
        {
            mkdir($path . '/mini/', 0755, true);
        }

        // we stock recadred picture
        imagewebp($resizedPicture, $path . '/mini/' . $width . 'x' . $height . '-' . $file);

        $picture->move($path . '/', $file);

        return $file;
    }

    public function delete(string $file, ?string $folder = '', ?int $width = 250, ?int $height = 250)
    {
        if($file !== 'default.webp')
        {
            $success = false;
            $path = $this->params->get('images_directory') . $folder;

            $mini = $path. '/mini/' . $width . 'x' . $height . '-' . $file;

            if(file_exists($mini))
            {
                unlink($mini);
                $success = true;
            }

            $original = $path . '/' . $file;

            if(file_exists($original))
            {
                unlink($original);
                $success = true;
            }
            return $success;
        }
        return false;
    }
}
