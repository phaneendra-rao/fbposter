<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Member;
use App\Group;
use Illuminate\Support\Facades\Storage;
use App\MemberPost;

use Carbon\Carbon;


class postscontroller extends Controller
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

    public function groupData($id)
    {
        $data = Post::where('group_id', $id)->orderBy('id', 'desc')->first()->toArray();
        if (!empty($data)) {
            $last_post_created_time = $data['created_at'];
            $dt = new \DateTime($last_post_created_time);
            $last_created_date = $dt->format('Y-m-d');
            $dt = new \DateTime();
            $today = $dt->format('Y-m-d');

            $date1 = date_create($last_created_date);
            $date2 = date_create($today);
            $diff = date_diff($date1, $date2);
            return response()->json($diff->d);
        }
    }

    public function groupPosts($id)
    {
        // $posts = Group::find($id)->posts;
        $postsarr = [];
        $commentcount = [];
        $posts = Post::with(['memberposts' => function ($query) {
            $query->whereRaw("DATE_FORMAT(FROM_UNIXTIME(`timestamp`), '%Y-%m-%d') <= '" . date('Y-m-d') . "'");
            $query->where("posted", '=', 0);
        }])->where('group_id', $id)->get();
        // return response()->Json($posts);

        foreach ($posts as $key => $post) {
            $one_count = $zero_count = 0;
            foreach ($post->memberposts as $memberpost) {

                if ($memberpost->posted == 1) {
                    $one_count++;
                } else {
                    $zero_count++;
                }
            }
            $post->one = $one_count;
            $post->zero = $zero_count;
            $postsarr[$key] = $post;
        }
        // array_push($posts,$commentcount)
        return ($postsarr);
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
            'name' =>  'required',
            'url' => 'required',
            'comment' =>  'required',
            'days_after_post' => 'required',
            'image'  =>  'required|image|max:2048'
        ]);



        $image = $request->file('image');

        $filenamewithpath = Storage::putFile('public/post_images', $request->file('image'));

        $filename = str_replace('public/post_images/', '', $filenamewithpath);

        $form_data = array(
            'group_id' => $request->group_id,
            'name' => $request->name,
            'url' => $request->url,
            'comment' => $request->comment,
            'days_after_post' => $request->days_after_post,
            'image' => $filename
        );

        Post::create($form_data);

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
                'message' => 'Successfully registered.',
            ]
        ],);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return response()->Json($post);
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
        $request->validate([
            'group_id' => 'required',
            'name' =>  'required',
            'url' => 'required',
            'comment' =>  'required',
            'days_after_post' =>  'required',
        ]);
        $post = Post::find($id);

        $post->name = $request->name;
        $post->url = $request->url;
        $post->comment = $request->comment;
        $post->days_after_post = $request->days_after_post;

        if ($request->file('image')) {

            $image = $request->file('image');

            $filenamewithpath = Storage::putFile('public/post_images', $request->file('image'));

            $filename = str_replace('public/', '', $filenamewithpath);

            $post->image = "/storage/" . $filename;
        }

        $post->save();

        return response()->json([
            'response' => [
                'api_status' => 1,
                'code' => 201,
                'message' => 'Successfully updated.',
            ]
        ],);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::find($id)->delete();
        return response()->json([
            'response' => [
                'api_status' => 1,
                'code' => 201,
                'message' => 'Successfully deleted.',
            ]
        ],);
    }
}
