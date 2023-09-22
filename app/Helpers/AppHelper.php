<?php

use Carbon\Carbon;

if(!function_exists("formatYMD"))
{
    function formatYMD($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
}

if(!function_exists("formatDMY"))
{
    function formatDMY($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }
}

if(!function_exists("formatDateTime"))
{
    function formatDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y - G:i:s');
    }
}

