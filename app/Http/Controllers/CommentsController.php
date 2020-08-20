<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Member;
use App\MemberPost;
use App\MemberPostBatch;
use App\Group;
use Carbon\Carbon;
use GuzzleHttp\Client;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function getMembers($id)
    {
        $post_id = $id;

        $post = Post::with('memberposts.member')->find($id);

        $post_comment = $post->comment;

        $members = array();
        $memberPosts = array();

        array_push($memberPosts, $post_comment);

        if (count($post->memberposts) > 0) {
            $limit = 1;

            foreach ($post->memberposts as $memberpost) {

                if ($memberpost->posted == 0 && $memberpost->timestamp < Carbon::now()->timestamp) {

                    if ($limit <= 20) {
                        array_push($members, $memberpost->member_id);
                        array_push($memberPosts, '@' . $memberpost->member->name . ' ');
                        $memberpost->posted = 1;

                        $memberpost->save();
                    } else {
                        break;
                    }

                    $limit++;
                }
            }
        }

        $fetched_members = json_encode($members);

        $memberpostbatch = new MemberPostBatch();

        $memberpostbatch->post_id = $post_id;
        $memberpostbatch->member_ids = $fetched_members;
        $memberpostbatch->save();

        return $memberPosts;
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
        //
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
