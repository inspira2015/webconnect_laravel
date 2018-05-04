<?php

namespace App\Libraries;
use Illuminate\Http\Request;
use Session;


class PostedData
{
	public function getTermFromUserInput($find)
    {
    	if (empty($find)) {
    		$find = Session::get('search_term');
    	}

    	$splitArray = explode(" ", $find);
  		//Session::forget('search_term');
    	return [
    			 'm_id' 		  => $splitArray[0],
                 'search_term'    => $find,
    		   ];
    }

    public function getErrorRedirectRoute($module)
    {
        if ($module == 'remission') {
            return 'remission';
        } else {
            return 'processbailsearch';
        }
    }
}