@extends('backend.layouts.master')
@section('title','E-SHOP || Brand Create')
@section('main-content')

    <div class="card">
        <h5 class="card-header">Add Car</h5>
        <div class="card-body">
            <form method="post" action="{{route('brand.store')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="car_brand" class="col-form-label">Car Brand <span class="text-danger">*</span></label>
                    <input id="car_brand" type="text" name="car_brand" placeholder="Enter car brand" value="{{old('car_brand')}}" class="form-control">
                    @error('car_brand')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="car_model" class="col-form-label">Car Model <span class="text-danger">*</span></label>
                    <input id="car_model" type="text" name="car_model" placeholder="Enter car model" value="{{old('car_model')}}" class="form-control">
                    @error('car_model')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="car_year" class="col-form-label">Car Year <span class="text-danger">*</span></label>
                    <input id="car_year" type="number" name="car_year" placeholder="Enter car year" value="{{old('car_year')}}" class="form-control">
                    @error('car_year')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
