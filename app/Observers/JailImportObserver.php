<?php

namespace App\Observers;
use App\Models\JailImport;

class JailImportObserver
{
   public function creating(JailImport $item)
   {
   		foreach ($item->getAttributes() as $property => $value) {
   			$item->$property = trim($value);
   		}
   		$item->created_at = date('Y-m-d H:i:s');
    }
}