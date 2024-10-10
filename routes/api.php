<?php

use App\Http\Controllers\ProductController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post("users/register", function (Request $request) {
    $user = new User();
    $user->name = $request->input("name");
    $user->email = $request->input("email");
    $user->password = Hash::make($request->input("password"));
    if ($user->save()) {
        $token = $user->createToken("auth")->plainTextToken;
        return response()->json(["success" => "success", "data" => $user, "token" => $token, "message" => "User created successfully"], 200);
    }

    return response()->json(["error" => "error", "message" => "User not created"], 400);


});

Route::prefix("product")->middleware("auth:sanctum")->group(function () {
    Route::post("create", [ProductController::class, 'create']);
    Route::get("all", [ProductController::class, "all"]);
    Route::put("update/{id}", [ProductController::class, "update"]);
    Route::delete("delete/{id}", [ProductController::class, "delete"]);
});
