@extends('template.base')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mt-5">
                <h5 class="h5 text-center">Controle de Vendas</h5>
                <div class="text-center">
                    <a href="{{ route('sales.create') }}" class="btn btn-warning text-center mt-3 mb-1">Nova Venda</a>
                </div>
            </div>

            @if (session('success'))
                <div class="row mt-2 mb-2">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="row mt-2 mb-2">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="row mt-3 mx-5">
                <table class="table table-dark table-striped-columns">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Data de Cadastro</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (!is_null($sales))
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->id }}</td>
                                    <td>{{ $sale->customer->name }}</td>
                                    <td>{{ $sale->value }}</td>
                                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('sales.destroy', ['saleId' => $sale->id]) }}"
                                            class="btn btn-danger">
                                            Deletar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
