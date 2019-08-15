<?
/*
Assumes $day is a valid formatted time
*/
function getpreviousday($day)
{
    //convert the formatted date into a timestamp
    $day = strtotime($day);

    //subtract one day in seconds from the timestamp
    $day = $day - 86400;

    //return the final amount formatted as YYYY/MM/DD
    return date("Y/m/d",$day);
}

function getnextday($day)
{
    //convert the formatted date into a timestamp
    $day = strtotime($day);

    //add one day in seconds to the timestamp
    $day = $day + 86400;

    //return the final amount formatted as YYYY/MM/DD
    return date("Y/m/d",$day);
}

?>
