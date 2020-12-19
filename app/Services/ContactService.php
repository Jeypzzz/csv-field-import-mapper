<?php

namespace App\Services;

use App\Services\Interfaces\IContactService;
use App\Models\Contact;
use App\Models\CustomAttribute;

class ContactService implements IContactService
{
    
    public function updateEmpty(array $req){
		//get columns
 		$table = new Contact;
 		$columns = $table->getTableColumns();

 		$data = $req['newContact'];
		
 		$count = 0; 
 		$customAttr = [];

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
				if(isset($fromDb->name) && !is_null($fromDb->name)) {
					$contact->name = $fromDb->name;
				}

				if(isset($fromDb->email) && !is_null($fromDb->email)) {
					$contact->email = $fromDb->email;
				}

				if(isset($fromDb->sticky_phone_number_id) && !is_null($fromDb->sticky_phone_number_id)) {
					$contact->sticky_phone_number_id = $fromDb->sticky_phone_number_id;
				}

				if($fromDb->update($contact->toArray())) {
					$count+=1;
					$fromDb->customAttributes()->saveMany($customAttr);
					$customAttr = [];
				}
			}
    	}

    	return $count;
    }

    public function updateValue(array $req){
    	//get columns
 		$table = new Contact;
 		$columns = $table->getTableColumns();

 		$data = $req['newContact'];
		
 		$count = 0; 
 		$customAttr = [];

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
				// $contact->id = $fromDb->id;
				if($fromDb->update($contact->toArray())) {
					$count+=1;
					$fromDb->customAttributes()->saveMany($customAttr);
					$customAttr = [];
				}
			}
    	}
    	return $count;
    }

    public function dontUpdate(array $req){
    	//get columns
 		$table = new Contact;
 		$columns = $table->getTableColumns();

 		$data = $req['newContact'];
		
 		$count = 0; 
 		$customAttr = [];

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