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
        openlog('php', LOG_CONS | LOG_NDELAY | LOG_PID, LOG_USER | LOG_PERROR);
        syslog(LOG_INFO, print_r($message,true)."\n");
        closelog();
    }

    /**
     * @param $message
     * @param string $type
     */
    public static function lerr($message,$type='debug')
    {
        //syslog(LOG_WARNING,print_r($message,true));
        //file_put_contents(R_DIR.'log.txt', print_r($message,true)."\n", FILE_APPEND);
        openlog('php', LOG_CONS | LOG_NDELAY | LOG_PID, LOG_USER | LOG_PERROR);
        syslog(LOG_ERR, print_r($message,true)."\n");
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
        openlog('php', LOG_CONS | LOG_NDELAY | LOG_PID, LOG_USER | LOG_PERROR);
        syslog(LOG_WARNING, print_r($message,true)."\n");
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
    public static function validateIp($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP,
                FILTER_FLAG_IPV4 |
                FILTER_FLAG_IPV6 |
                FILTER_FLAG_NO_PRIV_RANGE |
                FILTER_FLAG_NO_RES_RANGE) === false)
            return false;
        self::$ip = $ip;
        return true;
    }

    /**
     * randomChars#
     * generates random string
     */
    public static function randomChars ($pw_length = 8, $numOnly = false,$noNum=false,$isPlate=false) {
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
                @mt_srand ((double)microtime() * 1000000);
                // random limits within ASCII table
                $randnum = mt_rand ($lower_ascii_bound, $upper_ascii_bound);
                if (!in_array ($randnum, $notuse)) {
                    $password = $password . chr($randnum);
                    $i++;
                }
            }
        } else {
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
        //$sign = (!$sign) ? "<i class=\"fa fa-try\" aria-hidden=\"true\"></i>" : $sign;
        //return money_format('%(#10n',$money);
        $locale  = 'tr_TR';
        switch ($currency) {
            case 'TRY': $locale = 'tr_TR'; break;
            case 'USD': $locale = 'en_US'; break;
            case 'AZN': $locale = 'az_Latn'; break;
            case 'GBP': $locale = 'en_GB'; break;
            case 'EUR': $locale = 'en_DE'; break;
        }

        $fmt = new \NumberFormatter( $locale, \NumberFormatter::CURRENCY );
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

    public static function toTimeEndUnix($time)
    {
        $uTime = strtotime($time);
        return mktime(23,59,59,date('m',$uTime),date('d',$uTime),date('Y',$uTime));
    }

    public static function Common2Time($common,$isHourly=false,$hourSeperator="T",$zoneSeperator="+")
    {
        if(strlen($common) < 2) {
            return 0;
        }
        $_base = explode($zoneSeperator,$common);
        $time = strtotime(str_replace($hourSeperator,"",$_base[0]));
        $timeAdd = str_replace(["0",":"],"",$_base[1]);
        if($isHourly) {
            $time = $time + (60*60)*$timeAdd;
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
    public static function CountFilesInDir($path)
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
     * @param $dir
     * @param $baseDir
     * @param $path
     * @return bool
     */
    public static function parseFDirExt($dir,$baseDir,$path)
    {
        $r = false;
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
     */
    public static function parseFDirFlat($dir,$baseDir,$path,$r=array())
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

    public static function NiceNumber($number,$decimals=0,$dSeperator=",",$tSeperator=".")
    {
        return number_format($number,$decimals,$dSeperator,$tSeperator);
    }

    public static function numberToWord( $num = '' )
    {
        $num    = ( string ) ( ( int ) $num );
        if( ( int ) ( $num ) && ctype_digit( $num ) )  {
            $words  = array( );
            $num    = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );

            $list1  = ['','bir','iki','üç','dört','beş','altı','yedi', 'sekiz','dokuz'];
            $list2  = ['','on','yirmi','otuz','kırk','elli','altmış', 'yetmiş','seksen','doksan','yüz'];
            $list3  = ['','bin','milyon','milyar','trilyon','katrilyon','kentrilyon','seksilyon','septilyon'];

            $numLength = strlen( $num );
            $levels = ( int ) ( ( $numLength + 2 ) / 3 );
            $maxLength = $levels * 3;
            $num    = substr( '00'.$num , -$maxLength );
            $numLevels = str_split( $num , 3 );

            foreach( $numLevels as $numPart ) {
                $levels--;
                $hundreds  = ( int ) ( $numPart / 100 );
                $hundreds  = ( $hundreds ? ' ' . $list1[$hundreds] . ' Yüz' . ( $hundreds == 1 ? '' : ' ' ) . ' ' : '' );
                $hundreds = str_replace("bir","",$hundreds);
                $tens = ( int ) ( $numPart % 100 );

                $tens = ( int ) ( $tens / 10 );
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = ( int ) ( $numPart % 10 );
                $singles = ' ' . $list1[$singles] . ' ';
                $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $numPart ) ) ? ' ' . $list3[$levels] . ' ' : '' );
            }

            $commas = count( $words );
            if( $commas > 1 )  {
                $commas = $commas - 1;
            }
            $words  = implode( ', ' , $words );

            //Some Finishing Touch
            //Replacing multiples of spaces with one space
            $words  = trim( str_replace( ' ,' , ',' , self::trimAll( ucwords( $words ) ) ) , ', ' );
            if( $commas )  {
                $words  = self::strReplaceLast( ',' , ' ,' , $words );
            }

            return $words;
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

    public static function ArrUpdateLast(&$array, $value){
        array_pop($array);
        array_push($array, $value);
        return $array;
    }


    public static function TCVerify($tcno)
    {
        if (!preg_match('/^[1-9]{1}[0-9]{9}[0,2,4,6,8]{1}$/', $tcno)) {
            return false;
        }

        $odd = $tcno[0] + $tcno[2] + $tcno[4] + $tcno[6] + $tcno[8];
        $even = $tcno[1] + $tcno[3] + $tcno[5] + $tcno[7];
        $digit10 = ($odd * 7 - $even) % 10;
        $total = ($odd + $even + $tcno[9]) % 10;
        if ($digit10 != $tcno[9] ||  $total != $tcno[10]) {
            return false;
        }
        return true;
    }

    public static function ClassToId($cn)
    {
        return str_replace('\\','_',$cn);
    }

    public static function MethodToCallback($cn)
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

    public static function GetUuid($low=false,$mid=false,$hi=false,$clock=false,$node=false)
    {
        $random = new \Phalcon\Encryption\Security\Random();
        $uuid = $random->uuid();
        $arr = explode("-",$uuid);
        $arr[0] = ($low) ? u::FitStr($low,8) : $arr[0];
        $arr[1] = ($mid) ? u::FitStr($mid,4) : $arr[1];
        $arr[2] = ($hi) ? u::FitStr($hi,4) : $arr[2];
        $arr[3] = ($clock) ? u::FitStr($clock,4) : $arr[3];
        $arr[4] = ($node) ? u::FitStr($node,12) : $arr[4];

        return implode("-",$arr);
    }

    public static function Uuidze($low=false,$mid=false,$hi=false,$clock=false,$node=false,$filler=false)
    {
        $arr[0] = ($low) ? u::FitStr($low,8,$filler) : u::FitStr("",8,$filler);
        $arr[1] = ($mid) ? u::FitStr($mid,4,$filler) : u::FitStr("",4,$filler);
        $arr[2] = ($hi) ? u::FitStr($hi,4,$filler) : u::FitStr("",4,$filler);
        $arr[3] = ($clock) ? u::FitStr($clock,4,$filler) : u::FitStr("",4,$filler);
        $arr[4] = ($node) ? u::FitStr($node,12,$filler) : u::FitStr("",12,$filler);
        return implode("-",$arr);
    }

    public static function FitStr($str,$max,$filler=false)
    {
        if(strlen($str) >= $max) {
            return substr($str, 0, $max);
        }
        if($filler === false) {
            return $str.strtolower(u::randomChars($max - strlen($str)));
        }
        return $str.strtolower(str_repeat($filler, $max - strlen($str)));
    }

    /**
     * @param $messages
     * @return array
     */
    public static function ParseFormMessages($messages)
    {
        $r = [];
        foreach($messages as $m) {
            $r[] = $m->getMessage();
        }
        return $r;
    }

    public static function GenerateEInvoiceID($key,$num)
    {
        $num_length = strlen((string)$num);
        $left = (16 - ($num_length+7));
        $ID = $key.date('Y').str_repeat("0",$left).$num;
        return $ID;
    }

    public static function HtmlPurify($text)
    {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('Core.Encoding', 'UTF-8');
        $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
        $allowedElements = [
            'p[style]',
            'br',
            'b',
            'strong',
            'i',
            'em',
            's',
            'u',
            'ul',
            'ol',
            'li',
            'span[class]',
            'table[border|cellpadding|cellspacing]',
            'tbody',
            'tr',
            'td[valign]',
        ];

        $config->set('HTML.Allowed', implode(',', $allowedElements));

        $def = $config->getHTMLDefinition(true);
        $purifier = new \HTMLPurifier($def);
      