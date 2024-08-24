<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal Body -->
<div class="modal-body">
    <div class="mb-3">
        <label for="category" class="form-label">Que magasinez-vous?</label>

    </div>
    <h4 class="mt-4">Configurations possibles détectées</h4>
    <div id="product-list">
        @foreach($products as $product)
            <div class="card mb-3 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Ensemble pneus et jantes: <span class="text-primary">{{ $product->aspect_ratio }}</span></h5>
                        <p class="card-text text-muted mb-0">Dimension des pneus: <strong>{{ $product->aspect_ratio }}</strong>, <strong>{{ $product->diameter }}</strong>, <strong>{{ $product->width }}</strong></p>
                    </div>
                    <form action="{{ route('product.search') }}" method="POST" class="product-search-form">
                        @csrf
                        <input type="hidden" name="aspect_ratio" value="{{ $product->aspect_ratio }}">
                        <input type="hidden" name="diameter" value="{{ $product->diameter }}">
                        <input type="hidden" name="width" value="{{ $product->width }}">
                        <input type="hidden" name="car_brand" value="{{ request('car_brand') }}">
                        <input type="hidden" name="model" value="{{ request('model') }}">
                        <input type="hidden" name="year" value="{{ request('year') }}">
                        <button type="submit" class="btn btn-danger">LANCER LA RECHERCHE</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- Modal Footer -->

<style>
     .modal-body {
        padding: 20px;
    }
     select option {
         color: #333; /* Dark gray text color */
         background-color: #fff; /* White background */
     }

     select {
         color: #333; /* Dark gray text color for the selected option */
         background-color: #fff; /* White background for the select element */
     }
    .form-label {
        font-weight: bold;
        font-size: 1rem;
        color: #495057;
    }

    .form-select {
        height: 45px;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        box-shadow: none;
        font-size: 1rem;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-select:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .card {
        border: 1px solid #e9ecef;
        border-radius: 0.25rem;
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: bold;
        color: #333;
    }

    .card-text {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        transition: background-color 0.2s, border-color 0.2s;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .modal-footer {
        border-top: 1px solid #e9ecef;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .modal-content {
        padding: 20px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('category');
        const productList = document.getElementById('product-list');

        categorySelect.addEventListener('change', filterProducts);

        function getCSRFToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        function filterProducts() {
            const categoryId = categorySelect.value;
            fetch(`/filter-products?category_id=${categoryId}`, {
                headers: {
                    'X-CSRF-TOKEN': getCSRFToken(),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    productList.innerHTML = '';
                    data.products.forEach(product => {
                        productList.innerHTML += `
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-1">Ensemble pneus et jantes: <span class="text-primary">${product.aspect_ratio}</span></h5>
                                <p class="card-text text-muted mb-0">Dimension des pneus: <strong>${product.aspect_ratio}</strong>, <strong>${product.diameter}</strong>, <strong>${product.width}</strong></p>
                            </div>
                            <form action="/product/search" method="POST" class="product-search-form">
                                <input type="hidden" name="_token" value="${getCSRFToken()}">
                                <input type="hidden" name="aspect_ratio" value="${product.aspect_ratio}">
                                <input type="hidden" name="diameter" value="${product.diameter}">
                                <input type="hidden" name="width" value="${product.width}">
                                <button type="submit" class="btn btn-danger">LANCER LA RECHERCHE</button>
                            </form>
                        </div>
                    </div>
                `;
                    });
                    attachFormListeners();
                })
                .catch(error => console.error('Error:', error));
        }

        function attachFormListeners() {
            document.querySelectorAll('.product-search-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-CSRF-TOKEN': getCSRFToken(),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            // Handle the search results here
                            console.log(data);
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        }

        attachFormListeners();
    });
</script>
