<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Client;
use App\City;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = validator()->make($request->all(), [

            'name' => 'required',
            'city_id' => 'required',
            'phone' => 'required',
            'password' => 'required|confirmed',
            'email' => 'required|unique:clients',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), null);
        }

        $request->merge(['password' => bcrypt($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = str::random(60);
        $client->save();
//        $client->$request->city_id;

        return responseJson(1, 'تم الاضافة بنجاح', [
            'api_token' => $client->api_token,
            'client' => $client]);
    }

    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'phone' => 'required',
            'password' => 'required',

        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), null);
        }

        //$auth = auth()->guard('api')->validator($request->all());
        $client = client::where('phone', $request->phone)->first();
        if ($client) {
            if (Hash::check($request->password, $client->password)) {
                return responseJson(1, 'تم نسجيل الدخول', [
                    'api_token' => $client->api_token,
                    'client' => $client
                ]);
            } else {
                return responseJson(0, 'بيانات الدخول غير صحيحة');
            }
        } else {
            return responseJson(0, 'بيانات الدخول غير صحيحة');
        }

    }

    public function profile(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'password' => 'confirmed',
            'email' => Rule::unique('clients')->ignore($request->user()->id),
            'phone' => Rule::unique('clients')->ignore($request->user()->id),
        ]);
        if ($validation->fails()) {
            $data =  null;
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $loginUser = $request->user();
        $loginUser->update($request->all());

        if ($request->has('password')) {
            $loginUser->password = bcrypt($request->password);
        }

        $loginUser->save();

//        if ($request->has('governrate_id')) {
//            $loginUser->governrates()->detach($request->governrate_id);
//            $loginUser->governrates()->attach($request->governrate_id);
//        }


        $data = [
            'user' => $request->user()->fresh()
        ];

        return responseJson(1, 'تم تحديث البيانات', $data);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            $data = null;
            return responseJson(0, $validator->errors()->first(), $data);
        }
        $user = Client::where('email', $request->email)->first();
        if ($user) {
            $code = rand(1111, 9999);
            $update = $user->update(['pin_code' => $code]);

            if ($update) {
                Mail::to($user->email)->send(new ResetPassword($user));

                return responseJson(1, 'برجاء فحص بريدك الالكترونى',
                    [
                        'pen_code_for_test' => $code,
                    ]);
            } else {
                return responseJson(0, 'حاول مره اخري');
            }
        } else {
            return responseJson(0, 'حاول مره اخرى');
        }
    }

    public function password(Request $request)
    {
        $validator = validator::make($request->all(), [

            'pin_code' => 'required',
            'password' => 'required|confirmed'
        ]);
        if ($validator->fails()) {
            $data = null;
            return responseJson(0, $validator->errors()->first(), $data);

        }

        $user = Client::where('pin_code', $request->pin_code)->where('pin_code', '!=', 0)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->pin_code = null;
            if ($user->save()) {
                return responseJson(1, 'تم تغيير كلمه المرور بنجاح');
            } else {
                return responseJson(0, 'حدث خطا مره اخري');
            }
        } else {
            return responseJson(0, 'هذا الكود غير صالح');

        }
    }

}
