<?php 
namespace App\Tools;

trait PhotoTool{


        /**
        * getMimeTypeFinfo 
        * Arg : Path de l'image
        * Return : Type de l'image 
        **/
        function getMimeTypeFinfo($file){
           
            $fi = finfo_open(FILEINFO_MIME_TYPE);
            $type=$fi->buffer($file);
            $mime_type =substr($type,strpos($type,'/')+1, strlen($type) );
             
            finfo_close($fi);  
            return $mime_type;
        }


        /**
         * displayPhoto
         * Arg : Photo
         * Return : Array [file en base64,titre]
         */ 
        function displayPhoto($photo){
            $tabphoto=null;  
            $file=stream_get_contents($photo->getBinaryFile());  
            if ($file != null){       
                $tabphoto= array('base64'=>"data:image/".$this->getMimeTypeFinfo($file).";base64," . base64_encode($file),'titre'=>$photo->getTitre());}
            return  $tabphoto;
        }

          /**
         * displayPhoto
         * Arg : Photo
         * Return : Array [file en base64,titre]
         */ 
        function displayPhoto2($photobinary,$entityphoto){
            $tabphoto=null;           
            $file=stream_get_contents($entityphoto->getBinaryFile());  
            if ($photobinary != null && $file!=null){       
                $tabphoto= array('base64'=>"data:image/".$this->getMimeTypeFinfo($file).";base64," . base64_encode($photobinary),'titre'=>$entityphoto->getTitre());}
            return  $tabphoto;
        }

        /**
         * displayFile
         * Arg : BinaryFile
         * Return : Array [file en base64,titre]
         */ 
        function displayFile($photo,$titre){
            $file=stream_get_contents($photo);  
            if ($file != null){       
                $tabphoto['data']=['base64'=>"data:image/".$this->getMimeTypeFinfo($file).";base64," . base64_encode($file),'titre'=>$titre];}
            return  $tabphoto;
        }


        /**
         * Function photocenter
         * Arg String $image (path+titre)
         * Arg String $titre d'image retourne
         * Arg Int $width en pixel
         * Arg Int $height en pixel
         * Return une photo aux dimensions souhaitées
         *  */ 
        function photocenter(string $image, string $imagecentered,$width,$height){
            $mimetype=$this->getMimeTypeFinfo($image);
            if($mimetype=='png'){$im = imagecreatefrompng($image);}
            if($mimetype=='jpg'||$mimetype=='jpeg'){$im = imagecreatefromjpeg($image);}
           // $size = min(imagesx($im), imagesy($im));
            $im2 = imagecrop($im, ['x' => 0, 'y' => 0, 'width' => $width, 'height' => $height]);
            if ($im2 !== FALSE) {
            imagepng($im2, $imagecentered);
            imagedestroy($im2);
            }
            imagedestroy($im);
        }
        

         /** 
         * Function photocenter
         * Arg String $image (path+titre)
         * Arg String $titre d'image retourne
         * Arg Int $width en pixel
         * Arg Int $height en pixel
         * Return une photo aux dimensions souhaitées
         *  */ 
        function photocenterfromstr(string $image, string $imagecentered,$width,$height){
            $mimetype=$this->getMimeTypeFinfo($image);
            $im=imagecreatefromstring($image);          
           // $size = min(imagesx($im), imagesy($im));
            $im2 = imagecrop($im, ['x' => 0, 'y' => 0, 'width' => $width, 'height' => $height]);
            if ($im2 !== FALSE) {
            imagepng($im2, $imagecentered);
            imagedestroy($im2);
            }
            imagedestroy($im);
        }
        
      


}