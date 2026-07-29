<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserDataController extends Controller
{
    // Get user data by user_id
    public function show($userId)
    {
        $userData = UserData::where('user_id', $userId)->first();
        
        if (!$userData) {
            return response()->json([
                'status' => 'error',
                'message' => 'User data not found'
            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $userData
        ]);
    }
    
    // Create or update user data
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'phone_code' => 'required|string|max:4',
            'phone_number' => 'required|integer',
            'country' => 'required|string|max:50',
            'province' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'address' => 'required|string|max:255'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $userData = UserData::updateOrCreate(
            ['user_id' => $request->user_id],
            $request->only(['name', 'phone_code', 'phone_number', 'country', 'province', 'city', 'address'])
        );
        
        return response()->json([
            'status' => 'success',
            'message' => 'User data saved successfully',
            'data' => $userData
        ], 201);
    }
    
    // Update user data
    public function update(Request $request, $userId)
    {
        $userData = UserData::where('user_id', $userId)->first();
        
        if (!$userData) {
            return response()->json([
                'status' => 'error',
                'message' => 'User data not found'
            ], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'phone_code' => 'sometimes|string|max:4',
            'phone_number' => 'sometimes|integer',
            'country' => 'sometimes|string|max:50',
            'province' => 'sometimes|string|max:50',
            'city' => 'sometimes|string|max:50',
            'address' => 'sometimes|string|max:255'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $userData->update($request->all());
        
        return response()->json([
            'status' => 'success',
            'message' => 'User data updated successfully',
            'data' => $userData
        ]);
    }
    
    // Delete user data
    public function destroy($userId)
    {
        $userData = UserData::where('user_id', $userId)->first();
        
        if (!$userData) {
            return response()->json([
                'status' => 'error',
                'message' => 'User data not found'
            ], 404);
        }
        
        $userData->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'User data deleted successfully'
        ]);
    }
}