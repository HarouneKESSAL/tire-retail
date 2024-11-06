@extends('backend.layouts.master')
@section('title','E-SHOP || Ajouter Voiture')
@section('main-content')

    <div class="card">
        <h5 class="card-header">Ajouter Voiture</h5>
        <div class="card-body">
            <form method="post" action="{{route('brand.store')}}">
                {{csrf_field()}}

                <div class="form-group ">
                    <label for="car_name" class="col-sm-3 col-form-label">Nom de la Voiture <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="car_name" name="car_name" placeholder="Entrez le nom de la voiture" value="{{old('car_name')}}">
                        @error('car_name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                </div>
                <div class="form-group">
                    <label for="car_brand" class="col-form-label">Marque de Voiture <span class="text-danger">*</span></label>
                    <input id="car_brand" type="text" name="car_brand" placeholder="Entrez la marque de la voiture" value="{{old('car_brand')}}" class="form-control">
                    @error('car_brand')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="car_model" class="col-form-label">Modèle de Voiture <span class="text-danger">*</span></label>
                    <input id="car_model" type="text" name="car_model" placeholder="Entrez le modèle de la voiture" value="{{old('car_model')}}" class="form-control">
                    @error('car_model')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="car_year" class="col-form-label">Année de la Voiture <span class="text-danger">*</span></label>
                    <input id="car_year" type="number" name="car_year" placeholder="Entrez l'année de la voiture" value="{{old('car_year')}}" class="form-control">
                    @error('car_year')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="option" class="col-form-label">Option <span class="text-danger">*</span></label>
                    <input id="option" type="text" name="option" placeholder="Entrez l'option" value="{{ old('option') }}" class="form-control">
                    @error('option')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="col-form-label">Statut <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Réinitialiser</button>
                    <button class="btn btn-success" type="submit">Soumettre</button>
                </div>

            </form>
        </div>
    </div>

@endsection
