<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Seller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{


    public function index()
    {
        $sales = Sale::all();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::where('status', 1)
            ->get();

        $products = Product::all();

        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate(
                [
                    'customer_id' => 'required',
                    'paymentMethod' => 'required',
                    'part' => 'required',
                    'final_amount' => 'required'
                ],
                [
                    'customer_id.required' => 'Cliente é obrigatório!',
                    'paymentMethod.required' => 'Método de pagamento é obrigatório!',
                    'part.required' => 'Parcelas é obrigatório!',
                    'final_amount.required' => 'Valor total é obrigatório'
                ]
            );

            $seller = Seller::where('user_id', auth()->user()->id)
                ->first();

            Sale::create([
                'seller_id' => $seller->id,
                'customer_id' => $data['customer_id'],
                'value' => floatval($data['final_amount']),
                'parts' => !is_null($data['part'])
                    ? json_encode($data['part'])
                    : null
            ]);

            return redirect()
                ->route('sales.index')
                ->with('success', 'Venda salva com sucesso!');
        } catch (Exception $e) {
            return back()
                ->withErrors("Não foi possível salvar a venda!");
        }
    }

    public function destroy($saleId)
    {
        try {
            $sale = Sale::find($saleId);

            $sale->delete();

            return back()
                ->with('success', 'Venda deletada com sucesso!');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->withErrors("Não foi possível deletar a venda!");
        }
    }
}
