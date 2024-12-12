<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 14.02.2018
 * Time: 10:42
 */

namespace K5;

use K5\U as u;

class V
{
    public static function GetCallout($msg,$title,$class='warning') : string
    {
        return '
            <div class="callout callout-.'.$class.'">
                <h4>'.$title.'</h4>
                <p>'.$msg.'</p>
            </div>
        ';
    }

    public static function CCMonths() : array
    {
        $arr = ['01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'09','09'=>'09','10'=>'10','11'=>'11','12'=>'12'];
        return $arr;
    }

    public static function CCYears($years=9) : array
    {
        $arr = [];
        $year = (int) date('Y',time());
        for($i=0; $i <= $years;$i++) {
            $c = (string) ($year + $i);
            $arr[$c] =  $c;
        }
        return $arr;
    }

    public static function GetEmployerObject($employerPrefix,$data) : string
    {
        return '
        <div class="d-none employer" id="'.$employerPrefix.'_employer"
        data-employer-dom-prefix="'.$employerPrefix.'" 
        '.implode("\n",$data).'
        ></div>
        ';
    }

    public static function StripCode($code) : string
    {
        $arr = explode("<!--//**-|-**/-->",$code);
        return (sizeof($arr) == 3) ? $arr[1] : $code;
    }

    public static function ClassToId($cn) : string
    {
        return str_replace('\\','_',$cn);
    }

    public static function ClassToJsObj($cn) : string
    {
        return str_replace('\\','.',$cn);
    }

    public static function GetClassName($cn) : string
    {
        $arr = explode('\\', $cn);
        return array_pop($arr);
    }

    public static function DomId2Class($domId) : string
    {
        return str_replace('_','-',$domId);
    }


    public static function ParseDom($keys,$employer=false,string $prefix='')
    {
        $obj = new $keys();
        $vars = get_object_vars($obj);


        foreach($vars as $key => $v) {
            $arr = explode(" ",u::FromCamelCase($key));
            $val = strtolower($prefix.implode("_",$arr));
            $obj->{$key} = $val;
        }
        return $obj;
    }

    public static function ParseCss($keys,$employer=false,string $prefix='')
    {
        $obj = new $keys();
        $vars = get_object_vars($obj);

        foreach($vars as $key => $v) {
            $arr = explode(" ",u::FromCamelCase($key));
            $val = strtolower($prefix.implode("-",$arr));
            $obj->{$key} = $val;
        }
        return $obj;
    }

    public static function SecondsToHours($seconds) : string
    {
        //return floor($seconds / 3600) . gmdate(":i:s", $seconds % 3600);
        $f = ":";
        return sprintf("%02d%s%02d%s%02d", floor($seconds/3600), $f, ($seconds/60)%60, $f, $seconds%60);
    }


    public static function MinutesToHours($time, $format = '%02d:%02d') : string
    {
        if ($time < 1) {
            return "00:00:00";
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    /**
     * @param $source
     * @param $destination
     * @param int $afterWidth
     * @param int $quality
     * @param bool $deleteSource
     * @param string $targetType
     * @return mixed
     * @throws \Exception
     */
    public static function ImageScale($source,$destination,int $afterWidth=1920,int $quality=80,bool $deleteSource=true,string $targetType='webp')
    {
        try {
            //separate the file name and the extension
            $source_parts = pathinfo($source);
            $filename = $source_parts['filename'];
            $extension = $source_parts['extension'];

            //detect the width and the height of original image
            list($width, $height) = getimagesize($source);
            $width;
            $height;

            $image_data = file_get_contents($source);
            $img = imagecreatefromstring($image_data);
            if(!$img) {
                throw new \Exception("resim dosyası okunamıyor ");
            }

            //resize only when the original image is larger than expected with.
            //this helps you to avoid from unwanted resizing.
            if ($width > $afterWidth) {

                //get the reduced width
                $reduced_width = ($width - $afterWidth);
                //now convert the reduced width to a percentage and round it to 2 decimal places
                $reduced_radio = round(($reduced_width / $width) * 100, 2);

                //ALL GOOD! let's reduce the same percentage from the height and round it to 2 decimal places
                $reduced_height = round(($height / 100) * $reduced_radio, 2);
                //reduce the calculated height from the original height
                $after_height = $height - $reduced_height;
            } else {
                $afterWidth = $width;
                $after_height = $height;
            }
            $afterWidth = intval($afterWidth);
            $after_height = intval($after_height);
            $imgResized = imagescale($img, $afterWidth, $after_height);
            if($targetType === 'jpg') {
                imagejpeg($imgResized, $destination,$quality);
            }elseif($targetType === 'png') {
                imagepng($imgResized, $destination,$quality);
            }elseif($targetType === 'webp') {
                imagewebp($imgResized, $destination,$quality);
            }else {
                imagewebp($imgResized, $destination,$quality);
            }

            if(!is_file($destination)) {
                throw new \Exception("New file was not created \n".$destination);
            }
            if($deleteSource) {
                unlink($source);
            }
            return $destination;

        } catch (\Exception $e) {
            \K5\U::lerr($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param $source
     * @param $temp
     * @param int $rotation
     * @throws \Exception
     */
    public static function ImageRotate($source,$temp,$rotation=90)
    {
        try {
            //separate the file name and the extention
            $source_parts = pathinfo($source);
            $filename = $source_parts['filename'];
            $extension = $source_parts['extension'];


            rename($source,$temp);

            //detect the width and the height of original image
            list($width, $height) = getimagesize($temp);
            $width;
            $height;

            //Now detect the file extension
            //if the file extension is 'jpg', 'jpeg', 'JPG' or 'JPEG'
            /*if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'JPG' || $extension == 'JPEG') {
                //then return the image as a jpeg image for the next step
                $img = imagecreatefromjpeg($temp);
            } elseif ($extension == 'png' || $extension == 'PNG') {
                //then return the image as a png image for the next step
                $img = imagecreatefrompng($temp);
            } else {
                //show an error message if the file extension is not available
                throw new \Exception("Resim türü desteklenmiyor, jpg veya png. ".$extension);
            }*/
            $image_data = file_get_contents($temp);
            $img = imagecreatefromstring($image_data);
            if(!$img) {
                throw new \Exception("resim dosyası okunamıyor ");
            }

            // Rotate
            $rotate = imagerotate($img, $rotation, 0);

            //and save it on your server...
            imagejpeg($rotate, $source);

            if(!is_file($temp)) {
                throw new \Exception("New file was not created \n".$temp);
            }
            unlink($temp);
        } catch (\Exception $e) {
            \K5\U::ldbg($e->getMessage());
            throw $e;
        }
    }
}
