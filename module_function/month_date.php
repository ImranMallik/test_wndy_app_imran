<?php

function leapYearCheck($year)
{
    $leapYear = 'No';
    if ($year % 400 == 0)
        $leapYear = 'Yes';
    else if ($year % 100 == 0)
        $leapYear = 'No';
    else if ($year % 4 == 0)
        $leapYear = 'Yes';
    else
        $leapYear = 'No';

    return $leapYear;
}

function getFirstDateofMonth($month, $year)
{
    global $firstDate;

    switch ($month) {
        case "April":
            $firstDate = $year . "-04-01";
            break;
        case "May":
            $firstDate = $year . "-05-01";
            break;
        case "June":
            $firstDate = $year . "-06-01";
            break;
        case "July":
            $firstDate = $year . "-07-01";
            break;
        case "August":
            $firstDate = $year . "-08-01";
            break;
        case "September":
            $firstDate = $year . "-09-01";
            break;
        case "October":
            $firstDate = $year . "-10-01";
            break;
        case "November":
            $firstDate = $year . "-11-01";
            break;
        case "December":
            $firstDate = $year . "-12-01";
            break;
        case "January":
            $firstDate = $year . "-01-01";
            break;
        case "February":
            $firstDate = $year . "-02-01";
            break;
        case "March":
            $firstDate = $year . "-03-01";
            break;
    }
    return $firstDate;
}

function getLastDateofMonth($month, $year)
{
    global $lastDate;

    switch ($month) {
        case "April":
            $lastDate = $year . "-04-30";
            break;
        case "May":
            $lastDate = $year . "-05-31";
            break;
        case "June":
            $lastDate = $year . "-06-30";
            break;
        case "July":
            $lastDate = $year . "-07-31";
            break;
        case "August":
            $lastDate = $year . "-08-31";
            break;
        case "September":
            $lastDate = $year . "-09-30";
            break;
        case "October":
            $lastDate = $year . "-10-31";
            break;
        case "November":
            $lastDate = $year . "-11-30";
            break;
        case "December":
            $lastDate = $year . "-12-31";
            break;
        case "January":
            $lastDate = $year . "-01-31";
            break;
        case "February":
            if (leapYearCheck($year) == "Yes") {
                $lastDate = $year . "-02-29";
            } else {
                $lastDate = $year . "-02-28";
            }
            break;
        case "March":
            $lastDate = $year . "-03-31";
            break;
    }
    return $lastDate;
}
