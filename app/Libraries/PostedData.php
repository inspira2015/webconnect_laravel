<?php

namespace App\Libraries;


class PostedData
{
	public function getTermFromUserInput($find)
    {
    	$splitArray = explode(" ", $find);
    	return [
    			 'm_id' 		  => $splitArray[0],
    		   ];
    }
}