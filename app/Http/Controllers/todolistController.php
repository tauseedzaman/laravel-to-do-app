<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\todolist;
use Illuminate\Support\Facades\DB;

class todolistController extends Controller
{

    public function index()
    {
        return view('todolist');
    }
    //load database data
    public function loaddata()
    {
        $data = todolist::all();
        $output = '';
        if($data->count() > 0) {
            foreach ($data as $item) {
                $output .= "<div class='alert w3-cyan alert-dismissible' data-id='{$item->id}' >
                                        <svg data-id='{$item->id}' id='edit_btn' width='3%' class='float-right mr-3' style='cursor: pointer' viewBox='0 0 576 512' title='Edit Item'><path fill='yellow' d='M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z'></path></svg>
                                        <button class='close' id='delete_btn' data-id='{$item->id}'>X</button>
                                        <p id='message_p' >{$item->message}</p>
                                        <p class='text-light'>Posted:{$item->created_at->diffForHumans()}</p>
                                    </div>";
            }
        }else{
            $output = "<h1 class='alert alert-warning text-info text-capitalize text-center'>no data found</h1>";
        }
        return ($output);
    }

    //store record
    public function store(Request $request)
    {
        todolist::create([
            'message' =>$request->message,
        ]);
    }

    //edit record
    public function edit(Request $request)
    {
        $data = todolist::find($request->id);
        return response()->json(['data'=>$data]);
    }
    //update record
    public function update(Request $request)
    {
        $id = $request->id;
        todolist::find($id)->update([
            'message' => $request->message,
        ]);
    }
    //delete 1 record
    public function destroy(Request $request)
    {
        $d_id = $request->id;
        todolist::where('id',$d_id)->delete();
    }
    //delete all record
    public function destroyAll()
    {
        DB::table('todolists')->delete();
    }
}
