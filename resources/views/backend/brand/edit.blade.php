@extends('backend.layouts.master')
@section('title','E-SHOP || Modifier Voiture')
@section('main-content')

    <div class="card">
        <h5 class="card-header">Modifier Voiture</h5>
        <div class="card-body">
            <form method="post" action="{{route('brand.update', $brand->id)}}">
                {{csrf_field()}}
                @method('PATCH')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Titre <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Entrez le titre" value="{{old('title', $brand->title)}}" class="form-control">
                    @error('title')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputCarBrand" class="col-form-label">Marque de Voiture <span class="text-danger">*</span></label>
                    <input id="inputCarBrand" type="text" name="car_brand" placeholder="Entrez la marque de la voiture" value="{{old('car_brand', $brand->car_brand)}}" class="form-control">
                    @error('car_brand')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputCarModel" class="col-form-label">Modèle de Voiture <span class="text-danger">*</span></label>
                    <input id="inputCarModel" type="text" name="car_model" placeholder="Entrez le modèle de la voiture" value="{{old('car_model', $brand->car_model)}}" class="form-control">
                    @error('car_model')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputCarYear" class="col-form-label">Année de la Voiture <span class="text-danger">*</span></label>
                    <input id="inputCarYear" type="number" name="car_year" placeholder="Entrez l'année de la voiture" value="{{old('car_year', $brand->car_year)}}" class="form-control">
                    @error('car_year')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="option" class="col-form-label">Option</label>
                    <input id="option" type="text" name="option" placeholder="Entrez l'option" value="{{ old('option', $brand->option) }}" class="form-control">
                    @error('option')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="col-form-label">Statut <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $brand->status == 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ $brand->status == 'inactive' ? 'selected' : '' }}>Inactif</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Réinitialiser</button>
                    <button class="btn btn-success" type="submit">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>

@endsection


@push('styles')
    <link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>
@endpush
