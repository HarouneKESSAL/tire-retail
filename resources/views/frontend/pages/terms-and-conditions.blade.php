@extends('frontend.layouts.master')

@section('title','Termes & Conditions')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Accueil<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Termes & Conditions</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Terms & Conditions Section -->
    <section class="terms-conditions section">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12 col-12">
                    <h2 class="terms-title">TERMES & CONDITIONS</h2>
                    <div class="accordion" id="termsAccordion">
                        <!-- Navigation et utilisation du site Internet -->
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Navigation et utilisation du site Internet
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#termsAccordion">
                                <div class="card-body text-justify">
                                    Toute navigation ou recherche sur le site internet d'E-SHOP se fait à la discrétion et au risque de l'utilisateur. E-SHOP ne prend aucune responsabilité face aux risques associés à la navigation sur internet. Tout risque de dommages informatiques, électroniques, mentaux ou physiques est entièrement à la charge de l'internaute. Les outils de recherche présents sur ce site sont purement informatifs.

                                    L'utilisateur est responsable de la vérification de la justesse des informations fournies. E-SHOP décline toute responsabilité pour les erreurs commises par l'utilisateur concernant les informations de livraison ou la compatibilité des produits avec son véhicule. En cas d'erreur dans la commande (ex. modèle, dimensions), E-SHOP peut reprendre les produits, moyennant des frais de retour et de livraison.
                                </div>
                            </div>
                        </div>

                        <!-- Politique de confidentialité -->
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Politique de confidentialité
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#termsAccordion">
                                <div class="card-body text-justify">
                                    Cette section couvre la manière dont E-SHOP recueille, utilise et protège vos informations personnelles pour garantir la sécurité de votre expérience en ligne.
                                </div>
                            </div>
                        </div>

                        <!-- Politique de cookies -->
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Politique de cookies
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#termsAccordion">
                                <div class="card-body text-justify">
                                    E-SHOP utilise des cookies pour améliorer votre expérience sur le site. Ces cookies nous permettent de comprendre vos préférences et d'améliorer la performance de notre site.
                                </div>
                            </div>
                        </div>

                        <!-- Protection des renseignements personnels -->
                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Protection des renseignements personnels
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#termsAccordion">
                                <div class="card-body text-justify">
                                    E-SHOP garantit la sécurité de vos transactions grâce à des méthodes reconnues telles que PayPal. Aucune information sensible telle que vos numéros de comptes bancaires ou de cartes de crédit n'est stockée par E-SHOP. Toute transaction est effectuée sur des serveurs sécurisés.
                                </div>
                            </div>
                        </div>

                        <!-- Collecte de données et respect de la vie privée -->
                        <div class="card">
                            <div class="card-header" id="headingFive">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        Collecte de données et respect de la vie privée
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#termsAccordion">
                                <div class="card-body text-justify">
                                    E-SHOP utilise certaines informations personnelles comme votre nom, adresse, et numéro de téléphone à des fins administratives et pour traiter vos commandes. Ces informations ne sont jamais divulguées ou vendues à des tiers sans votre consentement.
                                </div>
                            </div>
                        </div>

                        <!-- Prévention de la fraude et de tout acte frauduleux -->
                        <div class="card">
                            <div class="card-header" id="headingSix">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        Prévention de la fraude et de tout acte frauduleux
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#termsAccordion">
                                <div class="card-body text-justify">
                                    E-SHOP prend la prévention de la fraude très au sérieux. Nous utilisons des systèmes de sécurité informatiques robustes, incluant le cryptage de données, pour assurer la protection de vos informations personnelles lors des transactions.
                                </div>
                            </div>
                        </div>

                        <!-- Autres frais et taxes -->
                        <div class="card">
                            <div class="card-header" id="headingSeven">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                        Autres frais et taxes
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#termsAccordion">
                                <div class="card-body text-justify">
                                    E-SHOP détaille chaque montant lors de votre commande, y compris les frais de livraison, les taxes applicables, et les frais de recyclage des produits dans certaines provinces.
                                </div>
                            </div>
                        </div>

                        <!-- Politique de couverture pour les hasards routiers -->
                        <div class="card">
                            <div class="card-header" id="headingEight">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                        Politique de couverture pour les hasards routiers
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#termsAccordion">
                                <div class="card-body text-justify">
                                    E-SHOP offre des couvertures pour les dommages causés par les hasards routiers, sous certaines conditions.
                                </div>
                            </div>
                        </div>

                        <!-- Politique d'achat de jantes en alliage ou roues en acier -->
                        <div class="card">
                            <div class="card-header" id="headingNine">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                        Politique d'achat de jantes en alliage ou roues en acier
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#termsAccordion">
                                <div class="card-body text-justify">
                                    Conditions relatives à l'achat de jantes en alliage ou de roues en acier via E-SHOP.
                                </div>
                            </div>
                        </div>

                        <!-- Erreurs typographiques -->
                        <div class="card">
                            <div class="card-header" id="headingTen">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                        Erreurs typographiques
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#termsAccordion">
                                <div class="card-body text-justify">
                                    E-SHOP s'efforce d'afficher des informations exactes. Toutefois, en cas d'erreurs typographiques ou de description, nous nous réservons le droit de refuser ou d'annuler des commandes.
                                </div>
                            </div>
                        </div>

                        <!-- Tout droit réservé et droits d'auteur -->
                        <div class="card">
                            <div class="card-header" id="headingEleven">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                                        Tout droit réservé et droits d'auteur
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseEleven" class="collapse" aria-labelledby="headingEleven" data-parent="#termsAccordion">
                                <div class="card-body text-justify">
                                    Tous les contenus du site E-SHOP sont protégés par des droits d'auteur. Toute modification ou utilisation non autorisée des contenus à des fins commerciales est strictement interdite.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-12 col-12">
                    <aside>
                        <div class="card sidebar-card">
                            <div class="card-header">
                                <h5>Nos services</h5>
                            </div>
                            <div class="card-body">
                                <p>Soon...</p>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!-- End Terms & Conditions Section -->
@endsection

@push('styles')
    <style>
        .terms-title {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .card-header button {
            font-size: 18px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .card-body {
            font-size: 16px;
            color: #333;
            text-align: justify;
        }
        .sidebar-card {
            background-color: #f5f5f5;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 20px;
        }
    </style>
@endpush
