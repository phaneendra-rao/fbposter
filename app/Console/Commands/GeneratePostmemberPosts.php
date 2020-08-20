<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Group;
use App\Member;
use App\Post;
use App\MemberPost;
use Carbon\Carbon;

class GeneratePostmemberPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GeneratePostmemberPosts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $groupid = $this->argument('group_id');

        $groups = Group::all();


        foreach($groups as $singleGroup){

            $membersInTheGroup = Member::where('group_id', $singleGroup->id)->get();
            $postsInTheGroup = Post::where('group_id', $singleGroup->id)->get();
            
            $daysBeforePosting = 0;
            foreach($postsInTheGroup as $singlePost){

                $daysBeforePosting += $singlePost->days_after_post;


                foreach($membersInTheGroup as $singleMember)
                {

                    $memberPostRecord = MemberPost::firstOrNew([
                                                                 ['group_id',$singleGroup->id],
                                                                 ['member_id',$singleMember->id],
                                                                 ['post_id', $singlePost->id]
                                                              ]);
                    $memberPostRecord->group_id =$singleGroup->id;
                    $memberPostRecord->member_id =$singleMember->id;
                    $memberPostRecord->post_id =$singlePost->id;
                    $timestamp = $singleMember->created_at->timestamp + $daysBeforePosting * 86400;

                    $memberPostRecord->timestamp = $timestamp;
                    
                    $memberPostRecord->save();

                }
                    

            }
        }

    }
}
