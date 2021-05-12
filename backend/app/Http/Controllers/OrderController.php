<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
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
    public function store(OrderRequest $request)
    {
        DB::beginTransaction();
        $errors = array();
        foreach ($request->products as $product) {
            $data =  Product::find($product["id"]);
            if($product["quantity"] > $data->stock){
                array_push($errors, true);
                break;
            }else{
                $totalPrice = $product["quantity"] * $data->price; 
                array_push($errors, false);
                $data->stock = $data->stock - $product["quantity"];
                if ($data->stock == 0) {
                    $data->status = false;
                }
                $data->save();
                $order = new Order();
                $order->product_id = $product["id"];
                $order->total_sale_price = $totalPrice;
                $order->name = Str::title($request->name);
                $order->quantity = $product["quantity"];
                $order->address = Str::title($request->address);
                $order->country = Str::title($request->country);
                $order->state = Str::title($request->state);
                $order->email = $request->email;
                $order->ccn = Hash::make($request->ccn);
                $order->ccd= Hash::make($request->ccd);
                $order->ccv = Hash::make($request->ccv);
                $order->save();
            }
        }
        if(array_search(true, $errors) === false){
            DB::commit();
            return response()->json([
                "message" => $request->email
            ], 200);
        }else{
            DB::rollback();
            return response()->json([
                "message" => "No stock"
            ], 503);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($email)
    {
        $orders = Order::where("email" , $email)->get();
        return response()->json([
            "orders" => $orders,
            "message" => "Orders"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function findByEmail(Request $request)
    {
        $orders = Order::where("email" , $request->email)->with("product")->get();
        return response()->json([
            "orders" => $orders,
            "message" => "Orders"
        ]);
    }
}
