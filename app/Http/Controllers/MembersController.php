<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Member;
use App\Post;
use App\MemberPost;
use Artisan;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $members = Member::where('group_id', $id)->get();

        return $members;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required',
            'name' =>  'required'
        ]);

        $members = $request->name;
        $text = trim($members);
        $membersarr = explode("\n", $text);
        $membersarr = array_filter($membersarr, 'trim');


        foreach ($membersarr as $membername) {
            $Member = new Member();
            $Member->group_id = $request->group_id;
            $Member->name = $membername;
            $Member->save();
        }

        // schedule command logic start
        $membersInTheGroup = Member::where('group_id', $request->group_id)->get();
        $postsInTheGroup = Post::where('group_id', $request->group_id)->get();

        $daysBeforePosting = 0;
        foreach ($postsInTheGroup as $singlePost) {

            $daysBeforePosting += $singlePost->days_after_post;


            foreach ($membersInTheGroup as $singleMember) {

                $memberPostRecord = MemberPost::firstOrNew([
                    ['group_id', $request->group_id],
                    ['member_id', $singleMember->id],
                    ['post_id', $singlePost->id]
                ]);
                $memberPostRecord->group_id = $request->group_id;
                $memberPostRecord->member_id = $singleMember->id;
                $memberPostRecord->post_id = $singlePost->id;
                $timestamp = $singleMember->created_at->timestamp + $daysBeforePosting * 86400;

                $memberPostRecord->timestamp = $timestamp;

                $memberPostRecord->save();
            }
        }

        // schedule command logic end

        return response()->json([
            'response' => [
                'api_status' => 1,
                'code' => 201,
                'message' => 'Successfully added members.',
            ]
        ],);

        Artisan::call('GeneratePostMemberPosts');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
