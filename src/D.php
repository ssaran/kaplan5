<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 24.04.2018
 * Time: 14:21
 */

namespace K5;


class D
{
    public static function RangeMonth ($datestr) : array
    {
        date_default_timezone_set (date_default_timezone_get());
        $dt = strtotime ($datestr);
        return array (
            "start" => date ('Y-m-d', strtotime ('first day of this month', $dt)),
            "end" => date ('Y-m-d', strtotime ('last day of this month', $dt))
        );
    }

    public static function RangeWeek ($datestr) : array
    {
        date_default_timezone_set (date_default_timezone_get());
        $dt = strtotime ($datestr);
        return array (
            "start" => date ('N', $dt) == 1 ? date ('Y-m-d', $dt) : date ('Y-m-d', strtotime ('last monday', $dt)),
            "end" => date('N', $dt) == 7 ? date ('Y-m-d', $dt) : date ('Y-m-d', strtotime ('next sunday', $dt))
        );
    }

    public static function WeekNumber($dateStr) : int
    {
        $date = new \DateTime($dateStr);
        $week = $date->format("W");
        return (int) $week;
    }

    public static function GetStartAndEndDateFromWeekNumber($week,$year) : array
    {
        $dto = new \DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('Y-m-d');
        return $ret;
    }

    public static function GetSundaysForTheMonth($y, $m, $lm) : \DatePeriod
    {
        return new \DatePeriod(
            new \DateTime("first sunday of $y-$m") <= new \DateTime('today') ? new \DateTime("next sunday") : new \DateTime("first sunday of $y-$m"),
            \DateInterval::createFromDateString('next sunday'),
            new \DateTime("last day of $y-$lm 23:59:59")
        );
    }

    public static function RangeDay($timeStamp,$timeZone='Europe/Berlin') : \stdClass
    {
        $datetime = new \DateTime();
        $datetime->setTimestamp($timeStamp);
        $dtNow = clone $datetime;
        $dtNow->setTimezone(new \DateTimeZone($timeZone));
        $beginOfDay = clone $dtNow;
        $beginOfDay->modify('today');

        $endOfDay = clone $beginOfDay;
        $endOfDay->modify('tomorrow');
        $endOfDay->modify('1 second ago');
        $r = new \stdClass();
        $r->start = $beginOfDay;
        $r->end = $endOfDay;

        return $r;
    }

    public static function CountDays($timeStart,$timeEnd) : int
    {
        $start = new \DateTime();
        $start->setTimestamp($timeStart);

        $end = new \DateTime();
        $end->setTimestamp($timeEnd);
        $diff = $start->diff($end);
        return $diff->days;
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $holidays
     * @return int
     */
    public static function GetWorkingDays($startDate,$endDate,$holidays=[]) : int
    {
        $workingDays = 0;

        // Ensure the start date is before the end date
        if ($startDate > $endDate) {
            return 0;
        }

        // Loop through each day between start and end date
        for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += 86400) {
            // Get the day of the week for the current date
            $dayOfWeek = date('N', $currentDate); // 1 (Monday) to 7 (Sunday)

            // If it's a working day (Monday to Friday), and not a holiday, increment the count
            if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && !in_array($currentDate, $holidays)) {
                $workingDays++;
            }
        }
        return (int)$workingDays;
    }

    public static function CountSameDays($startDate,$endDate,$dayName)
    {
        $c = 0;
        for($i = strtotime($dayName, strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i)) {
            $c++;
        }
        return $c;
    }


    /**
     * @param $timestamp
     * @param bool $isTr
     * @param bool $isLong
     * @return string
     */
    public static function TimeAgo($timestamp,$isTr=false,$isLong=false)
    {
        if($timestamp == 0) {
            return "-";
        }

        if(!$isTr) {
            $end = " vor ";
            $strTime = array("second", "minute", "hour", "day", "month", "year");
            $strTime = array("zweite", "minute", "stunde", "tag", "monat", "jahr");
        } else {
            if(!$isLong) {
                $end = "ö.";
                $strTime = array("sn.", "dk.", "s.", "g.", "a.", "y.");
            } else {
                $end = " önce";
                $strTime = array("saniye", "dakika", "saat", "gün", "ay", "yıl");
            }
        }

        $length = array("60","60","24","30","12","10");

        $currentTime = time();
        if($currentTime >= $timestamp) {
            $diff     = time()- $timestamp;
            for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
                $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return $diff . " " . $strTime[$i] . $end;
        } else {
            $ret = '';
            $rem = $timestamp - $currentTime;
            $day = floor($rem / 86400);
            $hr  = floor(($rem % 86400) / 3600);
            $min = floor(($rem % 3600) / 60);
            $sec = ($rem % 60);
            if($day) {
                $ret.= $day." Tag ";
            } else {
                if($hr) {
                    $ret.= $hr." Stunden ";
                } else {
                    if($min) { $ret.= $min." Minuten "; }
                }
            }

            //if($sec) { $ret.= $sec." Saniye "; }
            return $ret." übrig.";
        }
    }

    public static function HourToSeconds($str_time)
    {
        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
        $time_seconds = isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds;

        return $time_seconds;
    }
}
