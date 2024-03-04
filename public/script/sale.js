/** Todas as variáveis e constantes que são necessárias para o funcionamento do código*/
const products = document.querySelectorAll('#products');
const selectCustomer = document.querySelector('#selectCustomer');
const buttonAddProducts = document.querySelector('#add-products');
const productsList = document.querySelector('#products-list');
const productId = document.querySelector('#product-id');
const btnParts = document.querySelector('.btn-parts');
const paymentMethod = document.querySelector('#payment-method');
const partsQuantity = document.querySelector('.parts-quantity');
const partsList = document.querySelector('.parts-list');

let finalAmount = document.querySelector('.inputFinalAmount');
let unitaryValue = document.querySelector('#inputUnitaryValue');
let quantity = document.querySelector('#inputQuantity');
let amount = document.querySelector('#inputAmount');
let productsArray = [];

products.forEach(function (product) {
    product.style.display = 'none';
});


/** a partir deste ponto começa a logica de manipulação da venda */


//Controle de visibilidade das divs com id products
function onDivProducts() {
    if (selectCustomer.value !== "") {
        products.forEach(function (product) {
            product.style.display = 'inline';
        });
    } else {
        products.forEach(function (product) {
            product.style.display = 'none';
        });
    }
}

selectCustomer.addEventListener('change', function () {
    onDivProducts();
});

//Controle de adição de produtos
function addProducts() {
    //Esse array armazena os retornos de erros: campos em branco na adição de produtos
    let arrayError = [];

    validation(productId.value, 'Produto', arrayError);
    validation(quantity.value, 'Quantidade', arrayError);
    validation(unitaryValue.value, 'Valor Unitário', arrayError);
    validation(amount.value, 'Total', arrayError);

    //Se o tamanho do arrayError for maior que 0, monta uma string com os valores armazenados no mesmo
    //e joga um alert na tela do usuário.
    if (arrayError.length > 0) {
        let string = '';
        arrayError.forEach((error) => {
            string = string + error + '\n';
        });
        alert(string);
        return;
    }

    let verifiyProduct = document.querySelector(`.li-product-${productId.value}`)
        ? true
        : false;

    if (verifiyProduct) {
        alert("Produto já adicionado!");
        return;
    }
    //Parte responsável da manipulação do DOM para criação de um novo elemento li e seus filhos
    let li = document.createElement('li');
    li.classList.add('list-group-item', `li-product-${productId.value}`);

    let paragraphProduct = document.createElement('p');
    paragraphProduct.classList.add('col-md-3', 'mb-1');
    //essa variavel serve para nomear classes no decorrer do código
    let idName = '';

    let h6 = document.createElement('h6');
    h6.classList.add('h6', 'mb-1', 'text-center');

    productsArray.forEach((product) => {
        if (product.id == parseInt(productId.value)) {
            h6.innerHTML = `${product.name} | Unidade: R$ ${product.price}`;
            idName = product.id;
        }
    });
    let inputQuantity = document.createElement('input');
    inputQuantity.classList.add('form-control', 'mx-1', 'my-1', `input-quantity-${idName}`);
    inputQuantity.type = 'number';
    inputQuantity.value = quantity.value;
    inputQuantity.min = 1;


    let inputProduct = document.createElement('input');
    inputProduct.classList.add('form-control', 'mx-1', 'my-1', `input-product-${idName}`);
    inputProduct.type = 'number';
    inputProduct.value = amount.value;

    paragraphProduct.appendChild(h6);
    paragraphProduct.appendChild(inputQuantity);
    paragraphProduct.appendChild(inputProduct);
    li.appendChild(paragraphProduct);

    productsList.appendChild(li);

    //toda vez que adicionar um novo produto nos proudtos selecionando vai atualizar o valor final
    //da venda;
    if (parseFloat(finalAmount.value) > 0) {
        finalAmount.value = (parseFloat(finalAmount.value) + parseFloat(amount.value)).replace(/,/g, '.');;

    } else {
        finalAmount.value = parseFloat(amount.value).toFixed(2).replace(/,/g, '.');;
    }

    inputProduct.id = `value-product-${productId.value}`;

    //esse evento permite que seja manipulado o valor final e valor do produto selecionado referente
    //a quantidade desejada. Assim dá para mudar a quantidade e
    inputQuantity.addEventListener('input', function (event) {
        let value = parseInt(event.target.value);

        let productInput = document.querySelector(`.input-product-${idName}`);
        let oldValue = productInput.value;
        let id = parseInt(productInput.id.match(/\d+/)[0]);

        productsArray.forEach((product) => {
            if (product.id == id) {
                productInput.value = parseFloat(product.price * value).toFixed(2).replace(/,/g, '.');;

                finalAmount.value = parseFloat(
                    (parseFloat(finalAmount.value) - parseFloat(oldValue))
                    + parseFloat(productInput.value)).toFixed(2).replace(/,/g, '.');;
            }
        });

        let verifiyPart = document.querySelector('#part-value-1')
            ? true
            : false;

        if (verifiyPart) {
            generateParts();
        }

    });
}
buttonAddProducts.addEventListener('click', function () {
    addProducts();

    let verifiyPart = document.querySelector('#part-value-1')
        ? true
        : false;

    if (verifiyPart) {
        generateParts();
    }
});


//Valida na hora de inserir um produto na ul de produtos selecionados
function validation(element, elementType, arrayError) {
    if (element !== "") {
        return true;
    }

    arrayError.push(`O campo ${elementType} é obrigatório!`);
    return;
}

//Essa função é responsável por realizar a consulta a api de produtos para recuprar informações do produto
function getProductById(id) {
    let url = `http://localhost:8080/api/get-product/${id}`;
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Aconteceu um erro ao realizar a busca do proudto.');
            }
            return response.json();
        })
        .then(data => {
            unitaryValue.value = parseFloat(data.price).toFixed(2).replace(/,/g, '.');
            quantity.value = 1;
            amount.value = parseFloat(data.price).toFixed(2).replace(/,/g, '.');

            if (!productsArray.includes(parseInt(data.product_id))) {
                productsArray.push({
                    id: parseInt(data.product_id),
                    name: data.name,
                    price: parseFloat(data.price).toFixed(2).replace(/,/g, '.')
                });
            }

            console.log(productsArray)
        })
        .catch(error => {
            console.error('Ocorreu um erro:', error);
        });
}
productId.addEventListener('blur', function (event) {
    let id = event.target.value;

    getProductById(id);
});

//Essa função é responsável por controlar o quantidade do produto e calcular seu valor final de venda;
function changeQuantityProduct(quantity) {
    amount.value = (parseFloat(unitaryValue.value) * quantity).toFixed(2);
}
quantity.addEventListener('input', function (event) {
    let value = event.target.value;

    if (parseInt(value) < 1) {
        alert("A quantidade não pode ser menor que 1!");
        quantity.value = 1;
        amount.value = (parseFloat(unitaryValue.value)).toFixed(2).replace(/,/g, '.');;
        return;
    }

    changeQuantityProduct(value);
});




paymentMethod.addEventListener('change', function (event) {
    let value = event.target.value;

    if (value !== '') {
        partsQuantity.style.display = 'inline';
        return;
    }

    partsQuantity.style.display = 'none';
    return;
});

function generateParts() {

    let parts = parseInt(partsQuantity.value);
    let partValue = parseFloat(parseFloat(finalAmount.value) / parts).toFixed(2).replace(/,/g, '.');

    console.log(partValue);

    //verifica se a lista ul de parcela está preenchida, para fazer a limpeza e armazenar a nova
    //geração de parcelas
    if (partsList.innerHTML !== '') {
        partsList.innerHTML = '';
    }

    for (i = 1; i <= parts; i++) {
        let li = document.createElement('li');
        li.classList.add('list-group-item');

        let h6 = document.createElement('h6');
        h6.classList.add('h6', 'mb-1', 'text-center');
        h6.innerHTML = `Parcela ${i}`;

        //Cria o input do tipo date para armazenar a data da parcela
        let inputDatePart = document.createElement('input')
        inputDatePart.classList.add('form-control', 'mt-3', 'mb-2');
        inputDatePart.name = `part[${i}][date]`;
        inputDatePart.type = 'date';

        let datePartFinished = new Date();
        datePartFinished.setMonth(datePartFinished.getMonth() + i);
        //Isso é responsável por pegar a data a partir da parte T 'time';
        let stringDatePart = datePartFinished.toISOString().split('T')[0];
        inputDatePart.value = stringDatePart;

        //Cria o input que vai receber o valor da parcela
        let inputPartValue = document.createElement('input');
        inputPartValue.classList.add('form-control', 'mt-3', 'mb-2');
        inputPartValue.type = 'number';
        inputPartValue.value = parseFloat(partValue).toFixed(2).replace(/,/g, '.');;
        inputPartValue.name = `part[${i}][value]`;
        inputPartValue.id = `part-value-${i}`;

        inputPartValue.addEventListener('input', function (event) {
            let value = event.target.value;

            alterPartsValue(value, event.target.id);
        });
        li.appendChild(h6);
        li.appendChild(inputDatePart);
        li.appendChild(inputPartValue);
        partsList.appendChild(li);
    }

}

btnParts.addEventListener('click', function () {
    generateParts();
});


function alterPartsValue(value, idInput) {
    let parts = parseInt(partsQuantity.value);

    //gera o valor restante: valor da parcela personalizada menos o total da venda;
    let rest = parseFloat(parseFloat(finalAmount.value) - parseFloat(value)).toFixed(2).replace(/,/g, '.');;

    //gera o novo valor das parcelas restantes
    let newValuePart = parseFloat(rest / parts).toFixed(2).replace(/,/g, '.');;

    for (i = 1; i <= parts; i++) {

        //procura pelo id correspondente do input
        let selector = `part-value-${i}`;

        if (selector !== idInput) {
            //Atribui o novo valor a parcela
            let input = document.querySelector(`#part-value-${i}`);
            input.value = newValuePart;
        }
    }

}

