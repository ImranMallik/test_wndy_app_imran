<?php

function dateFormat($date)
{
	return date('d-m-y', strtotime($date));
}

function timeFormat($time)
{
	return date('g:i A', strtotime($time));
}

function dateTimeFormat($dateTime)
{
	return date('d-m-y g:i A', strtotime($dateTime));
}
