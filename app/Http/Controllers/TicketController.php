<?php

namespace App\Http\Controllers;

use App\Jobs\LoadImageUrl;
use Illuminate\Http\Request;
use App\Ticket;

class TicketController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->user()->id)->get();

        return view('user.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @throws ???
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ticket = new Ticket();
        $data = $this->validate($request, [
            'description' => 'required',
            'title' => 'required',
            'original_image_url' => 'required'
        ]);

        $data['user_id'] = auth()->user()->id;
        $ticket->saveTicket($data);
        dispatch(new LoadImageUrl($ticket));
        return redirect('/tickets')
            ->with('success', 'New support ticket has been created! Wait sometime to get resolved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->first();

        return view('user.edit', compact('ticket', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws ???
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ticket = new Ticket();
        $data = $this->validate($request, [
            'description' => 'required',
            'title' => 'required',
            'original_image_url' => 'required'
        ]);
        $data['id'] = $id;
        $data['user_id'] = auth()->user()->id;
        $ticket->updateTicket($data);

        return redirect('/tickets')->with('success', 'New support ticket has been updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();

        return redirect('/tickets')->with('success', 'Ticket has been deleted!!');
    }
}
