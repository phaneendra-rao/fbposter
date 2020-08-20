<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use DB;
use Validator;
class AuthController extends Controller
{

    private $successStatus = ['api_status' =>1 ,'code' => 200,];
    private $wrongHTTP = ['response'=>[
                                        'api_status'=>0,
                                        'code'=>400,
                                        'message'=>'Your HTTP method is not correct.'
                                        ]
                                ];

    public function signup(Request $request)
    {
        //$method = $request->method();
        if($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'email' => 'required|email',
                        'password' => 'required',
                        ]);
            if ($validator->fails()) {
                return response()->json(['response'=>[
                                                'code'=>400,
                                                'api_status'=>0,
                                                'message'=>'Data is not in the proper format.',
                                                    ]
                                        ]);
                }
            $email = $request->email;
            $eid =User::where('email' , $email)->exists();
            if($eid == true)
            {
                return response()->json(['response'=>[
                                                'api_status' => 0 ,
                                                'code' => 200,
                                                'message'=> 'This email already exist.'
                                                ]
                                    ],200);
            }
            else
            {
                if($request->usertype != '')
                {
                    $user = new User();

                    $input = $request->all();
                    $input['password'] = bcrypt($input['password']);

                    if($request->usertype == 'A'){
                        $input['api_token'] = $user->createToken('Personal access token',['manage_groups'])->accessToken;
                    }else{
                        $input['api_token'] = $user->createToken('Personal access token',['manage_messages'])->accessToken;
                    }

                    if($request->usertype == 'Member Manager')
                    {
                        $input['type'] = 1;
                    }
                    else if($request->usertype == 'Commenter')
                    {
                        $input['type'] = 2;
                    }
                    // $name =  $user->name;
                    // $email = $user->email;

                    // $user = User::create($input);
                    $user->fill($input);
                    $saved=$user->save();
                    return response()->json(['response' => [
                                                    'api_status'=>1,
                                                    'code'=>201,
                                                    'message' => 'Successfully registered.',
                                                    ]
                                            ],201);
                }
                else{
                    $user = new User();
                    $input = $request->all();
                    $input['password'] = bcrypt($input['password']);

                    // $token = $user->createToken('Personal access token')->accessToken;
                    // $name =  $user->name;
                    // $email = $user->email;
                    $user = new User();
                    $input['api_token'] = $user->createToken('Personal access token')->accessToken;
                    // $user = User::create($input);
                     $user->fill($input);
                    $saved=$user->save();
                    return response()->json(['response' => [
                                                    'api_status'=>1,
                                                    'code'=>201,
                                                    'message' => 'Successfully registered.',
                                                    ]
                                            ],201);
                }
            }
        }
            return response()->json($this -> wrongHTTP, 400);
    }

    public function login(Request $request)
    {
        if($request->isMethod('post'))
        {
            if(Auth::attempt(['email' => request('email'), 'password' => request('password')]))
            {
                $user = Auth::user();
                $name = $user->name;

                if($user->type == 0)
                {
                    $api_token =  $user->createToken('Personal Access Token')->accessToken;
                }
                else if($user->type == 1)
                {
                    $api_token =  $user->createToken('Personal Access Token',['manage_groups'])->accessToken;
                }
                else if($user->type == 2)
                {
                    $api_token =  $user->createToken('Personal Access Token',['manage_messages'])->accessToken;
                }

                $user->api_token = $api_token;
                $user->save();
                return response()->json(['response'=>[
                                                'type'=>$user->type,
                                                'api_status'=>1,
                                                'code'=>200,
                                                'message'=>'Logged in Successfully.',
                                                'access_token'=>$api_token
                                                ]
                                     ],200);
            }
            else
            {
                return response()->json(['response'=>
                                            [
                                            'api_status'=>0,
                                            'code'=>200,
                                            'message'=>'Data is not in the proper format or check your email and password.'
                                            ]
                                    ],200);
            }
        }
            return response()->json($this -> wrongHTTP, 400);
    }
}
