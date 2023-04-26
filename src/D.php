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
    public static function RangeMonth ($datestr)
    {
        date_default_timezone_set (date_default_timezone_get());
        $dt = strtotime ($datestr);
        return array (
            "start" => date ('Y-m-d', strtotime ('first day of this month', $dt)),
            "end" => date ('Y-m-d', strtotime ('last day of this month', $dt))
        );
    }

    public static function RangeWeek ($datestr) {
        date_default_timezone_set (date_default_timezone_get());
        $dt = strtotime ($datestr);
        return array (
            "start" => date ('N', $dt) == 1 ? date ('Y-m-d', $dt) : date ('Y-m-d', strtotime ('last monday', $dt)),
            "end" => date('N', $dt) == 7 ? date ('Y-m-d', $dt) : date ('Y-m-d', strtotime ('next sunday', $dt))
        );
    }

    public static function WeekNumber($dateStr)
    {
        $date = new \DateTime($dateStr);
        $week = $date->format("W");
        return (int) $week;
    }

    public static function GetStartAndEndDateFromWeekNumber($week,$year)
    {
        $dto = new \DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('Y-m-d');
        return $ret;
    }

    public static function GetSundaysForTheMonth($y, $m, $lm)
    {
        return new \DatePeriod(
            new \DateTime("first sunday of $y-$m") <= new \DateTime('today') ? new \DateTime("next sunday") : new \DateTime("first sunday of $y-$m"),
            \DateInterval::createFromDateString('next sunday'),
            new \DateTime("last day of $y-$lm 23:59:59")
        );
    }

    public static function RangeDay($timeStamp,$timeZone='Europe/Berlin')
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

    public static function CountDays($timeStart,$timeEnd)
    {
        $start = new \DateTime();
        $start->setTimestamp($timeStart);

        $end = new \DateTime();
        $end->setTimestamp($timeEnd);
        $diff = $start->diff($end);
        return $diff->days;
    }

    public static function GetWorkingDays($startDate,$endDate,$holidays=[]){

        //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
        //We add one to inlude both dates in the interval.
        $days = ($endDate - $startDate) / 86400 + 1;

        $no_full_weeks = floor($days / 7);
        $no_remaining_days = fmod($days, 7);

        //It will return 1 if it's Monday,.. ,7 for Sunday
        $the_first_day_of_week = date("N", $startDate);
        $the_last_day_of_week = date("N", $endDate);

        //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
        //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
        if ($the_first_day_of_week <= $the_last_day_of_week) {
            if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
            if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
        }
        else {
            // (edit by Tokes to fix an edge case where the start day was a Sunday
            // and the end day was NOT a Saturday)

            // the day of the week for start is later than the day of the week for end
            if ($the_first_day_of_week == 7) {
                // if the start date is a Sunday, then we definitely subtract 1 day
                $no_remaining_days--;

                if ($the_last_day_of_week == 6) {
                    // if the end date is a Saturday, then we subtract another day
                    $no_remaining_days--;
                }
            }
            else {
                // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
                // so we skip an entire weekend and subtract 2 days
                $no_remaining_days -= 2;
            }
        }

        //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
        $workingDays = $no_full_weeks * 5;
        if ($no_remaining_days > 0 )
        {
            $workingDays += $no_remaining_days;
        }

        //We subtract the holidays
        foreach($holidays as $holiday){
            $time_stamp=strtotime($holiday);
            //If the holiday doesn't fall in weekend
            if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
                $workingDays--;
        }

        return $workingDays;
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