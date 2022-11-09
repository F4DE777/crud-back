<?php

namespace App\Http\Controllers;

use App\Permission;
use App\User;
use App\UserRolePivot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
//    public function  index(){
//        return  response()->json(User::all());
//    }

//    public function __construct()
//    {
//        $this->middleware('auth:api', ['except' => ['login']]);
//    }
    public function me() {
        return response()->json(auth('api')->user());
    }

    public function  login(){
        $data = request()->all();

        if (!$token = auth()->attempt($data)) {
            return response() -> json([
                'status' => 'error'
            ], 401);
        }
    else{

        $email = $data['email'];
        $password = $data['password'];
        $user = User::with(['rolePivot'])->where(['email'=>$email])->first();
        if(!is_null($user)){
            $piv = collect($user)->toArray();
            $piv = $piv['role_pivot']['role_id'];
            $permissions = Permission::where(['role_id'=>$piv])->get();
            if(Hash::check($password, $user->password)){
                return response()->json([
                    'success'=>'Success',
                    'user'=>$user,
                    'permissions'=>$permissions,
                    'token'=>$token

                ]);
            }else{
                return response()->json([
                    'error'=>'incorrect password',
                ]);
            }
        }else{
            return response()->json([
                'error'=>'User not found',
            ]);
        }
    }





//            $data = request(['email', 'password']);
//            dd($data);
//            if (! $token = auth()->attempt($data)) {
//                return response()->json(['error' => 'Unauthorized'], 401);
//            }
//
//            return $this->respondWithToken($token);


        // return response()->json([
        //     'userData' => $data;
        // ])
        // return  'hello';-
    }

    protected function respondWithToken($token)  {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function getUserData(){
        $data = request()->all();
        $id = $data['user_id'];

        $user = User::with(['rolePivot'])->findOrFail($id);
        $users = User::with(['rolePivot'])
            ->where('email','!=','super-admin@yahoo.com')
            ->paginate(5);

        $piv = collect($user)->toArray();
        if (isset($piv['role_pivot']))
            $piv = $piv['role_pivot']['role_id'];
        else
            $piv = 0;
        $permissions = Permission::where(['role_id'=>$piv])->get();

        return json_encode([
            'success'=>'Success',
            'user'=>$user,
            'users'=>$users,
            'permissions'=>$permissions,
        ]);

    }



    public function getAllUsers(Request $request, User $product)
    {
        //You can use anyway to filter the results! Am Just using this way for Demo!!

        $productQuery = $product->newQuery();
        $productQuery->with('rolePivot');
        $productQuery->where('email','!=','super-admin@yahoo.com');

        $products = !empty( $request->input('searchText') ) ? $productQuery->where('first_name', $request->input('searchText'))
            ->orWhere('last_name', $request->input('searchText')) : $productQuery;

        $products = !empty( $request->input('limit') ) ? $products->paginate( $request->input('limit') ) : $products->paginate(5);

        if( $request->wantsJson() )
        {
            return response()->json( $products );
        }

        return response()->json( $products );
    }

    public function signUp(){
//        dd('anything');
        $data = request()->all();
        $data = $data['data'];
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $email = $data['email'];
        $password = $data['password'];
        $role = $data['role'];
        $roleData = \App\Role::where(['name'=>$role])->first();
        $user = User::where(['email'=>$email])->first();

        if(!is_null($user)){
            return "email already taken";
        };

       $new_user = User::create([
            'first_name' => $first_name,
            'last_name' =>  $last_name ,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        if($new_user){
            UserRolePivot::create([
                'role_id'=>$roleData->id,
                'user_id'=>$new_user->id,
                'role_name'=>$roleData->description,
            ]);

            $permission = [
                [
                    'role_id'=>$roleData->id,
                    'name' => 'view_user',
                    'description' => 'Can view user'

                ],
                [
                    'role_id'=>$roleData->id,
                    'name' => 'view_permission',
                    'description' => 'Can view permission'

                ],
            ];
            \App\Permission::insert($permission);
            return json_encode([
                'success'=>'Success',
                'user'=>$new_user,
            ]);
        }else{
            return json_encode([
                'error'=>'an error occured',
            ]);
        }


    }

    public function edit(){
        $data = request()->all();
        $data = $data['data'];
        $id = $data['id'];
        $update = [
            'first_name' => $data['first_name'],
            'last_name' =>  $data['last_name'],
            'email' => $data['email'],
            'role' => $data['role'],
        ];
        $user = User::findOrFail($id);

        if (!is_null($user)){
            $user->update($update);
        }

        return response()->json([
            'success'=>true,
            'user'=>$user
        ], 200);
    }

    public  function  delete(){
        $data = request()->all();
        $id = $data['id'];
        $user = User::findOrFail($id);
        if (!is_null($user)){
            $user->delete();
        }

        return response()->json([
            'success'=>true,
            'user'=>$user
        ], 200);

    }

//    public function check()
//    {
//        dd('hshjfjjf');
//    }
//};


public function getAll (){
    return response()->json([
        'success'=>true,
    ], 200);
}}
