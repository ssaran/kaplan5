<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 3.01.2018
 * Time: 11:24
 */

namespace K5;


class U
{
    /**
     * @param $str
     * @param $startPos
     * @param $maxLength
     * @return mixed|string
     */
    public static function GetExcerpt($str, $startPos=0, $maxLength=100) {
        if(strlen($str) > $maxLength) {
            $excerpt   = substr($str, $startPos, $maxLength-3);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt   = substr($excerpt, 0, $lastSpace);
            $excerpt  .= '...';
        } else {
            $excerpt = $str;
        }

        return $excerpt;
    }

    public static function EscapeJavaScriptText($string)
    {
        return str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$string), "\0..\37'\\")));
    }

    public static function toAscii($str, $delimiter='-')
    {
        $str = self::tr2Eng($str);
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        return $clean;
    }

    public static function slugify($text,$replacement='-')
    {
        $text = preg_replace('~[^\\pL\d]+~u', $replacement, $text);
        $text = trim($text, '-');
        $text = iconv('utf-8', 'us-ascii//IGNORE', $text);
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    public static function fileGetContentsUtf8($fn)
    {
        $content = file_get_contents($fn);
        return mb_convert_encoding($content, 'UTF-8',mb_detect_encoding($content,
            'UTF-8, ISO-8859-1', true));
    }

    public static function stoAscii($str, $delimiter='-')
    {
        return self::toAscii($str,$delimiter);
    }

    public static function tr2Eng($text)
    {
        if(empty($text)) {
            return $text;
        }

        return  str_replace(array('ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç'),
            array('s','S','i','I','g','G','u','U','o','O','C','c'),$text);
    }

    public static function de2Eng($text)
    {
        if(empty($text)) {
            return $text;
        }
        $text = self::spanish2De($text);
        return  str_replace(array('ä', 'ö', 'ü', 'ß', 'Ä', 'Ö', 'Ü','İ','Ş','Ğ','ı','ş','ğ'),
            array('ae', 'oe', 'ue', 'ss', 'Ae', 'Oe', 'Ue','I','S','G','i','s','g'),$text);
    }

    public static function eng2De($text)
    {
        if(empty($text)) {
            return $text;
        }

        return  str_replace(array('ae', 'oe', 'ue', 'ss', 'Ae', 'Oe', 'Ue'),
            array('ä', 'ö', 'ü', 'ß', 'Ä', 'Ö', 'Ü')
            ,$text);
    }

    public static function spanish2De($text) {
        if(empty($text)) {
            return $text;
        }

        return  str_replace(array('á', 'é', 'í', 'ñ', 'ó', 'ú', 'Á','É','Í','Ñ','Ó','Ú'),
            array('a', 'e', 'i', 'n', 'o', 'u', 'A','E','I','N','O','U'),$text);
    }

    public static function mbUcfirst($string, $encoding)
    {
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, null, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }

    /**
     * @param $message
     * @param bool $mark
     */
    public static function ldbg($message,$mark=false)
    {
        openlog('k5_dbg', LOG_CONS | LOG_NDELAY | LOG_PID, LOG_USER | LOG_PERROR);
        syslog(LOG_INFO, print_r($message,true));
        closelog();
    }

    /**
     * @param $message
     * @param string $type
     */
    public static function lerr($message,$type='debug')
    {
        openlog('k5_error', LOG_CONS | LOG_NDELAY | LOG_PID, LOG_USER | LOG_PERROR);
        syslog(LOG_WARNING, "LERR : ".print_r($message,true));
        closelog();
    }

    /**
     * @param $message
     * @param string $type
     */
    public static function linfo($message,$type='debug')
    {
        //syslog(LOG_WARNING,print_r($message,true));
        //file_put_contents(R_DIR.'log.txt', print_r($message,true)."\n", FILE_APPEND);
        openlog('k5_info', LOG_CONS | LOG_NDELAY | LOG_PID, LOG_USER | LOG_PERROR);
        syslog(LOG_WARNING,"WAR:".print_r($message,true));
        closelog();
    }

    /**
     * @param $message
     * @param string $type
     */
    public static function lrnf($message,$type='debug')
    {
        openlog('k5_route', LOG_CONS | LOG_NDELAY | LOG_PID, LOG_USER | LOG_PERROR);
        syslog(LOG_WARNING,"RNF:".print_r($message,true));
        closelog();
    }


    /**
     * Retrieves the best guess of the client's actual IP address.
     * Takes into account numerous HTTP proxy headers due to variations
     * in how different ISPs handle IP addresses in headers between hops.
     */
    public static function getIpAddress()
    {
        // Check for shared internet/ISP IP
        if (!empty($_SERVER['HTTP_CLIENT_IP']) && self::validateIp($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        if ( isset( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ){
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        }

        // Check for IPs passing through proxies
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Check if multiple IP addresses exist in var
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (self::validateIp($ip)) {
                    return $ip;
                }
            }
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED']) && self::validateIp($_SERVER['HTTP_X_FORWARDED'])) {
            return $_SERVER['HTTP_X_FORWARDED'];
        }

        if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && self::validateIp($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        }

        if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && self::validateIp($_SERVER['HTTP_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        }

        if (!empty($_SERVER['HTTP_FORWARDED']) && self::validateIp($_SERVER['HTTP_FORWARDED'])) {
            return $_SERVER['HTTP_FORWARDED'];
        }

        // Return unreliable IP address since all else failed
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @param $ip
     * @return bool
     */
    public static function validateIp($ip) : bool
    {
        if (filter_var($ip, FILTER_VALIDATE_IP,
                FILTER_FLAG_IPV4 |
                FILTER_FLAG_IPV6 |
                FILTER_FLAG_NO_PRIV_RANGE |
                FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }
        return true;
    }

    /**
     * randomChars#
     * generates random string
     */
    public static function randomChars ($pw_length = 8, $numOnly = false,$noNum=false,$isPlate=false) : string
    {
        $i = 0;
        $password = '';
        if($numOnly == false) {
            // Exclude special characters and some confusing alphanumerics
            // o,O,0,I,1,l etc
            $notuse = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111);
            if($isPlate) {
                $notuse = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111,81,87,88);
            }
            if(!$noNum) {
                // set ASCII range for random character generation
                $lower_ascii_bound = 50;  // "2"
                $upper_ascii_bound = 122; // "z"
            } else {
                $lower_ascii_bound = 65;  // "A"
                $upper_ascii_bound = 122; // "z"
                if($isPlate) {
                    $upper_ascii_bound = 90; // "Z"
                }
            }
            while ($i < $pw_length) {
                mt_srand ((int)microtime() * 1000000);
                // random limits within ASCII table
                $randnum = mt_rand ($lower_ascii_bound, $upper_ascii_bound);
                if (!in_array ($randnum, $notuse)) {
                    $password = $password . chr($randnum);
                    $i++;
                }
            }
        } else {
            $n = [];
            while ($i < $pw_length) {
                $n[] = rand(0,9);
                $i++;
            }
            $password = implode('',$n);
        }
        if(!$isPlate) {
            return $password;
        }
        return strtoupper($password);
    }

    public static function ActivitionCode()
    {
        return self::randomChars(3,true).self::randomChars(3,true).self::randomChars(2,true).self::randomChars(2,true);
    }

    /**
     * From ptt-kargo
     * @param $date
     * @param $format
     * @return bool
     */
    public static function ValidateDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function crcObj($obj)
    {
        return crc32(serialize($obj));
    }

    /**
     * @param $message
     * @return string
     */
    public static function printPre($message)
    {
        return "<pre style='text-align:left;'>".print_r($message,true)."</pre>\n<br/>";
    }

    public static function printCC($number)
    {
        if(empty($number)) {
            return "-";
        }

        if(strlen($number) < 16 ) {
            return "-";
        }

        return sprintf("%s-%s-%s-%s",
            substr($number, 0, 4),
            substr($number, 4, 4),
            substr($number, 8, 4),
            substr($number, 12)
        );
    }

    public static function printPhone($number)
    {
        if(empty($number)) {
            return "-";
        }

        if(strlen($number) < 10 ) {
            return "-";
        }

        return sprintf("(%s) %s-%s",
            substr($number, 0, 3),
            substr($number, 3, 3),
            substr($number, 6));
    }

    public static function printMoney($money,$currency='TRY')
    {
        $locale  = 'tr_TR';
        switch ($currency) {
            case 'USD': $locale = 'en_US'; break;
            case 'AZN': $locale = 'az_Latin'; break;
            case 'GBP': $locale = 'en_GB'; break;
            case 'EUR': $locale = 'en_DE'; break;
        }
        $fmt = new \NumberFormatter( $locale, \NumberFormatter::CURRENCY );
        if($currency === 'CUSTOM') {
            $fmt->setSymbol(\NumberFormatter::CURRENCY_SYMBOL, '');
        }
        return $fmt->format($money);
    }

    /**
     * @param $data
     * @param string $current
     * @return string
     */
    public static function optionGenerator($data,$current = '')
    {
        $r = '';
        foreach($data as $k => $v) {
            $selected = ($k == $current) ? 'selected="selected"' : '';
            $r.= "<option label='".$v."' value='".$k."' ".$selected.">".$v."</option>\n";
        }
        return $r;
    }

    public static function optionGeneratorNoLabel($data,$current = '')
    {
        $r = '';
        foreach($data as $k => $v) {
            $selected = ($k == $current) ? 'selected="selected"' : '';
            $r.= "<option  value='".$k."' ".$selected.">".$v."</option>\n";
        }
        return $r;
    }

    public static function optionGeneratorImg($data,$current = '')
    {
        $r = '';
        foreach($data as $k => $v) {
            $selected = ($k == $current) ? 'selected="selected"' : '';
            $r.= "<option value='".$k."' ".$selected." style='background-image:url(".$v.");'>&nbsp;</option>\n";
        }
        return $r;
    }

    public static function optionGenerator2($data,$val,$label,$current = '')
    {
        $r = '';
        foreach($data as $d) {
            $selected = ($d[$val] == $current) ? 'selected="selected"' : '';
            $r.= "<option label='".$d[$label]."' value='".$d[$val]."' ".$selected.">".$d[$label]."</option>\n";
        }
        return $r;
    }

    public static function optionGeneratorSet($data,$current = '')
    {
        $r = '';
        foreach($data as $k => $v) {
            $selected = ($k == $current) ? 'selected="selected"' : '';
            $_data = '';
            foreach($v['set'] as $sk => $sv) {
                $_data.= " data-".$sk."='".$sv."'";
            }
            $r.= "<option label='".$v['label']."' value='".$k."' ".$selected." $_data>".$v['label']."</option>\n";
        }
        return $r;
    }


    public static function YearRangeGenerator($start,$end=false)
    {
        $end = (!$end) ? (integer) date('Y') : $end;
        $years=[];
        for($i = $start;$i<=$end;$i++) {
            $years[$i] = $i;
        }
        krsort($years);
        return $years;
    }

    public static function toTimeStartUnix($time)
    {
        return strtotime($time);
    }

    /**
     * @param string $time
     * @return int
     */
    public static function toTimeEndUnix(string $time) : int
    {
        $uTime = strtotime($time);
        return mktime(23,59,59,(int)date('m',$uTime),(int)date('d',$uTime),(int)date('Y',$uTime));
    }

    public static function Common2Time($common,$isHourly=false,$hourSeperator="T",$zoneSeperator="+")
    {
        if(strlen($common) < 2) {
            return 0;
        }
        $_base = explode($zoneSeperator,$common);
        $time = strtotime(str_replace($hourSeperator,"",$_base[0]));
        if($isHourly) {
            $timeAdd = (int)str_replace(["0",":"],"",$_base[1]);
            $time = ($time + ((60*60)*$timeAdd));
        }
        return $time;
    }

    //2022-01-17T00:57:26

    public static function randomDateInRange(string $start, string $end) {
        $randomTimestamp = mt_rand(strtotime($start), strtotime($end));
        $randomDate = new \DateTime();
        $randomDate->setTimestamp($randomTimestamp);
        return $randomDate;
    }


    public static function Cast2Class($class, $object)
    {
        return unserialize(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen($class) . ':"' . $class . '"', serialize($object)));
    }

    public static function Obj2Db($data)
    {
        return base64_encode(serialize($data));
    }

    public static function Db2Obj($data)
    {
        return unserialize(base64_decode($data));
    }

    public static function Js2Str2Php($data)
    {
        return json_decode(base64_decode($data));
    }

    public static function Php2Obj($data)
    {
        return json_decode(json_encode($data));
    }

    public static function Php2JsJSON($data)
    {
        return '
        
        JSON.parse(\''.json_encode($data).'\')';
    }

    public static function JSON2Php($data)
    {
        return json_decode($data);
    }

    public static function Php2JsMultiline($string)
    {
        $replaced = preg_replace('/\s\s+/', ' ', $string);
        $replaced = preg_replace('~[\r\n]+~', '', $replaced);
        return $replaced;
    }

    public static function Record2Entity($record,$entity)
    {
        foreach($entity as $k => $v) {
            if(isset($record->{$k})) {
                $entity->{$k} = $record->{$k};
            }
        }
        return $entity;
    }

    public static function Array2Entity($record,$entity)
    {
        foreach($entity as $k => $v) {
            if(isset($record[$k])) {
                $entity->{$k} = $record[$k];
            }
        }
        return $entity;
    }

    /**
     * @param $entity
     * @param array $ret
     * @return array
     */
    public static function Entity2Array($entity,array $ret=[]) :array
    {
        foreach($entity as $k => $v) {
                $ret[$k] = $v;
        }
        return $ret;
    }

    /**
     * @param $path
     * @return int
     */
    public static function CountFilesInDir($path) : int
    {
        $fi = new \FilesystemIterator($path, \FilesystemIterator::SKIP_DOTS);
        return iterator_count($fi);
    }

    /**
     * @param string $dir
     * @return array
     */
    public static function parseFdir(string $dir) : array
    {
        $r = [];
        if ($dh = opendir($dir)) {
            while(($strFile = readdir($dh)) !== false) {
                if( !preg_match('/^\./s', $strFile) ) {
                    if(is_dir($dir.$strFile) || is_dir($dir.'/'.$strFile)) {
                        is_dir($dir.'/'.$strFile) ? $r['dirs'][$strFile] = str_replace('\\\\','\\',str_replace("//","/",$dir.'/'.$strFile)) : $r['dirs'][$strFile] = $strFile;
                    } else {
                        $r['files'][$strFile] = rtrim($dir,"/").'/'.$strFile;
                    }
                }
            }
        }
        return $r;
    }

    /**
     * @param string $dir
     * @param $baseDir
     * @param $path
     * @return array
     */
    public static function parseFDirExt(string $dir,$baseDir,$path) : array
    {
        $r = [];
        if ($dh = opendir($dir)) {
            while(($strFile = readdir($dh)) !== false) {
                if( !preg_match('/^\./s', $strFile) ) {
                    if(is_dir($dir.$strFile) || is_dir($dir.'/'.$strFile)) {
                        if(is_dir($dir.'/'.$strFile)) {
                            $dirName = str_replace('\\\\','\\',str_replace("//","/",$dir.'/'.$strFile));
                            $r['dirs'][$strFile]['key'] = $dirName;
                            $r['dirs'][$strFile]['name'] = $strFile;
                            $r['dirs'][$strFile]['uri'] = str_replace($baseDir,'',$dirName);
                            $r['dirs'][$strFile]['childs'] = self::parseFDirExt($dirName,$baseDir,$path);
                        } else {
                            $r['dirs'][$strFile] = $dir.$strFile;
                        }
                    } else {
                        $obj['name'] = str_replace($baseDir,'',rtrim($dir,"/").'/'.$strFile);
                        $obj['size'] = filesize($dir.'/'.$strFile);
                        $obj['uri'] = str_replace($path,'',$obj['name']);
                        $r['files'][$strFile] = $obj;
                    }
                }
            }
        }
        return $r;
    }

    /**
     * parseFDirFlat#
     * parses given dir and returns with full path
     *
     * @param $dir
     * @param $baseDir
     * @param $path
     * @param $r
     * @return array
     */
    public static function parseFDirFlat($dir,$baseDir,$path,$r=array()) : array
    {
        if ($dh = opendir($dir)) {
            while(($strFile = readdir($dh)) !== false) {
                if( !preg_match('/^\./s', $strFile) ) {
                    if(is_dir($dir.$strFile) || is_dir($dir.'/'.$strFile)) {
                        if(is_dir($dir.'/'.$strFile)) {
                            $dirName = str_replace('\\\\','\\',str_replace("//","/",$dir.'/'.$strFile));
                            $obj['key'] = $dirName;
                            $obj['name'] = $strFile;
                            $key = str_replace($baseDir,'',$dirName);
                            $obj['type'] = 'dir';
                            //$r[$key] = $obj;
                            $r = self::parseFDirFlat($dirName,$baseDir,$path,$r);
                        }
                    } else {
                        $obj['name'] = str_replace($baseDir,'',rtrim($dir,"/").'/'.$strFile);
                        //$obj['size'] = filesize($dir.'/'.$strFile);
                        $key =  str_replace($path,'',$obj['name']);
                        $obj['type'] = 'file';
                        $obj['ext'] = substr($strFile, -3);
                        $r[$key] = $obj;
                    }
                }
            }
        }
        return $r;
    }

    public static function CheckUploadedFileName($fileName)
    {
        return (bool) ((preg_match("`^[-0-9A-Z_\.]+$`i",$fileName)) ? true : false);
    }

    public static function CheckUpladedFileNameLength($fileName)
    {
        return (bool) ((mb_strlen($fileName,"UTF-8") > 225) ? true : false);
    }

    public static function mime2ext($mime) : ?string
    {
        $mime_map = [
            'video/3gpp2'                                                               => '3g2',
            'video/3gp'                                                                 => '3gp',
            'video/3gpp'                                                                => '3gp',
            'application/x-compressed'                                                  => '7zip',
            'audio/x-acc'                                                               => 'aac',
            'audio/ac3'                                                                 => 'ac3',
            'application/postscript'                                                    => 'ai',
            'audio/x-aiff'                                                              => 'aif',
            'audio/aiff'                                                                => 'aif',
            'audio/x-au'                                                                => 'au',
            'video/x-msvideo'                                                           => 'avi',
            'video/msvideo'                                                             => 'avi',
            'video/avi'                                                                 => 'avi',
            'application/x-troff-msvideo'                                               => 'avi',
            'application/macbinary'                                                     => 'bin',
            'application/mac-binary'                                                    => 'bin',
            'application/x-binary'                                                      => 'bin',
            'application/x-macbinary'                                                   => 'bin',
            'image/bmp'                                                                 => 'bmp',
            'image/x-bmp'                                                               => 'bmp',
            'image/x-bitmap'                                                            => 'bmp',
            'image/x-xbitmap'                                                           => 'bmp',
            'image/x-win-bitmap'                                                        => 'bmp',
            'image/x-windows-bmp'                                                       => 'bmp',
            'image/ms-bmp'                                                              => 'bmp',
            'image/x-ms-bmp'                                                            => 'bmp',
            'application/bmp'                                                           => 'bmp',
            'application/x-bmp'                                                         => 'bmp',
            'application/x-win-bitmap'                                                  => 'bmp',
            'application/cdr'                                                           => 'cdr',
            'application/coreldraw'                                                     => 'cdr',
            'application/x-cdr'                                                         => 'cdr',
            'application/x-coreldraw'                                                   => 'cdr',
            'image/cdr'                                                                 => 'cdr',
            'image/x-cdr'                                                               => 'cdr',
            'zz-application/zz-winassoc-cdr'                                            => 'cdr',
            'application/mac-compactpro'                                                => 'cpt',
            'application/pkix-crl'                                                      => 'crl',
            'application/pkcs-crl'                                                      => 'crl',
            'application/x-x509-ca-cert'                                                => 'crt',
            'application/pkix-cert'                                                     => 'crt',
            'text/css'                                                                  => 'css',
            'text/x-comma-separated-values'                                             => 'csv',
            'text/comma-separated-values'                                               => 'csv',
            'application/vnd.msexcel'                                                   => 'csv',
            'application/x-director'                                                    => 'dcr',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
            'application/x-dvi'                                                         => 'dvi',
            'message/rfc822'                                                            => 'eml',
            'application/x-msdownload'                                                  => 'exe',
            'video/x-f4v'                                                               => 'f4v',
            'audio/x-flac'                                                              => 'flac',
            'video/x-flv'                                                               => 'flv',
            'image/gif'                                                                 => 'gif',
            'application/gpg-keys'                                                      => 'gpg',
            'application/x-gtar'                                                        => 'gtar',
            'application/x-gzip'                                                        => 'gzip',
            'application/mac-binhex40'                                                  => 'hqx',
            'application/mac-binhex'                                                    => 'hqx',
            'application/x-binhex40'                                                    => 'hqx',
            'application/x-mac-binhex40'                                                => 'hqx',
            'text/html'                                                                 => 'html',
            'image/x-icon'                                                              => 'ico',
            'image/x-ico'                                                               => 'ico',
            'image/vnd.microsoft.icon'                                                  => 'ico',
            'text/calendar'                                                             => 'ics',
            'application/java-archive'                                                  => 'jar',
            'application/x-java-application'                                            => 'jar',
            'application/x-jar'                                                         => 'jar',
            'image/jp2'                                                                 => 'jp2',
            'video/mj2'                                                                 => 'jp2',
            'image/jpx'                                                                 => 'jp2',
            'image/jpm'                                                                 => 'jp2',
            'image/jpeg'                                                                => 'jpeg',
            'image/pjpeg'                                                               => 'jpeg',
            'application/x-javascript'                                                  => 'js',
            'application/json'                                                          => 'json',
            'text/json'                                                                 => 'json',
            'application/vnd.google-earth.kml+xml'                                      => 'kml',
            'application/vnd.google-earth.kmz'                                          => 'kmz',
            'text/x-log'                                                                => 'log',
            'audio/x-m4a'                                                               => 'm4a',
            'audio/mp4'                                                                 => 'm4a',
            'application/vnd.mpegurl'                                                   => 'm4u',
            'audio/midi'                                                                => 'mid',
            'application/vnd.mif'                                                       => 'mif',
            'video/quicktime'                                                           => 'mov',
            'video/x-sgi-movie'                                                         => 'movie',
            'audio/mpeg'                                                                => 'mp3',
            'audio/mpg'                                                                 => 'mp3',
            'audio/mpeg3'                                                               => 'mp3',
            'audio/mp3'                                                                 => 'mp3',
            'video/mp4'                                                                 => 'mp4',
            'video/mpeg'                                                                => 'mpeg',
            'application/oda'                                                           => 'oda',
            'audio/ogg'                                                                 => 'ogg',
            'video/ogg'                                                                 => 'ogg',
            'application/ogg'                                                           => 'ogg',
            'font/otf'                                                                  => 'otf',
            'application/x-pkcs10'                                                      => 'p10',
            'application/pkcs10'                                                        => 'p10',
            'application/x-pkcs12'                                                      => 'p12',
            'application/x-pkcs7-signature'                                             => 'p7a',
            'application/pkcs7-mime'                                                    => 'p7c',
            'application/x-pkcs7-mime'                                                  => 'p7c',
            'application/x-pkcs7-certreqresp'                                           => 'p7r',
            'application/pkcs7-signature'                                               => 'p7s',
            'application/pdf'                                                           => 'pdf',
            'application/octet-stream'                                                  => 'pdf',
            'application/x-x509-user-cert'                                              => 'pem',
            'application/x-pem-file'                                                    => 'pem',
            'application/pgp'                                                           => 'pgp',
            'application/x-httpd-php'                                                   => 'php',
            'application/php'                                                           => 'php',
            'application/x-php'                                                         => 'php',
            'text/php'                                                                  => 'php',
            'text/x-php'                                                                => 'php',
            'application/x-httpd-php-source'                                            => 'php',
            'image/png'                                                                 => 'png',
            'image/x-png'                                                               => 'png',
            'application/powerpoint'                                                    => 'ppt',
            'application/vnd.ms-powerpoint'                                             => 'ppt',
            'application/vnd.ms-office'                                                 => 'ppt',
            'application/msword'                                                        => 'doc',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/x-photoshop'                                                   => 'psd',
            'image/vnd.adobe.photoshop'                                                 => 'psd',
            'audio/x-realaudio'                                                         => 'ra',
            'audio/x-pn-realaudio'                                                      => 'ram',
            'application/x-rar'                                                         => 'rar',
            'application/rar'                                                           => 'rar',
            'application/x-rar-compressed'                                              => 'rar',
            'audio/x-pn-realaudio-plugin'                                               => 'rpm',
            'application/x-pkcs7'                                                       => 'rsa',
            'text/rtf'                                                                  => 'rtf',
            'text/richtext'                                                             => 'rtx',
            'video/vnd.rn-realvideo'                                                    => 'rv',
            'application/x-stuffit'                                                     => 'sit',
            'application/smil'                                                          => 'smil',
            'text/srt'                                                                  => 'srt',
            'image/svg+xml'                                                             => 'svg',
            'application/x-shockwave-flash'                                             => 'swf',
            'application/x-tar'                                                         => 'tar',
            'application/x-gzip-compressed'                                             => 'tgz',
            'image/tiff'                                                                => 'tiff',
            'font/ttf'                                                                  => 'ttf',
            'text/plain'                                                                => 'txt',
            'text/x-vcard'                                                              => 'vcf',
            'application/videolan'                                                      => 'vlc',
            'text/vtt'                                                                  => 'vtt',
            'audio/x-wav'                                                               => 'wav',
            'audio/wave'                                                                => 'wav',
            'audio/wav'                                                                 => 'wav',
            'application/wbxml'                                                         => 'wbxml',
            'video/webm'                                                                => 'webm',
            'image/webp'                                                                => 'webp',
            'audio/x-ms-wma'                                                            => 'wma',
            'application/wmlc'                                                          => 'wmlc',
            'video/x-ms-wmv'                                                            => 'wmv',
            'video/x-ms-asf'                                                            => 'wmv',
            'font/woff'                                                                 => 'woff',
            'font/woff2'                                                                => 'woff2',
            'application/xhtml+xml'                                                     => 'xhtml',
            'application/excel'                                                         => 'xl',
            'application/msexcel'                                                       => 'xls',
            'application/x-msexcel'                                                     => 'xls',
            'application/x-ms-excel'                                                    => 'xls',
            'application/x-excel'                                                       => 'xls',
            'application/x-dos_ms_excel'                                                => 'xls',
            'application/xls'                                                           => 'xls',
            'application/x-xls'                                                         => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
            'application/vnd.ms-excel'                                                  => 'xlsx',
            'application/xml'                                                           => 'xml',
            'text/xml'                                                                  => 'xml',
            'text/xsl'                                                                  => 'xsl',
            'application/xspf+xml'                                                      => 'xspf',
            'application/x-compress'                                                    => 'z',
            'application/x-zip'                                                         => 'zip',
            'application/zip'                                                           => 'zip',
            'application/x-zip-compressed'                                              => 'zip',
            'application/s-compressed'                                                  => 'zip',
            'multipart/x-zip'                                                           => 'zip',
            'text/x-scriptzsh'                                                          => 'zsh',
        ];

        return $mime_map[$mime] ?? null;
    }

    public static function GetPaginatorObj($list)
    {
        $page = new \stdClass();
        $page->total_pages = ceil($list->CountPaginator / $list->Items);
        $page->current = $list->Page;
        $page->first = 1;
        $page->last = $page->total_pages;
        $page->before = 0 ;

        if($page->current > $page->first) {
            $page->before = $page->current -1; ;
        }
        $page->next = $page->current + 1;

        return $page;
    }

    public static function  ToCents($value)
    {
        return round($value * 100,0);
    }

    public static function FromCents($value)
    {
        return round($value / 100,2);
    }

    public static function  ToMl($value)
    {
        return round($value * 1000,0);
    }

    public static function FromMl($value)
    {
        return round($value / 1000,2);
    }

    public static function  ToMinute($value)
    {
        return round($value * 60,0);
    }

    public static function FromMinute($value)
    {
        return round($value / 60,2);
    }

    // round_up:
    // rounds up a float to a specified number of decimal places
    // (basically acts like ceil() but allows for decimal places)
    public static function RoundUp ($value, $places=0) {
        if ($places < 0) { $places = 0; }
        $mult = pow(10, $places);
        return ceil($value * $mult) / $mult;
    }

    // round_out:
    // rounds a float away from zero to a specified number of decimal places
    public static function RoundOut ($value, $places=0) {
        if ($places < 0) { $places = 0; }
        $mult = pow(10, $places);
        return ($value >= 0 ? ceil($value * $mult):floor($value * $mult)) / $mult;
    }

    public static function GetDateFromDay($dayOfYear, $year)
    {
        $date = \DateTime::createFromFormat('z Y', strval($dayOfYear) . ' ' . strval($year));
        return $date;
    }

    public static function IsWeekend($date)
    {
        return (date('N', $date) >= 6);
    }

    public static function Truncate($string,$length=12,$append="&hellip;")
    {
        $string = trim($string);
        if(strlen($string) > $length) {
            $string = wordwrap($string, $length);
            $string = explode("\n", $string, 2);
            $string = $string[0] . $append;
        }
        return $string;
    }

    public static function DateFormatTr($f, $zt){
        $z = date($f, $zt);
        $donustur = array(
            'Monday'    => 'Pazartesi',
            'Tuesday'   => 'Salı',
            'Wednesday' => 'Çarşamba',
            'Thursday'  => 'Perşembe',
            'Friday'    => 'Cuma',
            'Saturday'  => 'Cumartesi',
            'Sunday'    => 'Pazar',
            'January'   => 'Ocak',
            'February'  => 'Şubat',
            'March'     => 'Mart',
            'April'     => 'Nisan',
            'May'       => 'Mayıs',
            'June'      => 'Haziran',
            'July'      => 'Temmuz',
            'August'    => 'Ağustos',
            'September' => 'Eylül',
            'October'   => 'Ekim',
            'November'  => 'Kasım',
            'December'  => 'Aralık',
            'Mon'       => 'Pts',
            'Tue'       => 'Sal',
            'Wed'       => 'Çar',
            'Thu'       => 'Per',
            'Fri'       => 'Cum',
            'Sat'       => 'Cts',
            'Sun'       => 'Paz',
            'Jan'       => 'Oca',
            'Feb'       => 'Şub',
            'Mar'       => 'Mar',
            'Apr'       => 'Nis',
            'Jun'       => 'Haz',
            'Jul'       => 'Tem',
            'Aug'       => 'Ağu',
            'Sep'       => 'Eyl',
            'Oct'       => 'Eki',
            'Nov'       => 'Kas',
            'Dec'       => 'Ara',
        );

        foreach($donustur as $en => $tr){
            $z = str_replace($en, $tr, $z);
        }

        if(strpos($z, 'Mayıs') !== false && strpos($f, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
        return $z;
    }

    public static function NiceNumber($number,$decimals=0,$dSeperator=",",$tSeperator=".") : string
    {
        return number_format($number,$decimals,$dSeperator,$tSeperator);
    }

    public static function numberToWord( int $num) : string
    {
        if($num > 0)  {
            $ones = [
                '', 'bir', 'iki', 'üç', 'dört', 'beş', 'altı', 'yedi', 'sekiz', 'dokuz'
            ];

            $tens = [
                '', 'on', 'yirmi', 'otuz', 'kırk', 'elli', 'altmış', 'yetmiş', 'seksen', 'doksan'
            ];

            $hundreds = [
                '', 'yüz', 'iki yüz', 'üç yüz', 'dört yüz', 'beş yüz', 'altı yüz', 'yedi yüz', 'sekiz yüz', 'dokuz yüz'
            ];

            $thousands = [
                '', 'bin', 'milyon', 'milyar', 'trilyon'
            ];

            // Split number into groups of three digits
            $numStr = strval($num);
            $numLen = strlen($numStr);

            $groups = [];
            for ($i = $numLen; $i > 0; $i -= 3) {
                $groups[] = substr($numStr, max(0, $i - 3), 3);
            }

            $words = [];
            $groupCount = count($groups);

            // Convert each group into words
            foreach ($groups as $index => $group) {
                $groupNum = (int) $group;
                $groupWords = [];

                // Process hundreds
                $hundredPart = (int) ($groupNum / 100);
                if ($hundredPart > 0) {
                    $groupWords[] = $hundreds[$hundredPart];
                }

                // Process tens
                $tenPart = (int) (($groupNum % 100) / 10);
                if ($tenPart > 0) {
                    $groupWords[] = $tens[$tenPart];
                }

                // Process ones
                $onePart = $groupNum % 10;
                if ($onePart > 0) {
                    $groupWords[] = $ones[$onePart];
                }

                // Add the corresponding thousand, million, etc.
                if ($groupWords) {
                    $words[] = implode(' ', $groupWords) . ' ' . $thousands[$groupCount - $index - 1];
                }

            }

            // Return the full result by joining the parts with spaces
            return trim(implode(' ', array_reverse($words)));
        }  else if( ! ( ( int ) $num ) )  {
            return 'Sıfır';
        }
        return '';
    }

    public static function Number2Word($sayi, $separator) {
        $sayarr = explode($separator,$sayi);

        $str = "";
        $items = array(
            array("", ""),
            array("BIR", "ON"),
            array("IKI", "YIRMI"),
            array("UC", "OTUZ"),
            array("DORT", "KIRK"),
            array("BES", "ELLI"),
            array("ALTI", "ALTMIS"),
            array("YEDI", "YETMIS"),
            array("SEKIZ", "SEKSEN"),
            array("DOKUZ", "DOKSAN")
        );

        for ($eleman = 0; $eleman<count($sayarr); $eleman++) {

            for ($basamak = 1; $basamak <=strlen($sayarr[$eleman]); $basamak++) {
                $basamakd = 1 + (strlen($sayarr[$eleman]) - $basamak);


                try {
                    switch ($basamakd) {
                        case 5:
                            $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][0] . " YUZ";
                            break;
                        case 4:
                            $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][1];
                            break;
                        case 3:
                            if($items[substr($sayarr[$eleman],$basamak - 1,1)][0]=="") {
                                $str.=" ";
                            }
                            elseif ($items[substr($sayarr[$eleman],$basamak - 1,1)][0] != "BIR" ) $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][0] . " YUZ";

                            else $str = $str . " YUZ";
                            break;
                        case 2:
                            $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][1];
                            break;
                        default:
                            $str =  $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][0];
                            break;
                    }
                } catch (\Exception $err) {
                    echo $err->getMessage();
                    break;
                }
            }
            if ($eleman< 1) $str = $str . " TL";
            else {
                if ($sayarr[1] != "00") $str = $str . " KRS";
            }
        }
        return $str;
    }

    public static function trimAll( $str , $what = NULL , $with = ' ' )
    {
        if( $what === NULL )  {
            //  Character      Decimal      Use
            //  "\0"            0           Null Character
            //  "\t"            9           Tab
            //  "\n"           10           New line
            //  "\x0B"         11           Vertical Tab
            //  "\r"           13           New Line in Mac
            //  " "            32           Space

            $what   = "\\x00-\\x20";    //all white-spaces and control chars
        }

        return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
    }

    public static function strReplaceLast( $search , $replace , $str ) {
        if( ( $pos = strrpos( $str , $search ) ) !== false ) {
            $searchLength  = strlen( $search );
            $str = substr_replace( $str , $replace , $pos , $searchLength );
        }
        return $str;
    }

    public static function GetIntOffset($text) {
        preg_match('/\d/', $text, $m, PREG_OFFSET_CAPTURE);
        if (sizeof($m)) {
            return $m[0][1]; // 24 in your example
        }
        // return anything you need for the case when there's no numbers in the string
        return strlen($text);
    }

    /**
     * @param $array
     * @param $value
     * @return array
     */
    public static function ArrUpdateLast(&$array, $value) : array
    {
        array_pop($array);
        array_push($array, $value);
        return $array;
    }

    /**
     * @param string $tcno
     * @return bool
     */
    public static function TCVerify(string $tcno) : bool
    {
        if (!preg_match('/^[1-9]{1}[0-9]{9}[0,2,4,6,8]{1}$/', $tcno)) {
            return false;
        }
        $_tcNo = str_split($tcno);
        $odd = (int)$_tcNo[0] + (int)$_tcNo[2] + (int)$_tcNo[4] + (int)$_tcNo[6] + (int)$_tcNo[8];
        $even = (int)$_tcNo[1] + (int)$_tcNo[3] + (int)$_tcNo[5] + (int)$_tcNo[7];
        $digit10 = ($odd * 7 - $even) % 10;
        $total = ($odd + $even + (int)$_tcNo[9]) % 10;
        if ($digit10 != $_tcNo[9] ||  $total != $_tcNo[10]) {
            return false;
        }
        return true;
    }

    /**
     * @param string $cn
     * @return string
     */
    public static function ClassToId(string $cn) : string
    {
        return str_replace('\\','_',$cn);
    }

    /**
     * @param string $cn
     * @return string
     */
    public static function MethodToCallback(string $cn) : string
    {
        $cn = str_replace('\\','_',$cn);
        $arr = explode("::",$cn);
        $addr = array_shift($arr);
        $func = current($arr);
        $arr = explode("_",$addr);
        array_shift($arr);
        array_pop($arr);
        return implode($arr)."_".$func;
    }

    /**
     * @param $camelCaseString
     * @param string $seperator
     * @return string
     */
    public static function FromCamelCase($camelCaseString,string $seperator=" ") {
        $re = '/(?<=[a-z])(?=[A-Z])/x';
        $a = preg_split($re, $camelCaseString);
        return join($seperator, $a );
    }

    /**
     * @param $str
     * @return string
     */
    public static function ToCamelCase($str) : string
    {
        return str_replace('_', '', ucwords($str, '_'));
    }

    /**
     * @param string $suffix
     * @param string|null $hi
     * @param string|null $clock
     * @param string|null $node
     * @return string
     */
    public static function GetIMUuid(string $suffix,?string $hi=null,?string $clock=null,?string $node=null,string $filler="0") : string
    {
        $uuid = \UUID\UUID::uuid7();
        $arr = explode("-",$uuid);
        $arr[2] = (!is_null($hi)) ? self::FitStr($hi,4,$filler) : $arr[2];
        $arr[3] = (!is_null($clock)) ? self::FitStr($clock,4,$filler) : $arr[3];
        $arr[4] = (!is_null($node)) ? self::FitStr($node,12,$filler) : $arr[4];
        $arr[5] =  self::FitStr($suffix,13,$filler);

        return implode("-",$arr);
    }

    /**
     * @param string|null $low
     * @param string|null $mid
     * @param string|null $hi
     * @param string|null $clock
     * @param string|null $node
     * @return string
     */
    public static function GetUuid(?string $low=null,?string $mid=null,?string $hi=null,?string $clock=null,?string $node=null) : string
    {
        $uuid = \UUID\UUID::uuid7();
        $arr = explode("-",$uuid);
        $arr[0] = (!is_null($low)) ? self::FitStr($low,8) : $arr[0];
        $arr[1] = (!is_null($mid)) ? self::FitStr($mid,4) : $arr[1];
        $arr[2] = (!is_null($hi)) ? self::FitStr($hi,4) : $arr[2];
        $arr[3] = (!is_null($clock)) ? self::FitStr($clock,4) : $arr[3];
        $arr[4] = (!is_null($node)) ? self::FitStr($node,12) : $arr[4];

        return implode("-",$arr);
    }

    /**
     * @param string|null $low
     * @param string|null $mid
     * @param string|null $hi
     * @param string|null $clock
     * @param string|null $node
     * @param string|null $filler
     * @return string
     */
    public static function Uuidze(?string $low=null,?string $mid=null,?string $hi=null,?string $clock=null,?string $node=null,?string $filler=null) : string
    {
        $arr[0] = (!is_null($low)) ? self::FitStr($low,8,$filler) : self::FitStr("",8,$filler);
        $arr[1] = (!is_null($mid)) ? self::FitStr($mid,4,$filler) : self::FitStr("",4,$filler);
        $arr[2] = (!is_null($hi)) ? self::FitStr($hi,4,$filler) : self::FitStr("",4,$filler);
        $arr[3] = (!is_null($clock)) ? self::FitStr($clock,4,$filler) : self::FitStr("",4,$filler);
        $arr[4] = (!is_null($node)) ? self::FitStr($node,12,$filler) : self::FitStr("",12,$filler);
        return implode("-",$arr);
    }

    /**
     * @param string $str
     * @param int $max
     * @param string $filler
     * @return string
     */
    public static function FitStr(string $str, int $max, string $filler="0") : string
    {
        $_len = (int)strlen($str);
        if($_len >= $max) {
            return substr($str, 0, $max);
        }
        if($filler === "random") {
            return $str.strtolower(self::randomChars($max - strlen($str)));
        }

        return strtolower(str_pad($str,$max,$filler,STR_PAD_LEFT));
    }

    /**
     * @param $messages
     * @return array
     */
    public static function ParseFormMessages($messages) : array
    {
        $r = [];
        foreach($messages as $m) {
            $r[] = $m->getMessage();
        }
        return $r;
    }

    /**
     * @param $key
     * @param $num
     * @return string
     */
    public static function GenerateEInvoiceID($key,$num) : string
    {
        $num_length = strlen((string)$num);
        $left = (16 - ($num_length+7));
        $ID = $key.date('Y').str_repeat("0",$left).$num;
        return $ID;
    }
}
