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
    public static function GetCallout($msg,$title,$class='warning')
    {
        return '
            <div class="callout callout-.'.$class.'">
                <h4>'.$title.'</h4>
                <p>'.$msg.'</p>
            </div>
        ';
    }

    public static function CCMonths()
    {
        $arr = ['01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'09','09'=>'09','10'=>'10','11'=>'11','12'=>'12'];
        return $arr;
    }

    public static function CCYears($years=9)
    {
        $arr = [];
        $year = (int) date('Y',PX_CTIME);
        for($i=0; $i <= $years;$i++) {
            $c = (string) $year + $i;
            $arr[$c] =  $c;
        }
        return $arr;
    }

    public static function GetEmployerObject($employerPrefix,$data)
    {
        $html = '
        <div class="d-none employer" id="'.$employerPrefix.'_employer"
        data-employer-dom-prefix="'.$employerPrefix.'" 
        '.implode("\n",$data).'
        ></div>
        ';
        return $html;
    }
    public static function StripCode($code)
    {
        $arr = explode(TEMPLATE_TAG,$code);
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

    public static function GetClassName($cn)
    {
        $arr = explode('\\', $cn);
        return array_pop($arr);
    }

    public static function DomId2Class($domId) : string
    {
        return str_replace('_','-',$domId);
    }

    public static function ClassToTemplate($cn)
    {
        $cn = str_replace("View\\","",$cn);
        $arr = explode("_",str_replace('\\','_',$cn));
        array_shift($arr);
        return "Modules/".implode("/",$arr);
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

    public static function getFlashTemplate($message)
    {
        return '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Kapat</span></button>
		'.$message;
    }

    public static function renderFlashMessages($messages)
    {
        if(!array($messages) || sizeof($messages) < 1) {
            return '';
        }
        $r = '';
        foreach($messages as $k => $v) {
            $class = ($k == 'notice') ? 'info' : $k;
            $class = ($class === 'error') ? 'danger' : $k;
            foreach($v as $mk => $mv) {
                $r.= '
				<div class="alert alert-'.$class.' alert-dismissible" role="alert">'.$mv.'</div>
';
            }
        }
        return $r;
    }

    function Dom2Array($root) {
        $array = array();

        //list attributes
        if($root->hasAttributes()) {
            foreach($root->attributes as $attribute) {
                $array['_attributes'][$attribute->name] = $attribute->value;
            }
        }

        //handle classic node
        if($root->nodeType == XML_ELEMENT_NODE) {
            $array['_type'] = $root->nodeName;
            if($root->hasChildNodes()) {
                $children = $root->childNodes;
                for($i = 0; $i < $children->length; $i++) {
                    $child = Dom2Array( $children->item($i) );

                    //don't keep textnode with only spaces and newline
                    if(!empty($child)) {
                        $array['_children'][] = $child;
                    }
                }
            }

            //handle text node
        } elseif($root->nodeType == XML_TEXT_NODE || $root->nodeType == XML_CDATA_SECTION_NODE) {
            $value = $root->nodeValue;
            if(!empty($value)) {
                $array['_type'] = '_text';
                $array['_content'] = $value;
            }
        }

        return $array;
    }

    /**
     * @param $array
     * @param null $doc
     * @return \DOMDocument
     */
    public static function Array2Dom($array, $doc = null) {
        if($doc == null) {
            $doc = new \DOMDocument();
            $doc->formatOutput = true;
            $currentNode = $doc;
        } else {
            if($array['_type'] == '_text')
                $currentNode = $doc->createTextNode($array['_content']);
            else
                $currentNode = $doc->createElement($array['_type']);
        }

        if($array['_type'] != '_text') {
            if(isset($array['_attributes'])) {
                foreach ($array['_attributes'] as $name => $value) {
                    $currentNode->setAttribute($name, $value);
                }
            }

            if(isset($array['_children'])) {
                foreach($array['_children'] as $child) {
                    $childNode = self::Array2Dom($child, $doc);
                    $childNode = $currentNode->appendChild($childNode);
                }
            }
        }

        return $currentNode;
    }

    public static function SecondsToHours($seconds)
    {
        //return floor($seconds / 3600) . gmdate(":i:s", $seconds % 3600);
        $f = ":";
        return sprintf("%02d%s%02d%s%02d", floor($seconds/3600), $f, ($seconds/60)%60, $f, $seconds%60);
    }


    public static function MinutesToHours($time, $format = '%02d:%02d')
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
     * @return bool
     * @throws \Exception
     */
    public static function ImageScale($source,$destination,$afterWidth=1920,$quality=80,$deleteSource=true)
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

            //Now detect the file extension
            //if the file extension is 'jpg', 'jpeg', 'JPG' or 'JPEG'
            if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'JPG' || $extension == 'JPEG') {
                //then return the image as a jpeg image for the next step
                $img = imagecreatefromjpeg($source);
            } elseif ($extension == 'png' || $extension == 'PNG') {
                //then return the image as a png image for the next step
                $img = imagecreatefrompng($source);
            } else {
                //show an error message if the file extension is not available
                throw new \Exception("Resim türü desteklenmiyor, jpg veya png. -".$extension."-, ".$source.">".$destination);
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

            imagejpeg($imgResized, $destination,$quality);
            if(!is_file($destination)) {
                throw new \Exception("New file was not created \n".$destination);
            }
            if($deleteSource) {
                unlink($source);
            }
            return $destination;

        } catch (\Exception $e) {
            \K5\U::ldbg($e->getMessage());
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
            if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'JPG' || $extension == 'JPEG') {
                //then return the image as a jpeg image for the next step
                $img = imagecreatefromjpeg($temp);
            } elseif ($extension == 'png' || $extension == 'PNG') {
                //then return the image as a png image for the next step
                $img = imagecreatefrompng($temp);
            } else {
                //show an error message if the file extension is not available
                throw new \Exception("Resim türü desteklenmiyor, jpg veya png. ".$extension);
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
