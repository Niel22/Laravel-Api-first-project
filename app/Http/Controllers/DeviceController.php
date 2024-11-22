<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

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

        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'member_id' => ['required', 'unique:devices,member_id']
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

        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'member_id' => ['required']
        ]);

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
}
