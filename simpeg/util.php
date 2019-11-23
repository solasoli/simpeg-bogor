<?
	function toShortDate($date)
	{
		return substr($date, 8, 2)."-".substr($date, 5,2)."-".substr($date, 0, 4);
	}
	
	function getYear($date)
	{
		return substr($date, 0, 4);
	}
	
	function getMonth($date)
	{
		return substr($date, 5, 2);
	}
	
	function getDay($date)
	{
		return substr($date, 8, 2);
	}
?>