<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Address;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    // Get all addresses for the authenticated customer
    public function index(Request $request)
    {
        $addresses = Address::where('customer_id', $request->user()->id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Addresses retrieved successfully',
            'data' => $addresses
        ], 200);
    }

    // Add a new address
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:shipping,billing',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address_line' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['customer_id'] = $request->user()->id;

        $address = Address::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Address added successfully',
            'data' => $address
        ], 201);
    }

    // Update an existing address
    public function update(Request $request, $id)
    {
        $address = Address::where('id', $id)->where('customer_id', $request->user()->id)->first();

        if (!$address) {
            return response()->json([
                'status' => false,
                'message' => 'Address not found or unauthorized'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'sometimes|required|in:shipping,billing',
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'phone' => 'sometimes|required|string|max:20',
            'address_line' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:255',
            'state' => 'sometimes|required|string|max:255',
            'zip_code' => 'sometimes|required|string|max:20',
            'country' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $address->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Address updated successfully',
            'data' => $address
        ], 200);
    }

    // Delete an address
    public function destroy(Request $request, $id)
    {
        $address = Address::where('id', $id)->where('customer_id', $request->user()->id)->first();

        if (!$address) {
            return response()->json([
                'status' => false,
                'message' => 'Address not found or unauthorized'
            ], 404);
        }

        $address->delete();

        return response()->json([
            'status' => true,
            'message' => 'Address deleted successfully'
        ], 200);
    }
}
