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
        return view('admin.room.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        return view('admin.room.create');
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

return (isset($request->frmOrigin)) ? redirect('building/'.$request->building_id.'#gebRooms') : redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Room $room
     * @return Response
     */
    public function show(Room $room)
    {
        return view('admin.room.show',['room'=>$room]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Room $room
     * @return Response
     */
    public function edit(Room $room)
    {
        return view('admin.room.edit',compact('room'));
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
