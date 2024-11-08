<header class="header shop">
    <!-- Barre supérieure -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Haut gauche -->
                    <div class="top-left">
                        <ul class="list-main">
                            @php
                                $settings=DB::table('settings')->get();
                            @endphp
                            <li><i class="ti-headphone-alt"></i>@foreach($settings as $data) {{$data->phone}} @endforeach</li>
                            <li><i class="ti-email"></i> @foreach($settings as $data) {{$data->email}} @endforeach</li>
                        </ul>
                    </div>
                    <!--/ Fin Haut gauche -->
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Haut droit -->
                    <div class="right-content">
                        <ul class="list-main">
                            <li><i class="ti-location-pin"></i> <a href="{{route('order.track')}}">Suivi de commande</a></li>
                            {{-- <li><i class="ti-alarm-clock"></i> <a href="#">Offre du jour</a></li> --}}
                            @auth
                                @if(Auth::user()->role=='admin')
                                    <li><i class="ti-user"></i> <a href="{{route('admin')}}"  target="_blank">Tableau de bord</a></li>
                                @else
                                    <li><i class="ti-user"></i> <a href="{{route('user')}}"  target="_blank">Tableau de bord</a></li>
                                @endif
                                <li><i class="ti-power-off"></i> <a href="{{route('user.logout')}}">Déconnexion</a></li>
                            @else
                                <li><i class="ti-power-off"></i><a href="{{route('login.form')}}">Connexion /</a> <a href="{{route('register.form')}}">Inscription</a></li>
                            @endauth
                        </ul>
                    </div>
                    <!-- Fin Haut droit -->
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Barre supérieure -->

    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div class="logo">
                        @php
                            $settings=DB::table('settings')->get();
                        @endphp
                        <a href="{{route('home')}}"><img src="@foreach($settings as $data) {{$data->logo}} @endforeach" alt="logo"></a>
                    </div>
                    <!--/ Fin Logo -->
                    <!-- Formulaire de recherche -->
                    <div class="search-top">
                        <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                        <!-- Formulaire de recherche -->
                        <div class="search-top">
                            <form class="search-form">
                                <input type="text" placeholder="Recherchez ici..." name="search">
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                        <!--/ Fin Formulaire de recherche -->
                    </div>
                    <!--/ Fin Formulaire de recherche -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <select>
                                <option >Catégories</option>
                                @foreach(Helper::getAllCategory() as $cat)
                                    <option>{{$cat->title}}</option>
                                @endforeach
                            </select>
                            <form method="POST" action="{{route('product.search')}}">
                                @csrf
                                <input name="search" placeholder="Recherchez des produits ici....." type="search">
                                <button class="btnn" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        <!-- Formulaire de recherche -->
                        <div class="sinlge-bar shopping">
                            @php
                                $total_prod=0;
                                $total_amount=0;
                            @endphp
                            @if(session('wishlist'))
                                @foreach(session('wishlist') as $wishlist_items)
                                    @php
                                        $total_prod+=$wishlist_items['quantity'];
                                        $total_amount+=$wishlist_items['amount'];
                                    @endphp
                                @endforeach
                            @endif
                            <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o"></i> <span class="total-count">{{Helper::wishlistCount()}}</span></a>
                            <!-- Article de shopping -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromWishlist())}} Articles</span>
                                        <a href="{{route('wishlist')}}">Voir la wishlist</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                        @foreach(Helper::getAllProductFromWishlist() as $data)
                                            @php
                                                $photo=explode(',',$data->product['photo']);
                                            @endphp
                                            <li>
                                                <a href="{{route('wishlist-delete',$data->id)}}" class="remove" title="Supprimer cet article"><i class="fa fa-remove"></i></a>
                                                <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                                <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">${{number_format(Helper::totalWishlistPrice(),2)}}</span>
                                        </div>
                                        <a href="{{route('cart')}}" class="btn animate">Panier</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ Fin Article de shopping -->
                        </div>
                        {{-- <div class="sinlge-bar">
                            <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div> --}}
                        <div class="sinlge-bar shopping">
                            <a href="{{route('cart')}}" class="single-icon"><i class="ti-bag"></i> <span class="total-count">{{Helper::cartCount()}}</span></a>
                            <!-- Article de shopping -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromCart())}} Articles</span>
                                        <a href="{{route('cart')}}">Voir le panier</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                        @foreach(Helper::getAllProductFromCart() as $data)
                                            @php
                                                $photo=explode(',',$data->product['photo']);
                                            @endphp
                                            <li>
                                                <a href="{{route('cart-delete',$data->id)}}" class="remove" title="Supprimer cet article"><i class="fa fa-remove"></i></a>
                                                <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                                <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">${{number_format(Helper::totalCartPrice(),2)}}</span>
                                        </div>
                                        <a href="{{route('checkout')}}" class="btn animate">Paiement</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ Fin Article de shopping -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Entête intérieure -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Menu principal -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}"><a href="{{route('home')}}">Accueil</a></li>
                                            <li class="{{Request::path()=='about-us' ? 'active' : ''}}"><a href="{{route('about-us')}}">À propos</a></li>
                                            <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif"><a href="{{ route('product.view', ['viewType' => 'grid']) }}" >Produits</a><span class="new">Nouveau</span></li>
{{--                                            {{Helper::getHeaderCategory()}}--}}
                                            <li class="{{Request::path()=='blog' ? 'active' : ''}}"><a href="{{route('blog')}}">Blog</a></li>
                                            <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a href="{{route('contact')}}">Contactez-nous</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ Fin Menu principal -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Fin Entête -->


</header>
