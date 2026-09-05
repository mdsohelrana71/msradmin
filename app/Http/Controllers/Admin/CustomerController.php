<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(
        protected CustomerService $customerService
    ) {}

    public function index(Request $request)
    {
        $customers = $this->customerService->getCustomers(
            $request->input('search'),
            $request->input('sort')
        );

        if ($request->ajax()) {
            $html = view(
                'admin.Customers.partials.table',
                compact('customers')
            )->render();

            return response()->json([
                'html' => $html,
            ]);
        }

        return view(
            'admin.Customers.index',
            compact('customers')
        );
    }

    public function show(User $customer)
    {
        $customer = $this->customerService->getCustomer(
            $customer
        );

        return view(
            'admin.Customers.show',
            compact('customer')
        );
    }

    public function update(Request $request, User $customer)
    {
        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        $this->customerService->updateStatus(
            $customer,
            $validated['is_active']
        );

        return redirect()
            ->route('admin.customers.show', $customer)
            ->with(
                'success',
                'Customer status updated successfully.'
            );
    }
}