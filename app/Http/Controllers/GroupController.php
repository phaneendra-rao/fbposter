<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Group;
use App\Http\Resources\GroupResource;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $groups = Group::all();
        return GroupResource::collection($groups);
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($group)
    {
        return new GroupResource($group);
    }


    /**
     * Store a  resource.
     * @return Response
     */
    public function store(Request $request)
    {
        $group = new Group;
        $group->name = $request->name;
        $group->client_name = $request->clientName;
        $group->url = $request->url;
        $group->phone = $request->phone;
        $group->save();
        return new GroupResource($group);
    }



    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $group)
    {
        $group->name = $request->name;
        $group->client_name = $request->clientName;
        $group->url = $request->url;
        $group->phone = $request->phone;
        $group->save();
        return new GroupResource($group);
    }
}
