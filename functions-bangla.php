<?php
/**
 * WordPress Functions - for Bangla sites
 * @author: Mayeenul Islam (@mayeenulislam)
 * 
 * This function page can work under any WordPress theme
 * This page contains functions that are helpful for Bangla sites
 *
 * The code here, are collected from various sources
 * where the code is collected from somewhere, is mentioned as a comment
 * where it's solely of Mayeenul Islam, is also mentioned as a comment
*/



/**
 * BANGLA NUMBERS, DATES, DAYS AND MONTHS
 * i.e. ২৮ নভেম্বর ১৯৮৬
*/

function make_bangla_number($str)
{
    $engNumber = array('0','1','2','3','4','5','6','7','8','9');
    $bangNumber = array('০','১','২','৩','৪','৫','৬','৭','৮','৯');
    $converted = str_replace($engNumber, $bangNumber, $str);

    return $converted;
}
function make_bangla_day($strDay)
{
    $engDay = array('Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday');
    $bangDay = array('শনিবার','রবিবার','সোমবার','মঙ্গলবার','বুধবার','বৃহঃস্পতিবার','শুক্রবার');
    $convertedDay = str_replace($engDay, $bangDay, $strDay);

    return $convertedDay;
}
function make_bangla_months($strM)
{
    $engM = array('January','February','March','April','May','June','July','August','September','October','November','December','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
    $bangM = array('জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর');
    $convertedM = str_replace($engM, $bangM, $strM);

    return $convertedM;
}


add_filter( 'get_the_time', 'make_bangla_number' );
add_filter( 'the_date', 'make_bangla_number' );
add_filter( 'get_the_date', 'make_bangla_number' );

add_filter( 'comments_number', 'make_bangla_number' ); // comment form and all comments
add_filter( 'get_comment_date', 'make_bangla_number' ); // comment form and all comments
add_filter( 'get_comment_date', 'make_bangla_months' ); // comment form and all comments
add_filter( 'get_comment_time', 'make_bangla_number' ); // comment form and all comments

add_filter( 'the weekday', 'make_bangla_day' );
