<?php

namespace App\Observers;
use App\Models\BailForfeitures;
use Auth;

class BailForfeituresObserver
{
	private $today;

	public function __construct()
	{
		$this->today = date('Y-m-d H:i:s');
	}

   public function creating(BailForfeitures $item)
   {
   		$user = Auth::user();
    	$item->user_id = $user->id;
     	$item->user_id = $user->id;
     	$item->bf_updated_at = $this->today;
     	$item->bf_create_at = $this->today;
   }

   public function updating(BailForfeitures $item)
   {
   		$item->bf_updated_at = $this->today;
   }
}