@extends('backend.layouts.master')

@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger float-left">Liste des produits</h6>
            <a href="{{route('product.create')}}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Ajouter un produit"><i class="fas fa-plus"></i> Ajouter un produit</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @if(count($products) > 0)
                    <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Modèle</th>
                            <th>Marque</th>
                            <th>Type de service</th>
                            <th>Largeur (mm)</th>
                            <th>Ratio d'aspect</th>
                            <th>Construction</th>
                            <th>Diamètre (pouces)</th>
                            <th>Indice de charge</th>
                            <th>Indice de vitesse</th>
                            <th>Poids d'expédition</th>
                            <th>Voiture</th>
                            <th>Option</th>
                            <th>Extra Load</th> <!-- Boolean Field -->
                            <th>Pneu renforcé</th> <!-- Boolean Field -->
                            <th>Flancs porteurs (Runflat)</th> <!-- Boolean Field -->
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Remise</th>
                            <th>État</th>
                            <th>Photo</th>
                            <th>Statut</th>
                            <th>Saison</th>
                            <th>Action</th>
                        </tr>

                        </thead>
                        <tfoot>
                        <tr>
                            <th>Code</th>
                            <th>Modèle</th>
                            <th>Marque</th>
                            <th>Type de service</th>
                            <th>Largeur (mm)</th>
                            <th>Ratio d'aspect</th>
                            <th>Construction</th>
                            <th>Diamètre (pouces)</th>
                            <th>Indice de charge</th>
                            <th>Indice de vitesse</th>
                            <th>Poids d'expédition</th>
                            <th>Voiture</th>
                            <th>Option</th>
                            <th>Extra Load</th> <!-- Boolean Field -->
                            <th>Pneu renforcé</th> <!-- Boolean Field -->
                            <th>Flancs porteurs (Runflat)</th> <!-- Boolean Field -->
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Remise</th>
                            <th>État</th>
                            <th>Photo</th>
                            <th>Statut</th>
                            <th>Saison</th>
                            <th>Action</th>
                        </tr>

                        </tfoot>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{$product->code}}</td>
                                <td>{{$product->model}}</td>
                                <td>{{$product->brand}}</td>
                                <td>{{$product->service_type}}</td>
                                <td>{{$product->width}}</td>
                                <td>{{$product->aspect_ratio}}</td>
                                <td>R</td>
                                <td>{{$product->diameter}}</td>
                                <td>{{$product->load_index}}</td>
                                <td>{{$product->speed_index}}</td>
                                <td>{{$product->shipping_weight}}</td>

                                <td>
                                    @php
                                        $car = DB::table('brands')->select('car_brand', 'car_model', 'car_year')->where('id', $product->brand_id)->first();
                                    @endphp
                                    {{ $car ? $car->car_brand . ' ' . $car->car_model . ' ' . $car->car_year : 'N/A' }}
                                </td>
                                <td>
                                    @php
                                        $car = DB::table('brands')->select('option')->where('id', $product->brand_id)->first();
                                    @endphp
                                    {{$car->option}}
                                </td>
                                <!-- Display "Oui" for true booleans and "Non" for false -->
                                <td>{{ $product->extra_load ? 'Oui' : 'Non' }}</td>
                                <td>{{ $product->pneu_renforce ? 'Oui' : 'Non' }}</td>
                                <td>{{ $product->runflat ? 'Oui' : 'Non' }}</td>

                                <td>Rs. {{$product->price}} /-</td>
                                <td>
                                    @if($product->stock > 0)
                                        <span class="badge badge-primary">{{$product->stock}}</span>
                                    @else
                                        <span class="badge badge-danger">{{$product->stock}}</span>
                                    @endif
                                </td>
                                <td>{{$product->discount}}% OFF</td>
                                <td>{{$product->condition}}</td>
                                <td>
                                    @if($product->photo)
                                        @php
                                            $photo = explode(',', $product->photo);
                                        @endphp
                                        <img src="{{$photo[0]}}" class="img-fluid zoom" style="max-width:80px" alt="{{$product->photo}}">
                                    @else
                                        <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:80px" alt="avatar.png">
                                    @endif
                                </td>

                                <td>
                                    @if($product->status == 'active')
                                        <span class="badge badge-success">{{$product->status}}</span>
                                    @else
                                        <span class="badge badge-warning">{{$product->status}}</span>
                                    @endif
                                </td>
                                <td>{{$product->season}}</td>
                                <td>
                                    <a href="{{route('product.edit', $product->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px; border-radius:50%" data-toggle="tooltip" title="Modifier" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{route('product.destroy', [$product->id])}}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm dltBtn" data-id={{$product->id}} style="height:30px; width:30px; border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Supprimer"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    <span style="float:right">{{$products->links('vendor.pagination.custom-pagination')}}</span>

                @else
                    <h6 class="text-center">Aucun produit trouvé ! Veuillez créer un produit.</h6>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }
        .zoom {
            transition: transform .2s; /* Animation */
        }
        .zoom:hover {
            transform: scale(5);
        }
    </style>
@endpush

@push('scripts')

    <!-- Page level plugins -->
    <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
    <script>
        $('#product-dataTable').DataTable({
            "scrollX": false,
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": [10, 11, 20]
                }
            ]
        });

        // Sweet alert
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e){
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                e.preventDefault();
                swal({
                    title: "Êtes-vous sûr ?",
                    text: "Une fois supprimé, vous ne pourrez plus récupérer ces données !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    } else {
                        swal("Vos données sont en sécurité !");
                    }
                });
            });
        });
    </script>
@endpush
