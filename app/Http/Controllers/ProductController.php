<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "price" => "required",
            "description" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["success" => "failed", "message" => $validator->errors()], 400);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->user_id = auth("")->user()->id;

        if ($product->save()) {
            return response()->json(["success" => "success", "data" => $product, "message" => "Product created successfully"], 200);
        }

        return response()->json(["success" => "failed", "message" => "Failed to create product"], 500);
    }


    function all()
    {
        $products = Product::where("user_id", auth("")->user()->id)->get();
        return response()->json(["success" => "success", "" => $products], 200);
    }

    function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "price" => "required",
            "description" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["success" => "failed", "message" => $validator->errors()], 400);
        }

        $product = Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        if ($product->save()) {
            return response()->json(["success" => "success", "data" => $product, "message" => "Product updated successfully"], 200);
        }

        return response()->json(["success" => "failed", "message" => "Failed to update product"], 500);

    }

    function delete($id)
    {
        if (Product::where("id", $id)->where("user_id", auth()->user()->id)->delete()) {
            return response()->json(["success" => "success", "message" => "product deleted successfully"], 200);
        }

        return response()->json(["success" => "failed", "message" => "failed to delete product"], 500);
    }
}
