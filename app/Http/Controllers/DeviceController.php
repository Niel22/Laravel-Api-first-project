<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    public function list($id = null)
    {

        $list = $id ? Device::findOrFail($id) : Device::all();

        return response()->json([
            'data' => $list,
            'message' => 'collected'
        ]);
    }

    public function add(Request $request){

        $rules = array(
            'name' => ['required', 'min:3'],
            'member_id' => ['required', 'unique:devices,member_id']
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return $validator->errors();
        }

        $data = $validator->validated();


        return response()->json([
            'data' => $data
        ]);

        Device::create([
            'name' => $data['name'],
            'member_id' => $data['member_id']
        ]);

        return response()->json([
            'message' => 'Item Added Successfully'
        ], 200);

    }

    public function update(Request $request, $id){

        $device = Device::findOrFail($id);

        $rules = array(
            'name' => ['required', 'min:3'],
            'member_id' => ['required']
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return $validator->errors();
        }

        $data = $validator->validated();

        $device->update([
            'name' => $data['name'],
            'member_id' => $data['member_id']
        ]);

        return response()->json([
            'message' => $data['name'] . ' Updated Successfully'
        ], 200);
        
    }

    public function search($query){

        if(!$query){
            return response()->json([
                'result' => "Query parameter is missing"
            ], 400);
        }

        $data = Device::where('name', 'like', '%'.$query.'%')->get();

        if($data->isEmpty()){
            return response()->json([
                'result' => 'Search did not return any result'
            ], 404);
        }
        
        return response()->json([
            'result' => $data
        ], 200);
    }

    public function delete($id){

        Device::findOrFail($id)->delete();

        return ['success', 'Item Deleted Successfully'];
    }

    public function upload(Request $request){

        $rules = [
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return $validator->errors();
        }


        $result = $request->file('image')->store('apiDocs');

        $result = asset('storage/'. $result);

        return response()->json([
            'result' => $result
        ], 201);
    }
}
