@extends('template.base')

@section('content')
    <form action="{{ route('sales.store') }}" method="post">
        @csrf
        <div class="card">
            <div class="row mt-5">
                <h5 class="h5 text-center">Nova Venda</h5>
            </div>

            <div class="row mx-5 mb-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Cliente:</label>
                        <select name="customer_id" id="selectCustomer" class="form-select">
                            <option selected value=""></option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }} | {{ $customer->cpf_cnpj }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mx-5 mb-2">
                <div class="col-md-3" id="products">
                    <div class="form-group">
                        <label for="">Produto:</label>
                        <select id="product-id" onchange="onDivProducts()" class="form-select">
                            <option selected value=""></option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} |
                                    R$ {{ number_format($product->price, 2, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2" id="products">
                    <div class="form-group">
                        <label for="">Valor Unitário:</label>
                        <input type="text" oninput="validateInputsNumber(this)" class="form-control" id="inputUnitaryValue">
                    </div>
                </div>

                <div id="products" class="col-md-2">
                    <div class="form-group">
                        <label for="">Quantidade:</label>
                        <input type="number" class="form-control" id="inputQuantity">
                    </div>
                </div>


                <div class="col-md-2" id="products">
                    <div class="form-group">
                        <label for="">Total:</label>
                        <input type="text" oninput="validateInputsNumber(this)" class="form-control" id="inputAmount">
                    </div>
                </div>

                <div class="col-md-3" id="products">
                    <div class="form-group">
                        <div class="mt-4">
                            <button type="button" id="add-products" class="btn btn-warning">Adicionar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mx-5 mb-2">
                <h6 class="h6 mt-3" id="products">Produtos Selecionados</h6>
                <div class="col-md-12" id="products">
                    <ul class="list-group text-center" id="products-list">

                    </ul>
                </div>

                <div class="col-md-12 " id="products">
                    <hr class="hr mt-1 mb-1" id="products">
                    <h6 class=" mt-3" id="products">Total</h6>
                    <div class="col-md-2">
                        <input step="any" type="text" name="final_amount" value="" class="form-control inputFinalAmount">
                        <select name="paymentMethod" id="payment-method" class="form-select mt-3">
                            <option value=""></option>
                            <option value="part">Parcelado</option>
                        </select>
                        <input min="1" value="1" max="12" style="display: none;" type="number"
                            class="mt-3 form-control parts-quantity">
                        <button type="button" class="btn btn-primary mt-3 mb-1 btn-parts">Gerar Parcelas</button>
                    </div>
                </div>

                <div class="col-md-12" id="products">
                    <div class="col-md-4">
                        <ul class="list-group parts-list">

                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-2" id="products">
                <button type="submit" id="submit-sale" class="btn btn-success mx-2 my-2">Salvar Venda</button>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{ asset('script/sale.js') }}?v3"></script>
@endsection
