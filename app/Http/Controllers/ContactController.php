<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\IContactService;

class ContactController extends Controller
{
    
    public function save(Request $request, IContactService $contactService)
    {

    	
    	$data = $contactService->save($request->all());

    	if($data == 0) {
    		$val = '{"status": 200,"message": "No Records Saved."}';
    	} else {
    		$val = '{"status": 200,"message": "'. $data .' Records Successfully Saved."}';
    	}

    	$resp = json_decode($val);

    	return response()->json($resp);
    	// return response()->json($request);
    	// return "test";
    }


    public function getColumns(IContactService $contactService)
    {
    	$columns = $contactService->getColumns();
    	$columns = array_diff($columns, ["id", "created_at", "updated_at"]);
    	$columns = implode(",",$columns);
    	$columns = explode(",",$columns);

    	return $columns;
    }
}
