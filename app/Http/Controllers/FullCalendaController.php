<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class FullCalendaController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){

            $data = Event::whereDate('start','>=',$request->start)
                ->whereDate('end', '<=', $request->end)
                ->get(['id','title','start','end']);
            return response()->json($data);
        }
        return view('fullcalendar');
    }

    public function ajax(Request $request)
    {
        switch ($request->type)
        {
            case 'add':
                $event = Event::create([
                    'title' =>$request->title,
                    'start'=> $request->start,
                    'end' => $request->end,
                ]);
                break;
                return response()->json($event);
                


            case 'edit':
                $event = Event::find($request->id)->update([
                   'title'=> $request->title,
                    'start'=> $request->start,
                    'end'=> $request->end,
                ]);
                break;
                return response()->json($event);
                


            case 'destroy':
                $event = Event::find($request->id)->delete();
                break;
                return response()->json($event);
                

            default:
                # code ...
                break;
        }
    }
}
