<?php

namespace App\Services;

use App\Services\Interfaces\IContactService;
use App\Models\Contact;
use App\Models\CustomAttribute;

class ContactService implements IContactService
{
    public function save(array $req)
    {

    	$data = $req['data'];

    	//get columns
 		$table = new Contact;
 		$columns = $table->getTableColumns();
		
 		$count = 0; 

 		$customAttr = [];

 		//check fields
		foreach($data as $item) {
			$contact = new Contact;
			foreach($item as $key => $value) {
				if (in_array($key, $columns)) {
					$contact->$key = $value;
				} else {
					$custom = new CustomAttribute();
					$custom->key = $key;
					$custom->value = $value;
					array_push($customAttr, $custom);
				}
			}
			$fromDb = $this->contactExist($contact->phone);
			if($fromDb == null) {
				if($contact->save()) {
					$count+=1;
					$contact->customAttributes()->saveMany($customAttr);
					$customAttr = [];
				}
			} else {
				$strat = $req['type'];
				if($strat == 1) {
					// $contact->id = $fromDb->id;
					if($fromDb->update($contact->toArray())) {
						$count+=1;
						$fromDb->customAttributes()->saveMany($customAttr);
						$customAttr = [];
					}
				} else if ($strat == 0) {

				}
			}
			
		}

    	return $count;
    }


    public function getColumns() {
	 	$contact = new Contact;
 		$columns = $contact->getTableColumns();

 		return $columns;
    }

    private function contactExist($phone) {
    	return Contact::where('phone', '=', $phone)->first();
    }
}