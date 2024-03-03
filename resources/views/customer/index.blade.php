@extends('template.base')

@section('content')
    <div class="card">
        <div class="card-body">

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
            <div class="row">
                <h4 class="h4 text-center">Clientes</h4>
                <div class="text-center">
                    <button class="btn btn-info text-center" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">Cadastro</button>
                </div>
            </div>

            <div class="row mt-3 mx-5">
                <table class="table table-dark table-striped-columns">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th class="text-center" scope="col">Tipo</th>
                            <th scope="col">CPF/CNPJ</th>
                            <th scope="col">Email</th>
                            <th class="text-center" scope="col">Status</th>
                            <th scope="col">Data de Cadastro</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (!is_null($customers))
                            @foreach ($customers as $customer)
                                <tr>
                                    <th scope="row">{{ $customer->id }}</th>
                                    <td>{{ $customer->name }}</td>
                                    <td class="text-center">{{ $customer->person_type == 'legal' ? 'Jurídica' : 'Física' }}
                                    </td>
                                    <td>{{ $customer->cpf_cnpj }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td class="text-center">
                                        @if ($customer->status == 1)
                                            <span class="badge text-bg-success">Ativo</span>
                                        @else
                                            <span class="badge text-bg-danger">Inativo</span>
                                        @endif
                                    </td>
                                    <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastro de Clientes</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="row-mt-1">
                            <div class="col-md-12 mt-1">
                                <div class="form-group">
                                    <label for="">Nome:</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12 mt-1">
                                <div class="form-group">
                                    <label for="">Tipo:</label>
                                    <select name="person_type" class="form-select" aria-label="Default select example">
                                        <option selected></option>
                                        <option value="legal">Jurídica</option>
                                        <option value="physical">Física</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mt-1">
                                <div class="form-group">
                                    <label for="">CPF/CNPJ:</label>
                                    <input type="text" name="cpf_cnpj" id="inputCpfCnpj" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12 mt-1">
                                <div class="form-group">
                                    <label for="">Email:</label>
                                    <input type="text" name="email" class="form-control">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
