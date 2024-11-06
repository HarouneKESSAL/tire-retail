@extends('backend.layouts.master')
@section('title','E-SHOP || Page Voitures')
@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger float-left">Liste des Voitures</h6>
            <a href="{{route('brand.create')}}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Ajouter une voiture"><i class="fas fa-plus"></i> Ajouter Voiture</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if(count($brands)>0)
                    <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>N°</th>
                            <th>Informations sur la Voiture</th>
                            <th>Option</th>
                            <th>Slug</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>N°</th>
                            <th>Informations sur la Voiture</th>
                            <th>Option</th>
                            <th>Slug</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($brands as $brand)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$brand->car_name}}</td>
                                <td>{{$brand->option}}</td>
                                <td>{{$brand->slug}}</td>
                                <td>
                                    @if($brand->status=='active')
                                        <span class="badge badge-success">{{$brand->status}}</span>
                                    @else
                                        <span class="badge badge-warning">{{$brand->status}}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('brand.edit',$brand->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="modifier" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{route('brand.destroy',[$brand->id])}}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm dltBtn" data-id={{$brand->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Supprimer"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <span style="float:right">{{$brands->links('vendor.pagination.custom-pagination')}}</span>

                @else
                    <h6 class="text-center">Aucune voiture trouvée !!! Veuillez créer une voiture</h6>
                @endif
            </div>
        </div>
    </div>
@endsection


@push('styles')
    <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        .text-primary {
            color: #8B0000 !important;
        }

        .btn-red {
            background-color: #8B0000 !important;
            border-color: #8B0000 !important;
        }

        .btn-red:hover {
            background-color: #6A0000 !important; /* Darker shade for hover */
            border-color: #6A0000 !important;
        }
        div.dataTables_wrapper div.dataTables_paginate{
            display: none;
        }
        .zoom {
            transition: transform .2s; /* Animation */
        }

        .zoom:hover {
            transform: scale(3.2);
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
        $('#banner-dataTable').DataTable({
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": [3, 4]
                }
            ]
        });

        // Sweet alert
        function deleteData(id) {}

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
            })
        })
    </script>
@endpush
