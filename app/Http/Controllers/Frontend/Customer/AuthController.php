<?php

namespace App\Http\Controllers\Frontend\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Customer\CustomerLoginRequest;
use App\Http\Requests\Frontend\Customer\CustomerRegisterRequest;
use App\Services\Frontend\Customer\CustomerAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    protected CustomerAuthService $customerAuthService;

    public function __construct(CustomerAuthService $customerAuthService)
    {
        $this->customerAuthService = $customerAuthService;
    }

    public function showLogin(): View
    {
        return view('frontend.customer.auth.login');
    }

    public function login(CustomerLoginRequest $request): RedirectResponse
    {
        $this->customerAuthService->login($request->validated());

        return redirect()->intended(route('customer.account'));
    }

    public function showRegister(): View
    {
        return view('frontend.customer.auth.register');
    }

    public function register(CustomerRegisterRequest $request): RedirectResponse
    {
        $this->customerAuthService->register($request->validated());

        return redirect()->route('customer.account');
    }

    public function logout(): RedirectResponse
    {
        $this->customerAuthService->logout();

        return redirect()->route('customer.login');
    }
}