<?php

namespace App\Http\Web\Controllers\Mail;

use Domain\Mail\Actions\Broadcast\UpsertBroadcastAction;
use Domain\Mail\DTOs\Broadcast\BroadcastData;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Mail\ViewModels\Broadcast\GetBroadcastsViewModel;
use Domain\Mail\ViewModels\Broadcast\UpsertBroadcastViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class BroadcastController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Broadcast/List', [
            'model' => new GetBroadcastsViewModel($request->get('page', 1)),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        return Inertia::render('Broadcast/Form', [
            'model' => new UpsertBroadcastViewModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BroadcastData $data, Request $request)
    {
        UpsertBroadcastAction::execute($data, $request->user());
        return Redirect::route('broadcasts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Broadcast $broadcast): Response
    {
        return Inertia::render('Broadcast/Form', [
            'model' => new UpsertBroadcastViewModel($broadcast)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BroadcastData $data, Request $request)
    {
        UpsertBroadcastAction::execute($data, $request->user());
        return Redirect::route('broadcasts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
