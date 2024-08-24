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
            <h6 class="m-0 font-weight-bold text-danger float-left">Option Lists</h6>
            <a href="{{ route('product-options.create') }}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add Option"><i class="fas fa-plus"></i> Add Option</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if(count($options) > 0)
                    <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Values</th>
                            <th>Is Boolean</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($options as $option)
                            <tr>
                                <td>{{ $option->id }}</td>
                                <td>{{ $option->name }}</td>
                                <td>{{ $option->type }}</td>
                                <td>{{ $option->is_boolean ? 'N/A' : $option->value }}</td>
                                <td>{{ $option->is_boolean ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('product-options.edit', $option->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('product-options.destroy', $option->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h6 class="text-center">No Options found!!! Please create an Option</h6>
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
            });
        });
    </script>
@endpush