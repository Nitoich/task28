<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\Car\CreateCarRequest;
use App\Http\Requests\api\v1\Car\UpdateCarRequest;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
        $cars = Car::query()->where('user_id', $user->id)->get();
        return response()->json([
            'data' => $cars
        ])->setStatusCode(200);
    }

    public function show(Car $car): JsonResponse
    {
        return response()->json([
            'data' => $car
        ])->setStatusCode(200);
    }

    public function update(Car $car, UpdateCarRequest $request): JsonResponse
    {
        return response()->json([
            'car' => $car->update($request->validated())
        ])->setStatusCode(200);
    }

    public function store(CreateCarRequest $request): JsonResponse
    {
        $car = Car::query()->create(array_merge($request->validated(), [
            'user_id' => Auth::user()->id
        ]));
        return response()->json([
            'data' => $car
        ])->setStatusCode(201);
    }

    public function destroy(Car $car): JsonResponse
    {
        $car->delete();
        return response()->json([
            'data' => $car
        ])->setStatusCode(200);
    }
}
