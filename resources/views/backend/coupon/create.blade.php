@extends('backend.layouts.master')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Ajouter un Coupon</h5>
        <div class="card-body">
            <form method="post" action="{{route('coupon.store')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Code du Coupon <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="code" placeholder="Entrez le code du coupon"  value="{{old('code')}}" class="form-control">
                    @error('code')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type" class="col-form-label">Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-control">
                        <option value="fixed">Fixe</option>
                        <option value="percent">Pourcentage</option>
                    </select>
                    @error('type')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Valeur <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="number" name="value" placeholder="Entrez la valeur du coupon"  value="{{old('value')}}" class="form-control">
                    @error('value')
                    <span class="text-danger">{{$message}}</span>
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
