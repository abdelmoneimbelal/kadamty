<?php

namespace App\Http\Controllers\api;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Governorate;
use App\City;
use App\Category;
use App\Service;
use App\Comment;


class MainController extends Controller
{
    /*public function articles()
    {

        $articles = Article::with('Category')->paginate(10);

        return responseJson(1,'success',$articles);

    }*/

    public function governrates()
    {

        $governrates = Governorate::all();

        return responseJson(1, 'success', $governrates);

    }


    public function cities(Request $request)
    {

        $cities = City::where(function ($query) use ($request) {
            if ($request->has('governrate_id')) {

                $query->where('governrate_id', $request->governrate_id);
            }
        })->get();
        return responseJson(1, 'success', $cities);

    }

    public function categories()
    {
        $categories = Category::all();

        return responseJson(1, 'success', $categories);
    }

    public function service(Request $request)
    {

        $service = Service::where(function ($query) use ($request) {
            if ($request->has('category_id')) {

                $query->where('category_id', $request->category_id);
            }
        })->get();
        return responseJson(1, 'success', $service);

    }

    public function comments(Request $request)
    {

        $comment = Comment::where(function ($query) use ($request) {
            if ($request->has('service_id')) {

                $query->where('service_id', $request->service_id);
            }
        })->get();
        return responseJson(1, 'success', $comment);

    }

    public function addComment(Request $request)
    {

        $validator = validator()->make($request->all(), [

            'comment' => 'required',
            'rating' => 'required',
            //'client_id' => 'required',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), null);
        } else {
            $comment = Comment::create([
                'comment' => $request->comment,
                'rating' => $request->rating,
                'service_id' => $request->service_id,
                'user' => auth()->user()->name,
            ]);
        }

        return responseJson(1, 'تم اضافة تعليقك', compact('comment'));
    }

    public function addOrder(Request $request)
    {

        $validator = [
            'service_id' => 'required',
        ];
        $validator = validator()->make($request->all(), $validator);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), null);
        } else {

            $order = Order::create([
                'service_id' => $request->service_id,
                'client_id' => auth()->user()->id,
            ]);
        }
        return responseJson(1, 'Success', $order);
    }

    public function myOrder(Request $request)
    {
        $orders = Order::where(function ($query) use ($request) {
            if ($request->has('client_id')) {
                $query->where('client_id', $request->client_id);
            }
        })->latest()->get();
        return responseJson(1, 'success', $orders);
    }

    public function showOrder(Request $request)
    {
        $order = Order::all();

        return responseJson(1, 'success', $order);

    }

}



