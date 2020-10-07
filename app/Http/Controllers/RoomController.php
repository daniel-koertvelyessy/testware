<?php

namespace App\Http\Controllers;

use App\Room;
use App\Standort;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoomController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        return view('admin.standorte.room.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        return view('admin.standorte.room.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $set = Room::create($this->validateNewRoom());

        (new \App\Standort)->add($request->standort_id, $request->r_name_kurz,'rooms');

        $request->session()->flash('status', 'Der Raum <strong>' . request('r_name_kurz') . '</strong> wurde angelegt!');

return  redirect()->back();
    }

    public function copyRoom(Request $request) {

        if ($request->id){

            $bul = Room::find($request->id);
            $neuroom = '';
            switch (true)
            {
                case strlen($bul->r_name_kurz) <= 20 && strlen($bul->r_name_kurz) > 14:
                    $neuroom = substr($bul->r_name_kurz,0,13).'_1';
                    break;
                case strlen($bul->b_name_kurz) <= 14:
                    $neuroom = $bul->r_name_kurz.'_1';
                    break;
            }

            $bul->r_name_kurz = $neuroom;
            $copy = new Room();
            $copy->r_name_kurz = $neuroom;
            $copy->r_name_text = $bul->r_name_text;
            $copy->r_name_lang = $bul->r_name_lang;
            $copy->building_id = $bul->building_id;
            $copy->room_type_id = $bul->room_type_id;
            $copy->standort_id = Str::uuid();
//            $copy->
            $validator = Validator::make([
                $copy->r_name_kurz,
                $copy->r_name_text,
                $copy->r_name_lang,
                $copy->building_id,
                $copy->room_type_id,
                $copy->standort_id,
            ], [
                'r_name_kurz' => 'bail|required|unique:rooms,r_name_kurz|max:20',
                'r_name_text' =>'',
                'r_name_lang' =>'',
                'building_id' =>'',
                'room_type_id' =>'',
                'standort_id' =>'',

            ]);
            $copy->save();

            $std = (new \App\Standort)->add($copy->standort_id, $neuroom,'rooms');

            $request->session()->flash('status', 'Der Raum <strong>' . request('r_name_kurz') . '</strong> wurde kopiert!');
            return $copy->id;
        } else {
            return 0;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param Room $room
     * @return Response
     */
    public function show(Room $room)
    {
        return view('admin.standorte.room.show',['room'=>$room]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Room $room
     * @return Response
     */
    public function edit(Room $room)
    {
        return view('admin.standorte.room.edit',compact('room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Room $room
     * @return Response
     */
    public function update(Request $request, Room $room)
    {

//        dd($room);
        $room->update($this->validateRoom());

        $request->session()->flash('status', 'Der Raum <strong>' . $room->r_name_kurz . '</strong> wurde aktualisiert!');
        return redirect($room->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Room $room
     * @param Request $request
     *
     * @return Application|RedirectResponse|Response|Redirector
     * @throws Exception
     */
    public function destroy(Request $request,Room $room)
    {
        dd($request);
        Room::destroy($request->id);
        $request->session()->flash('status', 'Der Raum <strong>' . request('r_name_kurz') . '</strong> wurde gelöscht!');
        return (isset($request->frmOrigin)) ? redirect('building/'.$request->building_id.'#gebRooms') : redirect('room');
    }

    /**
     * Lösche Raum aus GebäudeView über Ajax-Request.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function destroyRoomAjax(Request $request)
    {

        $rm = Room::find($request->id)->standort_id;

        $rname = request('r_name_kurz');
        if ( Room::destroy($request->id) ){

            $request->session()->flash('status', 'Der Raum <strong>' . $rname . '</strong> wurde gelöscht!');
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function validateRoom(): array
    {
        return request()->validate([
            'r_name_kurz' => 'bail|min:2|max:10|required|',
            'r_name_lang' =>'bail|min:2|max:100',
            'r_name_text' =>'',
            'building_id' =>'required'
        ]);
    }

    /**
     * @return array
     */
    public function validateNewRoom(): array
    {
        return request()->validate([
            'r_name_kurz' => 'bail|unique:rooms,r_name_kurz|max:20|required|',
            'standort_id' => 'unique:rooms,standort_id',
            'r_name_lang' =>'max:100',
            'r_name_text' =>'',
            'building_id' =>'required',
            'room_type_id' =>'required'
        ]);
    }
}
