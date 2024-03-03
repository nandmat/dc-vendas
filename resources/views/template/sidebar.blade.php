<div class="bg-white" id="sidebar-wrapper">
    <div class="sidebar-heading text-center py-4 black-text fs-4 fw-bold text-uppercase border-bottom">
        Vendas</div>
    <div class="list-group list-group-flush my-3">
        <a href="#" class="list-group-item list-group-item-action bg-transparent second-text active">
            Dashboard
        </a>
        <a href="#" class="list-group-item list-group-item-action bg-transparent second-text active">
            Cadastrar Venda
        </a>
        <a href="{{ route('customers.index') }}" class="list-group-item list-group-item-action bg-transparent second-text active">
            Cadastrar Cliente
        </a>
        <a href="{{ route('logout') }}"
            class="list-group-item list-group-item-action bg-transparent text-danger fw-bold">
            <i class="fas fa-power-off me-2"></i>
            Logout
        </a>
    </div>
</div>
