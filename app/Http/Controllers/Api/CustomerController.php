<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(15);

        $customers->getCollection()->transform(function ($customer) {
            return $this->withProfileUrl($customer);
        });

        return response()->json($customers);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:customers,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:customers,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms_and_conditions' => ['accepted'],
            'status' => ['sometimes', 'boolean'],
            'referral_code' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'profile_image' => ['nullable'],
            'dob' => ['nullable', 'date'],
        ]);

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'customer';
        $data['status'] = $data['status'] ?? true;

        $customer = Customer::create($data);

        return response()->json($customer, 201);
    }

    public function show(Customer $customer)
    {
        return response()->json($this->withProfileUrl($customer));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', Rule::unique('customers', 'email')->ignore($customer->id)],
            'phone' => ['sometimes', 'string', 'max:20', Rule::unique('customers', 'phone')->ignore($customer->id)],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
            'terms_and_conditions' => ['sometimes', 'boolean'],
            'status' => ['sometimes', 'boolean'],
            'referral_code' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'profile_image' => ['nullable'],
            'dob' => ['nullable', 'date'],
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if ($request->hasFile('profile_image')) {
            if ($customer->profile_image && Storage::disk('public')->exists($customer->profile_image)) {
                Storage::disk('public')->delete($customer->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        $customer->fill($data);
        $customer->save();

        return response()->json($this->withProfileUrl($customer));
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully.']);
    }

    public function updateStatus(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'status' => ['required', 'boolean'],
        ]);

        $customer->status = $data['status'];
        $customer->save();

        $label = $customer->status ? 'unblocked' : 'blocked';

        return response()->json([
            'message' => "Customer {$label} successfully.",
            'customer' => $this->withProfileUrl($customer),
        ]);
    }

    private function withProfileUrl(Customer $customer): Customer
    {
        if ($customer->profile_image) {
            $customer->setAttribute(
                'profile_image',
                Storage::disk('public')->url($customer->getRawOriginal('profile_image'))
            );
        }

        return $customer;
    }
}
