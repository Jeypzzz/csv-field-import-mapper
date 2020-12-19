<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\IContactService;

class ContactController extends Controller
{

    public function updateEmpty(Request $request, IContactService $contactService) {
        //validate request
        $rules = $this->getRules();
        $customMessages = $this->getCustomMessages();
        $data = $request->validate($rules, $customMessages);

        $data = $contactService->updateEmpty($request->all());

        if($data == 0) {
            $val = '{"status": 200,"message": "No Records Saved."}';
        } else {
            $val = '{"status": 200,"message": "'. $data .' Records Successfully Saved."}';
        }

        $resp = json_decode($val);
        return response()->json($resp);

    }

    public function updateValue(Request $request, IContactService $contactService) {
        //validate request
        $rules = $this->getRules();
        $customMessages = $this->getCustomMessages();
        $data = $request->validate($rules, $customMessages);

        $data = $contactService->updateValue($request->all());

        if($data == 0) {
            $val = '{"status": 200,"message": "No Records Saved."}';
        } else {
            $val = '{"status": 200,"message": "'. $data .' Records Successfully Saved."}';
        }

        $resp = json_decode($val);
        return response()->json($resp);

    }


    public function dontUpdate(Request $request, IContactService $contactService) {
        //validate request
        $rules = $this->getRules();
        $customMessages = $this->getCustomMessages();
        $data = $request->validate($rules, $customMessages);

        $data = $contactService->dontUpdate($request->all());

        if($data == 0) {
            $val = '{"status": 200,"message": "No Records Saved."}';
        } else {
            $val = '{"status": 200,"message": "'. $data .' Records Successfully Saved."}';
        }

        $resp = json_decode($val);
        return response()->json($resp);

    }

    public function getColumns(IContactService $contactService)
    {
    	$columns = $contactService->getColumns();
    	$columns = array_diff($columns, ["id", "created_at", "updated_at"]);
    	$columns = implode(",",$columns);
    	$columns = explode(",",$columns);

    	return $columns;
    }

    private function getRules() {
        return [
            'newContact' => 'required',
            'newContact.*.team_id' => 'required|numeric',
            'newContact.*.phone' => 'required',
            'newContact.*.sticky_phone_number_id' => 'numeric'
            
        ];
    }

    private function getCustomMessages() {
        return [
            'newContact.required' => 'Data is required.',
            'newContact.*.team_id.required' => 'The team_id field is required.',
            'newContact.*.team_id.numeric' => 'The team_id field must be a number.',
            'newContact.*.phone.required' => 'The phone field is required.',
            'newContact.*.sticky_phone_number_id.numeric' => 'The sticky_phone_number_id field must be a number.'
        ];
    }

        // public function save(Request $request, IContactService $contactService)
    // {
        
    //  $data = $contactService->save($request->all());

    //  if($data == 0) {
    //      $val = '{"status": 200,"message": "No Records Saved."}';
    //  } else {
    //      $val = '{"status": 200,"message": "'. $data .' Records Successfully Saved."}';
    //  }

    //  $resp = json_decode($val);

    //  return response()->json($resp);
    //  // return response()->json($request);
    //  // return "test";
    // }
}
