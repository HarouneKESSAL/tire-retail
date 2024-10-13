@extends('backend.layouts.master')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Modifier le produit</h5>
        <div class="card-body">
            <form method="post" action="{{route('product.update',$product->id)}}">
                @csrf
                @method('PATCH')

                <!-- Champ Titre -->
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Titre <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Entrer le titre" value="{{$product->title}}" class="form-control">
                    @error('title')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Champ Résumé -->
                <div class="form-group">
                    <label for="summary" class="col-form-label">Résumé <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="summary" name="summary">{{$product->summary}}</textarea>
                    @error('summary')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Champ Description -->
                <div class="form-group">
                    <label for="description" class="col-form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{$product->description}}</textarea>
                    @error('description')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Champ Code -->
                <div class="form-group">
                    <label for="code" class="col-form-label">Code <span class="text-danger">*</span></label>
                    <input id="code" type="text" name="code" placeholder="Entrer le code produit" value="{{$product->code}}" class="form-control">
                    @error('code')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Champ Marque -->
                <div class="form-group">
                    <label for="brand" class="col-form-label">Marque <span class="text-danger">*</span></label>
                    <input id="brand" type="text" name="brand" placeholder="Entrer la marque du produit" value="{{$product->brand}}" class="form-control">
                    @error('brand')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Champ Modèle -->
                <div class="form-group">
                    <label for="model" class="col-form-label">Modèle <span class="text-danger">*</span></label>
                    <input id="model" type="text" name="model" placeholder="Entrer le modèle du produit" value="{{$product->model}}" class="form-control">
                    @error('model')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Champ Mis en Avant -->
                <div class="form-group">
                    <label for="is_featured">Mis en Avant</label><br>
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}> Oui
                </div>

                <!-- Catégorie -->
                <div class="form-group">
                    <label for="cat_id">Catégorie <span class="text-danger">*</span></label>
                    <select name="cat_id" id="cat_id" class="form-control">
                        <option value="">--Sélectionnez une catégorie--</option>
                        @foreach($categories as $key=>$cat_data)
                            <option value='{{$cat_data->id}}' {{ $product->cat_id == $cat_data->id ? 'selected' : '' }}>{{$cat_data->title}}</option>
                        @endforeach
                    </select>
                    @error('cat_id')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Largeur, Hauteur, Diamètre -->
                <div class="form-group">
                    <label for="width" class="col-form-label">Largeur (mm) <span class="text-danger">*</span></label>
                    <input id="width" type="number" name="width" placeholder="Entrer la largeur" value="{{$product->width}}" class="form-control">
                    @error('width')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="aspect_ratio" class="col-form-label">Ratio d'Aspect <span class="text-danger">*</span></label>
                    <input id="aspect_ratio" type="number" name="aspect_ratio" placeholder="Entrer le ratio d'aspect" value="{{$product->aspect_ratio}}" class="form-control">
                    @error('aspect_ratio')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="diameter" class="col-form-label">Diamètre (pouces) <span class="text-danger">*</span></label>
                    <input id="diameter" type="number" name="diameter" placeholder="Entrer le diamètre" value="{{$product->diameter}}" class="form-control">
                    @error('diameter')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Indices de vitesse et charge -->
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="speed_index" class="col-form-label">Indice de Vitesse <span class="text-danger">*</span></label>
                        <input id="speed_index" type="text" name="speed_index" placeholder="Entrer l'indice de vitesse" value="{{$product->speed_index}}" class="form-control">
                        @error('speed_index')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="load_index" class="col-form-label">Indice de Charge <span class="text-danger">*</span></label>
                        <input id="load_index" type="text" name="load_index" placeholder="Entrer l'indice de charge" value="{{$product->load_index}}" class="form-control">
                        @error('load_index')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <!-- Options de pneumatique -->
                <div class="form-group  row">
                    <div class="col-md-4">
                        <label for="extra_load" class="col-form-label">Charge Supplémentaire</label>
                        <input type="checkbox" name='extra_load' id='extra_load' value='1' {{ $product->extra_load ? 'checked' : '' }}> Oui
                    </div>
                    <div class="col-md-4">
                        <label for="pneu_renforce" class="col-form-label">Pneu Renforcé</label>
                        <input type="checkbox" name='pneu_renforce' id='pneu_renforce' value='1' {{ $product->pneu_renforce ? 'checked' : '' }}> Oui
                    </div>
                    <div class="col-md-4">
                        <label for="runflat" class="col-form-label">Flancs Porteurs (Runflat)</label>
                        <input type="checkbox" name='runflat' id='runflat' value='1' {{ $product->runflat ? 'checked' : '' }}> Oui
                    </div>
                </div>

                <!-- Prix et Remise -->
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="price" class="col-form-label">Prix (NRS) <span class="text-danger">*</span></label>
                        <input id="price" type="number" name="price" placeholder="Entrer le prix" value="{{$product->price}}" class="form-control">
                        @error('price')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="discount" class="col-form-label">Remise (%)</label>
                        <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Entrer la remise" value="{{$product->discount}}" class="form-control">
                        @error('discount')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <!-- Sélection voiture -->
                <div class="form-group">
                    <label for="brand_id">Voiture</label>
                    <select name="brand_id" class="form-control">
                        <option value="">--Sélectionnez une voiture--</option>
                        @foreach($brands as $brand)
                            <option value="{{$brand->id}}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{$brand->car_brand . ' ' . $brand->car_model . ' ' . $brand->car_year}}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Option Selection Field (from brands table) -->
                <div class="form-group">
                    <label for="option" class="col-form-label">Option <span class="text-danger">*</span></label>
                    <select name="option" id="option" class="form-control">
                        <option value="">--Sélectionnez une option--</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->option }}" {{ $product->option == $brand->option ? 'selected' : '' }}>
                                {{ $brand->option }}
                            </option>
                        @endforeach
                    </select>
                    @error('option')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Condition -->
                <div class="form-group">
                    <label for="condition">État</label>
                    <select name="condition" class="form-control">
                        <option value="">--Sélectionnez un état--</option>
                        <option value="default" {{ $product->condition == 'default' ? 'selected' : '' }}>Par défaut</option>
                        <option value="new" {{ $product->condition == 'new' ? 'selected' : '' }}>Neuf</option>
                        <option value="hot" {{ $product->condition == 'hot' ? 'selected' : '' }}>Populaire</option>
                    </select>
                </div>

                <!-- Quantité -->
                <div class="form-group">
                    <label for="stock">Quantité <span class="text-danger">*</span></label>
                    <input id="quantity" type="number" name="stock" min="0" placeholder="Entrer la quantité" value="{{$product->stock}}" class="form-control">
                    @error('stock')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Photo -->
                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-image"></i> Choisir
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$product->photo}}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    @error('photo')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Statut -->
                <div class="form-group">
                    <label for="status" class="col-form-label">Statut <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactif</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Type de Service et Poids d'Expédition -->
                <div class="form-group mb-3">
                    <label for="service_type" class="col-form-label">Type de Service <span class="text-danger">*</span></label>
                    <select name="service_type" class="form-control">
                        <option value="tire" {{ $product->service_type == 'tire' ? 'selected' : '' }}>Pneu</option>
                        <option value="rim" {{ $product->service_type == 'rim' ? 'selected' : '' }}>Jante</option>
                        <option value="both" {{ $product->service_type == 'both' ? 'selected' : '' }}>Les deux</option>
                    </select>
                    @error('service_type')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="shipping_weight" class="col-form-label">Poids d'Expédition <span class="text-danger">*</span></label>
                    <input id="shipping_weight" type="number" name="shipping_weight" placeholder="Entrer le poids d'expédition" value="{{$product->shipping_weight}}" class="form-control">
                    @error('shipping_weight')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Saison -->
                <div class="form-group">
                    <label for="season" class="col-form-label">Saison <span class="text-danger">*</span></label>
                    <select name="season" class="form-control">
                        <option value="summer" {{ $product->season == 'summer' ? 'selected' : '' }}>Été</option>
                        <option value="all-season" {{ $product->season == 'all-season' ? 'selected' : '' }}>Toutes saisons</option>
                        <option value="winter" {{ $product->season == 'winter' ? 'selected' : '' }}>Hiver</option>
                    </select>
                    @error('season')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Bouton de soumission -->
                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">Mettre à jour</button>
                </div>

            </form>
        </div>

    </div>

@endsection


@push('styles')
    <link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write detail Description.....",
                tabsize: 2,
                height: 150
            });
        });

        var  child_cat_id='{{$product->child_cat_id}}';
        $('#cat_id').change(function(){
            var cat_id=$(this).val();

            if(cat_id !=null){
                // ajax call
                $.ajax({
                    url:"/admin/category/"+cat_id+"/child",
                    type:"POST",
                    data:{
                        _token:"{{csrf_token()}}"
                    },
                    success:function(response){
                        if(typeof(response)!='object'){
                            response=$.parseJSON(response);
                        }
                        var html_option="<option value=''>--Select any one--</option>";
                        if(response.status){
                            var data=response.data;
                            if(response.data){
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data,function(id,title){
                                    html_option += "<option value='"+id+"' "+(child_cat_id==id ? 'selected ' : '')+">"+title+"</option>";
                                });
                            }
                        }
                        else{
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);

                    }
                });
            }
        });
        if(child_cat_id!=null){
            $('#cat_id').change();
        }



    </script>
    <script>
        $(document).ready(function() {
            let optionIndex = {{ count($product->options) }};

            $('#add-option').click(function () {
                $('#options-container').append(`
                <div class="option-row mb-3">
                    <select name="options[${optionIndex}][option_id]" class="form-control mb-2 option-select">
                        <option value="">--Select Option--</option>
                        @foreach($options as $option)
                <option value="{{ $option->id }}" data-type="{{ $option->type }}">{{ $option->name }}</option>
                        @endforeach
                </select>
                <input type="text" name="options[${optionIndex}][value]" class="form-control mb-2 option-value" placeholder="Enter Option Value">
                    <button type="button" class="btn btn-danger remove-option">Remove</button>
                </div>
            `);
                optionIndex++;
            });

            $(document).on('change', '.option-select', function () {
                let selectedOption = $(this).find('option:selected');
                let optionType = selectedOption.data('type');

                let valueInput = $(this).closest('.option-row').find('.option-value');

                if (optionType === 'boolean') {
                    valueInput.val('1');
                    valueInput.hide();
                } else {
                    valueInput.show();
                }
            });

            $(document).on('click', '.remove-option', function () {
                $(this).closest('.option-row').remove();
            });
        });
    </script>

@endpush
