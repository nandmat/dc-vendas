<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateCustomerRequest;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{

    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function index()
    {
        $customers = Customer::all();

        return view('customer.index', compact('customers'));
    }

    public function store(StoreUpdateCustomerRequest $request)
    {
        try {
            $this->customer->create($request->all());

            return redirect()
                ->back()
                ->with('success', 'Cliente cadastrado com sucesso!');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->withErrors('Não foi possível cadastrar o cliente.');
        }
    }
}
