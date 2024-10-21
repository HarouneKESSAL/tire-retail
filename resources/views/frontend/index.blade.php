@extends('frontend.layouts.master')

@section('title','E-SHOP || HOME PAGE')

@section('main-content')

    <div class="search-container">

        <noscript>
            <p>Cette application nécessite JavaScript pour fonctionner correctement. Veuillez activer JavaScript dans
                votre navigateur.</p>
        </noscript>
        <div class="tab-navigation" role="tablist">
            <button class="tab active" data-target="pneu" role="tab" aria-selected="true">RECHERCHE PNEUS</button>
            <button class="tab" data-target="pneu-jantes" role="tab" aria-selected="false">ENSEMBLE DE PNEUS/JANTES
            </button>
            <button class="tab" data-target="remorque-vtt" role="tab" aria-selected="false">PNEUS DE REMORQUE/VTT <span
                    class="new-label">NOUVEAU</span></button>
        </div>
        <br>

        <!-- PNEU Content -->
        <div id="pneu" class="tab-content active">
            <div class="search-type-toggle">

                <button class="toggle active" data-target="dimensions-search">
                    <i class="icon-pneu"></i>
                    Par dimensions
                </button>
                <button class="toggle" data-target="vehicle-search">
                    <i class="fa fa-car"></i>
                    Par véhicule
                </button>
                <div class="slider"></div>
            </div>

            <div id="dimensions-search" class="search-content active">
                <form id="dimensions-form" method="POST" action="{{ route('product.search') }}">
                    @csrf
                    <input type="hidden" name="category_slug" value="pneu">

                    <!-- The main dimension selection row -->
                    <div class="form-row">
                        <div class="col">
                            <select name="width" class="form-control">
                                <option value="">Largeur</option>
                                @foreach($pneuDimensions['widths'] as $width)
                                    <option value="{{ $width->width }}">{{ $width->width }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select name="aspect_ratio" class="form-control">
                                <option value="">Rapport</option>
                                @foreach($pneuDimensions['aspect_ratios'] as $aspect_ratio)
                                    <option
                                        value="{{ $aspect_ratio->aspect_ratio }}">{{ $aspect_ratio->aspect_ratio }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select name="diameter" class="form-control">
                                <option value="">Diametre</option>
                                @foreach($pneuDimensions['diameters'] as $diameter)
                                    <option value="{{ $diameter->diameter }}">{{ $diameter->diameter }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>



                    <!-- Season toggle after the selects -->
                    <div class="season-toggle">
                        <label class="radio-label">
                            <input type="radio" name="season" value="winter" checked> Pneus d'hiver
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="season" value="summer"> Pneus d'été/4 saisons
                        </label>
                    </div>

                    <!-- Search button -->
                    <button type="submit" class="search-button">LANCER LA RECHERCHE</button>
                </form>
            </div>


            <div id="vehicle-search" class="search-content">
                <form class="pneu-jantes-form" id="pneu-jantes-form-1" method="post" action="{{ route('filter.results') }}">
                    @csrf
                    <input type="hidden" name="category_slug" value="pneujantes">
                    <div class="form-row">
                        <div class="col">
                            <select name="year" class="form-control">
                                <option value="">Sélectionner l'année</option>

                                @foreach($pneuYears as $year)
                                    <option value="{{ $year->car_year }}">{{ $year->car_year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select name="car_brand" class="form-control">
                                <option value="">Sélectionner la marque</option>

                                @foreach($pneuCar_brands as $car_brand)
                                    <option value="{{ $car_brand->car_brand }}">{{ $car_brand->car_brand }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <select name="model" class="form-control">
                                <option value="">Sélectionner le modèle</option>

                                @foreach($pneuModels as $model)
                                    <option value="{{ $model->car_model }}">{{ $model->car_model }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select name="option" class="form-control">
                                <option value="">Sélectionner l'option</option>
                                @foreach($pneuOptions as $option)
                                    <option value="{{ $option->option }}">{{ $option->option }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="season-toggle">
                        <label class="radio-label">
                            <input type="radio" name="season" value="winter" checked> Pneus d'hiver
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="season" value="summer"> Pneus d'été/4 saisons
                        </label>
                    </div>
                    <button type="submit" class="search-button">LANCER LA RECHERCHE</button>
                </form>
            </div>
        </div>

        <!-- ENSEMBLE DE PNEUS/JANTES Content -->
        <div id="pneu-jantes" class="tab-content">
            <form class="pneu-jantes-form" id="pneu-jantes-form-2" method="post" action="{{ route('filter.results') }}" class="filter-form">
                @csrf
                <input type="hidden" name="category_slug" value="pneujantes">
                <div class="form-row">
                    <div class="col">
                        <select name="year" class="form-control">
                            <option value="">Select Year</option>
                            @foreach($pneuJantesYears as $year)
                                <option value="{{ $year->car_year }}">{{ $year->car_year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select name="car_brand" class="form-control">
                            <option value="">Select Make</option>
                            @foreach($pneuJantesCar_brands as $car_brand)
                                <option value="{{ $car_brand->car_brand }}">{{ $car_brand->car_brand }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <select name="model" class="form-control">
                            <option value="">Select Model</option>
                            @foreach($pneuJantesModels as $model)
                                <option value="{{ $model->car_model }}">{{ $model->car_model }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select name="option" class="form-control">
                            <option value="">Select Option</option>
                            @foreach($pneuJantesOptions as $option)
                                <option value="{{ $option->option }}">{{ $option->option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="season-toggle">
                    <label class="radio-label">
                        <input type="radio" name="season" value="winter" checked> Pneus d'hiver
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="season" value="summer"> Pneus d'été/4 saisons
                    </label>
                </div>
                <button type="submit" class="search-button">LANCER LA RECHERCHE</button>
            </form>
        </div>

        <!-- PNEUS DE REMORQUE/VTT Content -->
        <div id="remorque-vtt" class="tab-content">
            <form id="remorque-vtt-form" method="POST" action="{{ route('product.search') }}" class="filter-form">
                @csrf
                <input type="hidden" name="category_slug" value="pneu">
                <div class="form-row">
                    <div class="col">
                        <select name="width" class="form-control">
                            <option value="">Largeur</option>
                            @foreach($rouesJantesDimensions['widths'] as $width)
                                <option value="{{ $width->width }}">{{ $width->width }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select name="aspect_ratio" class="form-control">
                            <option value="">Rapport</option>
                            @foreach($rouesJantesDimensions['aspect_ratios'] as $aspect_ratio)
                                <option
                                    value="{{ $aspect_ratio->aspect_ratio }}">{{ $aspect_ratio->aspect_ratio }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select name="diameter" class="form-control">
                            <option value="">Diametre</option>
                            @foreach($rouesJantesDimensions['diameters'] as $diameter)
                                <option value="{{ $diameter->diameter }}">{{ $diameter->diameter }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="season-toggle">
                    <label class="radio-label">
                        <input type="radio" name="season" value="winter" checked> Pneus d'hiver
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="season" value="summer"> Pneus d'été/4 saisons
                    </label>
                </div>
                <button type="submit" class="search-button">LANCER LA RECHERCHE</button>
            </form>
        </div>
    </div>

    <style>
        /* Responsive Styles */

        /* Small devices (up to 576px) */
        @media (max-width: 576px) {
            .search-container {
                width: 95%;
                right: 50%;
                transform: translate(50%, -50%);
                padding: 15px;
            }

            .form-control {
                font-size: 12px;
                padding: 6px;
            }

            .form-row {
                flex-direction: column;
            }

            .col {
                margin-bottom: 8px;
                margin-right: 0;
            }

            .tab, .toggle {
                font-size: 12px;
                padding: 6px;
            }
        }

        /* Medium devices (up to 768px) */
        @media (max-width: 768px) {
            .search-container {
                width: 90%;
                top: 60%;
                right: 50%;
                transform: translate(50%, -50%);
            }

            .form-control {
                font-size: 14px;
                padding: 8px;
            }

            .form-row {
                flex-direction: column;
            }

            .col {
                margin-bottom: 10px;
                margin-right: 0;
            }

            .tab {
                font-size: 12px;
                padding: 8px;
            }

            .toggle {
                font-size: 12px;
                padding: 8px;
            }
        }

        /* Large devices (up to 992px) */
        @media (max-width: 992px) {
            .search-container {
                width: 75%;
                padding: 18px;
            }

            .form-control {
                font-size: 16px;
            }

            .tab, .toggle {
                font-size: 14px;
                padding: 10px;
            }
        }

        /* Ensure that the modal's parent isn't restricting the stacking context */
        .modal {
            position: fixed; /* This ensures it's positioned relative to the viewport */
            z-index: 1500; /* Keep a high z-index */
        }


        .modal-backdrop {
            z-index: 1040; /* Ensure the backdrop appears below the modal */
        }

        @media (max-width: 768px) {
            .search-container {
                top: 60%;
                width: 70%;
                right: 50%;
                transform: translate(50%, -50%);
            }
        }
        @media (max-width: 768px) {
            .form-control {
                font-size: 14px; /* Smaller font size on mobile */
                padding: 8px;
            }
        }
        @media (max-width: 768px) {
            .search-container {
                width: 90%; /* Further reduce width on smaller devices */
                top: 60%; /* Ensure the container remains visible */
                right: 50%;
                transform: translate(50%, -50%);
            }

            .form-row {
                flex-direction: column; /* Stack form elements vertically */
            }

            .col {
                margin-bottom: 10px;
                margin-right: 0;
            }
            }

        .search-container {
            background-color: rgba(0, 0, 0, 0.7);

            padding: 20px;
            color: white;
            max-width: 800px;
            margin: 0 auto;
            position: absolute;
            top: 50%;
            right: 5rem;
            transform: translateY(-50%);
            z-index: 10;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 40%;
            height: auto; /* Dynamic height based on content */
            max-height: 100%; /* Ensure it doesn't overflow the banner */
            overflow-y: visible; /* Avoid cutting off content */
            position: absolute;
            top: 60%;
            transform: translateY(-50%);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 40%;
        }



        .search-header {
            text-align: center;
            border-bottom: 1px solid white;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .tab-navigation {
            display: flex;
            background-color: #333;
            padding: 10px;
        }

        .tab {
            background-color: transparent;
            border: none;
            color: #fff;
            cursor: pointer;
            padding: 10px 20px;
            font-size: 14px;
            text-transform: uppercase;
            transition: background-color 0.3s, color 0.3s;
        }

        .tab:hover {
            background-color: #444;
        }

        .tab.active {
            background-color: #555;
        }

        .new-label {
            background-color: #4CAF50;
            color: white;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 0.7em;
            margin-left: 5px;
            text-transform: uppercase;
        }

        .search-type-toggle {
            display: flex;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }

        .toggle {
            flex-grow: 1;
            padding: 10px;
            background-color: #444;
            border: none;
            color: white;
            cursor: pointer;
            position: relative;
            z-index: 1;
        }

        .toggle.active {
            background-color: #ffa500;
        }

        .slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            background-color: #ffa500;
            transition: transform 0.3s ease-in-out;
        }

        .search-content {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .search-content.active {
            display: block;
            opacity: 1;
        }

        #vehicle-search {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }

        #vehicle-search.active {
            transform: translateX(0);
        }

        #dimensions-search {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }

        #dimensions-search.active {
            transform: translateX(0);
        }

        .toggle.active {
            background-color: #ffa500;
        }

        .search-content, .tab-content {
            display: none;
        }

        .search-content.active, .tab-content.active {
            display: block;
        }

        .form-row {
            display: flex;
            flex-wrap: nowrap;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .col {
            flex: 1;
            margin-right: 10px;
            min-width: 0; /* Allow shrinking below content size */
        }

        .col:last-child {
            margin-right: 0;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            box-sizing: border-box; /* Include padding in width calculation */
        }

        select.form-control {
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }
        .form-control:focus {
            outline: 2px solid #ffa500;
        }

        .add-dimension {
            color: #ffa500;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }

        .season-toggle {
            margin-bottom: 20px;
        }

        .radio-label {
            display: inline-block;
            margin-right: 20px;
        }

        .search-button, .btn-black {
            width: 100%;
            padding: 15px;
            background-color: #cc0000;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }

        .search-button:hover, .btn-black:hover {
            background-color: #ff0000;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.tab-navigation .tab');
            const tabContents = document.querySelectorAll('.tab-content');
            const toggleButtons = document.querySelectorAll('.search-type-toggle .toggle');
            const searchContents = document.querySelectorAll('.search-content');
            const slider = document.querySelector('.slider');

            function setActiveTab(target) {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                document.querySelector(`.tab[data-target="${target}"]`).classList.add('active');
                document.getElementById(target).classList.add('active');
            }

            function setActiveToggle(target) {
                toggleButtons.forEach(btn => btn.classList.remove('active'));
                searchContents.forEach(content => content.classList.remove('active'));

                const activeToggle = document.querySelector(`.toggle[data-target="${target}"]`);
                activeToggle.classList.add('active');
                document.getElementById(target).classList.add('active');

                // Move the slider
                if (target === 'vehicle-search') {
                    slider.style.transform = 'translateX(100%)';
                } else {
                    slider.style.transform = 'translateX(0)';
                }
            }


            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    setActiveTab(this.getAttribute('data-target'));
                });
            });

            toggleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    setActiveToggle(this.getAttribute('data-target'));
                });
            });


        });
    </script>

    <!-- Modal Markup -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Results</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="filterResults">
                    <!-- Search results will be displayed here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal End --><!-- Filter Section End -->
    <!-- Modal Markup -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Results</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="filterResults">
                    <!-- Search results will be displayed here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterModal = new bootstrap.Modal(document.getElementById('filterModal'));

            // Submit handler for the filter form
            document.getElementById('pneu-jantes-form').addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch(this.action, {
                    method: this.method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('filterResults').innerHTML = data;
                        filterModal.show();  // Show the modal with the search results
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
        $('#filterModal').on('shown.bs.modal', function () {
            $(this).css('z-index', 1050);
        });

    </script>

    <!-- Zone de diaporama -->
    @if(count($banners)>0)
        <section id="Gslider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($banners as $key=>$banner)
                    <li data-target="#Gslider" data-slide-to="{{$key}}" class="{{(($key==0)? 'active' : '')}}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner" role="listbox">
                @foreach($banners as $key=>$banner)
                    <div class="carousel-item {{(($key==0)? 'active' : '')}}">
                        <img class="first-slide" src="{{$banner->photo}}" alt="Première diapositive">
                        <div class="carousel-caption d-none d-md-block text-left">
                            <h1 class="wow fadeInDown">{{$banner->title}}</h1>
                            <p>{!! html_entity_decode($banner->description) !!}</p>
                            <a class="btn btn-lg ws-btn wow fadeInUpBig" href="{{ route('product.view', ['viewType' => 'grid']) }}" role="button">Achetez Maintenant<i class="far fa-arrow-alt-circle-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Précédent</span>
            </a>
            <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Suivant</span>
            </a>
        </section>
    @endif
    <!--/ Fin zone de diaporama -->

    <!-- Début de la petite bannière -->
    <section class="small-banner section">
        <div class="container-fluid">
            <div class="row">
                @php
                    $category_lists=DB::table('categories')->where('status','active')->limit(3)->get();
                @endphp
                @if($category_lists)
                    @foreach($category_lists as $cat)
                        @if($cat->is_parent==1)
                            <!-- Bannière simple -->
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="single-banner">
                                    @if($cat->photo)
                                        <img src="{{$cat->photo}}" alt="{{$cat->photo}}">
                                    @else
                                        <img src="https://via.placeholder.com/600x370" alt="#">
                                    @endif
                                    <div class="content">
                                        <h3>{{$cat->title}}</h3>
                                        <a href="{{route('product-cat',$cat->slug)}}">Découvrez maintenant</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!--/ Fin bannière simple -->
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- Fin de la petite bannière -->

    <!-- Début de la zone des produits -->
    <div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Articles Tendance</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-info">
                        <div class="nav-main">
                            <!-- Navigation des onglets -->
                            <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                                @php
                                    $categories=DB::table('categories')->where('status','active')->where('is_parent',1)->get();
                                @endphp
                                @if($categories)
                                    <button class="btn" style="background:black" data-filter="*">
                                        Tous les produits
                                    </button>
                                    @foreach($categories as $key=>$cat)
                                        <button class="btn" style="background:none;color:black;" data-filter=".{{$cat->id}}">
                                            {{$cat->title}}
                                        </button>
                                    @endforeach
                                @endif
                            </ul>
                            <!--/ Fin navigation des onglets -->
                        </div>
                        <div class="tab-content isotope-grid" id="myTabContent">
                            <!-- Début d'un onglet unique -->
                            @if($product_lists)
                                @foreach($product_lists as $key=>$product)
                                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$product->cat_id}}">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="{{route('product-detail',$product->slug)}}">
                                                    @php
                                                        $photo=explode(',',$product->photo);
                                                    @endphp
                                                    <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                                    <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                                    @if($product->stock<=0)
                                                        <span class="out-of-stock">Rupture de stock</span>
                                                    @elseif($product->condition=='new')
                                                        <span class="new">Nouveau</span>
                                                    @elseif($product->condition=='hot')
                                                        <span class="hot">Populaire</span>
                                                    @else
                                                        <span class="price-dec">{{$product->discount}}% Réduction</span>
                                                    @endif
                                                </a>
                                                <div class="button-head">
                                                    <div class="product-action">
                                                        <a data-toggle="modal" data-target="#{{$product->id}}" title="Aperçu rapide" href="#"><i class=" ti-eye"></i><span>Achat rapide</span></a>
                                                        <a title="Liste de souhaits" href="{{route('add-to-wishlist',$product->slug)}}" ><i class=" ti-heart "></i><span>Ajouter à la liste de souhaits</span></a>
                                                    </div>
                                                    <div class="product-action-2">
                                                        <a title="Ajouter au panier" href="{{route('add-to-cart',$product->slug)}}">Ajouter au panier</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                                <div class="product-price">
                                                    @php
                                                        $after_discount=($product->price-($product->price*$product->discount)/100);
                                                    @endphp
                                                    <span>${{number_format($after_discount,2)}}</span>
                                                    <del style="padding-left:4%;">${{number_format($product->price,2)}}</del>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <!--/ Fin onglet unique -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin zone des produits -->

    <!-- Début bannière moyenne -->
    <section class="midium-banner">
        <div class="container">
            <div class="row">
                @if($featured)
                    @foreach($featured as $data)
                        <!-- Bannière unique -->
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="single-banner">
                                @php
                                    $photo=explode(',',$data->photo);
                                @endphp
                                <img src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                <div class="content">
                                    <p>{{$data->cat_info['title']}}</p>
                                    <h3>{{$data->title}} <br>Jusqu'à<span> {{$data->discount}}%</span></h3>
                                    <a href="{{route('product-detail',$data->slug)}}">Achetez Maintenant</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- Fin bannière moyenne -->

    <!-- Début articles populaires -->
    <div class="product-area most-popular section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Articles Populaires</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
                        @foreach($product_lists as $product)
                            @if($product->condition=='hot')
                                <!-- Début produit unique -->
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="{{route('product-detail',$product->slug)}}">
                                            @php
                                                $photo=explode(',',$product->photo);
                                            @endphp
                                            <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                            <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                        </a>
                                        <div class="button-head">
                                            <div class="product-action">
                                                <a data-toggle="modal" data-target="#{{$product->id}}" title="Aperçu rapide" href="#"><i class=" ti-eye"></i><span>Achat rapide</span></a>
                                                <a title="Liste de souhaits" href="{{route('add-to-wishlist',$product->slug)}}" ><i class=" ti-heart "></i><span>Ajouter à la liste de souhaits</span></a>
                                            </div>
                                            <div class="product-action-2">
                                                <a href="{{route('add-to-cart',$product->slug)}}">Ajouter au panier</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                        <div class="product-price">
                                            <span class="old">${{number_format($product->price,2)}}</span>
                                            @php
                                                $after_discount=($product->price-($product->price*$product->discount)/100)
                                            @endphp
                                            <span>${{number_format($after_discount,2)}}</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin produit unique -->
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin articles populaires -->

    <!-- Début liste des nouveautés -->
    <section class="shop-home-list section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="shop-section-title">
                                <h1>Nouveaux Articles</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @php
                            $product_lists=DB::table('products')->where('status','active')->orderBy('id','DESC')->limit(6)->get();
                        @endphp
                        @foreach($product_lists as $product)
                            <div class="col-md-4">
                                <!-- Début liste unique -->
                                <div class="single-list">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="list-image overlay">
                                                @php
                                                    $photo=explode(',',$product->photo);
                                                @endphp
                                                <img src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                                <a href="{{route('add-to-cart',$product->slug)}}" class="buy"><i class="fa fa-shopping-bag"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 no-padding">
                                            <div class="content">
                                                <h4 class="title"><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h4>
                                                <p class="price with-discount">${{number_format($product->discount,2)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin liste unique -->
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin liste des nouveautés -->

    <!-- Début blog de la boutique -->
    <section class="shop-blog section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>De notre blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @if($posts)
                    @foreach($posts as $post)
                        <div class="col-lg-4 col-md-6 col-12">
                            <!-- Début article unique du blog -->
                            <div class="shop-single-blog">
                                <img src="{{$post->photo}}" alt="{{$post->photo}}">
                                <div class="content">
                                    <p class="date">{{$post->created_at->format('d M , Y. D')}}</p>
                                    <a href="{{route('blog.detail',$post->slug)}}" class="title">{{$post->title}}</a>
                                    <a href="{{route('blog.detail',$post->slug)}}" class="more-btn">Lire la suite</a>
                                </div>
                            </div>
                            <!-- Fin article unique du blog -->
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- Fin blog de la boutique -->

    <!-- Début des services -->
    <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Début service unique -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Livraison gratuite</h4>
                        <p>Commandes supérieures à 100$</p>
                    </div>
                    <!-- Fin service unique -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Début service unique -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Retour gratuit</h4>
                        <p>Retour sous 30 jours</p>
                    </div>
                    <!-- Fin service unique -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Début service unique -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Paiement sécurisé</h4>
                        <p>Paiement 100% sécurisé</p>
                    </div>
                    <!-- Fin service unique -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Début service unique -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Meilleur prix</h4>
                        <p>Prix garanti</p>
                    </div>
                    <!-- Fin service unique -->
                </div>
            </div>
        </div>
    </section>
    <!-- Fin des services -->

    @include('frontend.layouts.newsletter')

    <!-- Modal -->
    @if($product_lists)
        @foreach($product_lists as $key=>$product)
            <div class="modal fade" id="{{$product->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span class="ti-close" aria-hidden="true"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row no-gutters">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Galerie produit -->
                                    <div class="product-gallery">
                                        <div class="quickview-slider-active">
                                            @php
                                                $photo=explode(',',$product->photo);
                                            @endphp
                                            @foreach($photo as $data)
                                                <div class="single-slider">
                                                    <img src="{{$data}}" alt="{{$data}}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- Fin galerie produit -->
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="quickview-content">
                                        <h2>{{$product->title}}</h2>
                                        <div class="quickview-ratting-review">
                                            <div class="quickview-ratting-wrap">
                                                <div class="quickview-ratting">
                                                    @php
                                                        $rate=DB::table('product_reviews')->where('product_id',$product->id)->avg('rate');
                                                        $rate_count=DB::table('product_reviews')->where('product_id',$product->id)->count();
                                                    @endphp
                                                    @for($i=1; $i<=5; $i++)
                                                        @if($rate>=$i)
                                                            <i class="yellow fa fa-star"></i>
                                                        @else
                                                            <i class="fa fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <a href="#"> ({{$rate_count}} avis clients)</a>
                                            </div>
                                            <div class="quickview-stock">
                                                @if($product->stock >0)
                                                    <span><i class="fa fa-check-circle-o"></i> {{$product->stock}} en stock</span>
                                                @else
                                                    <span><i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} en rupture de stock</span>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $after_discount=($product->price-($product->price*$product->discount)/100);
                                        @endphp
                                        <h3><small><del class="text-muted">${{number_format($product->price,2)}}</del></small>    ${{number_format($after_discount,2)}}  </h3>
                                        <div class="quickview-peragraph">
                                            <p>{!! html_entity_decode($product->summary) !!}</p>
                                        </div>
                                        @if($product->size)
                                            <div class="size">
                                                <div class="row">
                                                    <div class="col-lg-6 col-12">
                                                        <h5 class="title">Taille</h5>
                                                        <select>
                                                            @php
                                                                $sizes=explode(',',$product->size);
                                                            @endphp
                                                            @foreach($sizes as $size)
                                                                <option>{{$size}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <form action="{{route('single-add-to-cart')}}" method="POST" class="mt-4">
                                            @csrf
                                            <div class="quantity">
                                                <!-- Input quantité -->
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="slug" value="{{$product->slug}}">
                                                    <input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--/ Fin Input quantité -->
                                            </div>
                                            <div class="add-to-cart">
                                                <button type="submit" class="btn">Ajouter au panier</button>
                                                <a href="{{route('add-to-wishlist',$product->slug)}}" class="btn min"><i class="ti-heart"></i></a>
                                            </div>
                                        </form>
                                        <div class="default-social">
                                            <!-- ShareThis BEGIN --><div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <!-- Fin du modal -->
@endsection

@push('styles')
    <style>

        #Gslider .carousel-inner {
            background: #000000;
            color: black;
        }

        #Gslider .carousel-inner {
            height: 550px;
        }

        #Gslider .carousel-inner img {
            width: 100% !important;
            opacity: .8;
        }

        #Gslider .carousel-inner .carousel-caption {
            bottom: 60%;
        }

        #Gslider .carousel-inner .carousel-caption h1 {
            font-size: 50px;
            font-weight: bold;
            line-height: 100%;

        }

        #Gslider .carousel-inner .carousel-caption p {
            font-size: 18px;
            color: black;
            margin: 28px 0 28px 0;
        }

        #Gslider .carousel-indicators {
            bottom: 70px;
        }
    </style>
    <style>
        /* General Styles for Filter Box */
        .filter-box {
            position: absolute;
            top: 70%;
            right: 5rem;
            transform: translateY(-50%);
            z-index: 10;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 40%;
        }

        /* Mobile Styles */
        /* Mobile Styles */
        @media (max-width: 768px) {
            .filter-box {
                width: 90%;
                right: 5%;
                top: 20%;
                transform: translateY(0);
                padding: 10px;
            }

            .filter-options {
                display: flex;
                flex-direction: row; /* Align buttons in a row */
                flex-wrap: wrap; /* Allow wrapping to new line */
                justify-content: space-around; /* Space around buttons */
            }

            .filter-btn {
                flex: 1 1 30%; /* Allow buttons to grow and shrink */
                margin: 5px; /* Margin for spacing */
                padding: 10px 5px; /* Adjust padding */
                text-align: center; /* Center text */
                background-color: #ff0000; /* Red background */
                color: #fff; /* White text */
                border: none; /* Remove border */
                border-radius: 3px; /* Rounded corners */
            }

            .form-row {
                flex-direction: column;
            }

            .form-control {
                width: 100%;
                margin-bottom: 10px;
            }

            .btn.btn-black {
                width: 100%;
            }

            .filter-content {
                margin-top: 15px;
            }
        }

        .filter-content {
            display: none;
        }

        .filter-content.active {
            display: block;
            opacity: 0;
            animation: fadeIn 0.5s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .filter-options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .filter-btn {
            margin: 0 5px;
            padding: 10px 20px;
            background-color: #ff0000; /* Red color */
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease; /* Smooth transition */
        }

        .filter-btn.active {
            background-color: #ff0000; /* Active button should be red */
            color: white; /* Text color should be white */
        }

        .filter-btn:hover {
            background-color: #b30000; /* Darker red on active/hover */
            color: #fff;
            transform: scale(1.05); /* Slightly enlarge the button on hover */
        }


        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .form-control {
            width: 48%;
            color: #ff0000;
        }

        .form-control:hover {

            color: #b30000;
        }

        .btn.btn-black {
            background-color: #000;
            color: #fff;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn.btn-black:hover {
            background-color: #b30000; /* Red color on hover */
        }

        .hidden {
            display: none;
        }

        .flex {
            display: flex;
        }


    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Use class selector instead of ID to target multiple forms
            const forms = document.querySelectorAll('.pneu-jantes-form');  // Select all forms with the class pneu-jantes-form

            // Iterate over each form and add submit event listener
            forms.forEach(form => {
                form.addEventListener('submit', function (event) {
                    submitForm(event, form);  // Pass the current form element to the submit handler
                });
            });

            var filterModal = new bootstrap.Modal(document.getElementById('filterModal'));

            window.submitForm = function (event, form) {
                event.preventDefault();  // Prevent default form submission
                const formData = new FormData(form);  // Use the form element directly
                const resultsContainer = document.getElementById('filterResults');

                fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(data => {
                        resultsContainer.innerHTML = data;
                        filterModal.show();  // Show the modal with the search results
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('There was an error processing your request. Please try again.');
                    });
            }
        });
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>

        /*==================================================================
        [ Isotope ]*/
        var $topeContainer = $('.isotope-grid');
        var $filter = $('.filter-tope-group');

        // filter items on button click
        $filter.each(function () {
            $filter.on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                $topeContainer.isotope({filter: filterValue});
            });

        });

        // init Isotope
        $(window).on('load', function () {
            var $grid = $topeContainer.each(function () {
                $(this).isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    animationEngine: 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item'
                    }
                });
            });
        });

        var isotopeButton = $('.filter-tope-group button');

        $(isotopeButton).each(function () {
            $(this).on('click', function () {
                for (var i = 0; i < isotopeButton.length; i++) {
                    $(isotopeButton[i]).removeClass('how-active1');
                }

                $(this).addClass('how-active1');
            });
        });

        // Show and hide filters based on product type
        $('#product_type').change(function () {
            var selectedType = $(this).val();
            $('.product-filters').addClass('d-none');
            if (selectedType == 'pneu') {
                $('#pneu-filters').removeClass('d-none');
            } else if (selectedType == 'pneu_et_jantes') {
                $('#pneu-et-jantes-filters').removeClass('d-none');
            } else if (selectedType == 'roues_et_jantes') {
                $('#roues-et-jantes-filters').removeClass('d-none');
            }
        });

        // Initialize the filter based on the selected type on page load
        $(document).ready(function () {
            var selectedType = $('#product_type').val();
            if (selectedType == 'pneu') {
                $('#pneu-filters').removeClass('d-none');
            } else if (selectedType == 'pneu_et_jantes') {
                $('#pneu-et-jantes-filters').removeClass('d-none');
            } else if (selectedType == 'roues_et_jantes') {
                $('#roues-et-jantes-filters').removeClass('d-none');
            }
        });

    </script>
    <script>
        function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el.exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.filter-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.filter-btn').forEach(function (btn) {
                        btn.classList.remove('active');
                    });
                    btn.classList.add('active');

                    document.querySelectorAll('.filter-content').forEach(function (content) {
                        content.classList.remove('active');
                    });
                    document.querySelector('#' + btn.id.replace('-btn', '-filter')).classList.add('active');
                });
            });
        });


    </script>

@endpush
