@extends('backend.layouts.master')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Ajouter un produit</h5>
        <div class="card-body">
            <form method="post" action="{{route('product.store')}}">
                {{csrf_field()}}

                <!-- Champ Titre -->
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Titre <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Entrer le titre" value="{{old('title')}}"
                           class="form-control">
                    @error('title')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Champ Résumé -->
                <div class="form-group">
                    <label for="summary" class="col-form-label">Résumé <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="summary" name="summary">{{old('summary')}}</textarea>
                    @error('summary')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Champ Description -->
                <div class="form-group">
                    <label for="description" class="col-form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
                    @error('description')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Code Produit -->
                <div class="form-group">
                    <label for="code" class="col-form-label">Code Produit <span class="text-danger">*</span></label>
                    <input id="code" type="text" name="code" placeholder="Entrer le code produit" value="{{old('code')}}"
                           class="form-control">
                    @error('code')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Champ Marque -->
                <div class="form-group">
                    <label for="brand" class="col-form-label">Marque <span class="text-danger">*</span></label>
                    <input id="brand" type="text" name="brand" placeholder="Entrer la marque du produit"
                           value="{{old('brand')}}" class="form-control">
                    @error('brand')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Champ Modèle -->
                <div class="form-group">
                    <label for="model" class="col-form-label">Modèle <span class="text-danger">*</span></label>
                    <input id="model" type="text" name="model" placeholder="Entrer le modèle du produit"
                           value="{{old('model')}}" class="form-control">
                    @error('model')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Champ Mis en Avant -->
                <div class="form-group">
                    <label for="is_featured">Mis en Avant</label><br>
                    <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Oui
                </div>

                <!-- Indices de vitesse et charge -->
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="speed_index" class="col-form-label">Indice de Vitesse <span class="text-danger">*</span></label>
                        <input id="speed_index" type="text" name="speed_index" placeholder="Entrer l'indice de vitesse"
                               value="{{old('speed_index')}}" class="form-control">
                        @error('speed_index')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="load_index" class="col-form-label">Indice de Charge <span class="text-danger">*</span></label>
                        <input id="load_index" type="text" name="load_index" placeholder="Entrer l'indice de charge"
                               value="{{old('load_index')}}" class="form-control">
                        @error('load_index')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <!-- Options de pneumatique -->
                <div class="form-group  row">
                    <div class="col-md-4">
                        <label for="extra_load" class="col-form-label">Charge Supplémentaire</label>
                        <input type="checkbox" name='extra_load' id='extra_load' value='1' checked> Oui
                    </div>
                    <div class="col-md-4">
                        <label for="pneu_renforce" class="col-form-label">Pneu Renforcé</label>
                        <input type="checkbox" name='pneu_renforce' id='pneu_renforce' value='1' checked> Oui
                    </div>
                    <div class="col-md-4">
                        <label for="runflat" class="col-form-label">Flancs Porteurs (Runflat)</label>
                        <input type="checkbox" name='runflat' id='runflat' value='1' checked> Oui
                    </div>
                </div>

                <!-- Largeur, Hauteur, Diamètre -->
                <div class="form-group">
                    <label for="width" class="col-form-label">Largeur (mm) <span class="text-danger">*</span></label>
                    <input id="width" type="number" name="width" placeholder="Entrer la largeur" value="{{old('width')}}"
                           class="form-control">
                    @error('width')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="aspect_ratio" class="col-form-label">Ratio d'Aspect <span
                            class="text-danger">*</span></label>
                    <input id="aspect_ratio" type="number" name="aspect_ratio" placeholder="Entrer le ratio d'aspect"
                           value="{{old('aspect_ratio')}}" class="form-control">
                    @error('aspect_ratio')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="diameter" class="col-form-label">Diamètre (pouces) <span
                            class="text-danger">*</span></label>
                    <input id="diameter" type="number" name="diameter" placeholder="Entrer le diamètre"
                           value="{{old('diameter')}}" class="form-control">
                    @error('diameter')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Catégorie et Sous-Catégorie -->
                <div class="form-group">
                    <label for="cat_id">Catégorie <span class="text-danger">*</span></label>
                    <select name="cat_id" id="cat_id" class="form-control">
                        <option value="">--Sélectionnez une catégorie--</option>
                        @foreach($categories as $key=>$cat_data)
                            <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
                        @endforeach
                    </select>
                    @error('cat_id')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group d-none" id="child_cat_div">
                    <label for="child_cat_id">Sous-catégorie</label>
                    <select name="child_cat_id" id="child_cat_id" class="form-control">
                        <option value="">--Sélectionnez une sous-catégorie--</option>
                    </select>
                    @error('child_cat_id')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Prix et Remise -->
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="price" class="col-form-label">Prix (NRS) <span class="text-danger">*</span></label>
                        <input id="price" type="number" name="price" placeholder="Entrer le prix" value="{{old('price')}}"
                               class="form-control">
                        @error('price')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="discount" class="col-form-label">Remise (%)</label>
                        <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Entrer la remise"
                               value="{{old('discount')}}" class="form-control">
                        @error('discount')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <!-- Sélection voiture, État -->
                <div class="form-group">
                    <label for="brand_id">Voiture</label>
                    <select name="brand_id" class="form-control">
                        <option value="">--Sélectionnez une voiture--</option>
                        @foreach($brands as $brand)
                            <option
                                value="{{$brand->id}}">{{$brand->car_brand . ' ' . $brand->car_model . ' ' . $brand->car_year}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Option Selection Field (from brands table) -->
                <div class="form-group">
                    <label for="option" class="col-form-label">Option <span class="text-danger">*</span></label>
                    <select name="option" id="option" class="form-control">
                        <option value="">--Sélectionnez une option--</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->option }}" {{ $brand->option == $brand->option ? 'selected' : '' }}>
                                {{ $brand->option }}
                            </option>
                        @endforeach
                    </select>
                    @error('option')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="condition">État</label>
                    <select name="condition" class="form-control">
                        <option value="">--Sélectionnez un état--</option>
                        <option value="default">Par défaut</option>
                        <option value="new">Neuf</option>
                        <option value="hot">Populaire</option>
                    </select>
                </div>

                <!-- Quantité -->
                <div class="form-group">
                    <label for="stock">Quantité <span class="text-danger">*</span></label>
                    <input id="quantity" type="number" name="stock" min="0" placeholder="Entrer la quantité"
                           value="{{old('stock')}}" class="form-control">
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
                                <i class="fa fa-picture-o"></i> Choisir
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
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
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Type de Service -->
                <div class="form-group">
                    <label for="service_type" class="col-form-label">Type de Service <span class="text-danger">*</span></label>
                    <select name="service_type" class="form-control">
                        <option value="normal" {{ old('service_type') == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="express" {{ old('service_type') == 'express' ? 'selected' : '' }}>Express</option>
                    </select>
                    @error('service_type')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Poids d'Expédition -->
                <div class="form-group">
                    <label for ="shipping_weight" class="col-form-label">Poids d'Expédition <span class="text-danger">*</span></label>
                    <input id="shipping_weight" type="number" name="shipping_weight" placeholder="Entrer le poids d'expédition" value="{{ old('shipping_weight') }}" class="form-control">
                    @error('shipping_weight')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Saison -->
                <div class="form-group">
                    <label for="season" class="col-form-label">Saison <span class="text-danger">*</span></label>
                    <select name="season" class="form-control">
                        <option value="summer" {{ old('season') == 'summer' ? 'selected' : '' }}>Été</option>
                        <option value="all-season" {{ old('season') == 'all-season' ? 'selected' : '' }}>Toutes saisons</option>
                        <option value="winter" {{ old('season') == 'winter' ? 'selected' : '' }}>Hiver</option>
                    </select>
                    @error('season')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <!-- Boutons -->
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
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>
    <style>
        .btn-secondary[disabled] {
            pointer-events: none;
            opacity: 0.6;
        }

    </style>
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function () {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 100
            });
        });

        $(document).ready(function () {
            $('#description').summernote({
                placeholder: "Write detail description.....",
                tabsize: 2,
                height: 150
            });
        });

        $('#cat_id').change(function () {
            var cat_id = $(this).val();
            if (cat_id != null) {
                $.ajax({
                    url: "/admin/category/" + cat_id + "/child",
                    data: {
                        _token: "{{csrf_token()}}",
                        id: cat_id
                    },
                    type: "POST",
                    success: function (response) {
                        if (typeof (response) != 'object') {
                            response = $.parseJSON(response)
                        }
                        var html_option = "<option value=''>----Select sub category----</option>"
                        if (response.status) {
                            var data = response.data;
                            if (data) {
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data, function (id, title) {
                                    html_option += "<option value='" + id + "'>" + title + "</option>"
                                });
                            }
                        } else {
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);
                    }
                });
            }
        });

        $(document).ready(function () {
            let optionIndex = 1;

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

                // Find the corresponding value input
                let valueInput = $(this).closest('.option-row').find('.option-value');

                // If the option is of type boolean, hide the value input
                if (optionType === 'boolean') {
                    valueInput.val('1'); // Set a default value if needed
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
    <script>

        $(document).ready(function() {
            let optionIndex = 1;

            // Add new option row
            $('#add-option').off('click').on('click', function () {
                $('#options-container').append(`
            <div class="option-row mb-3">
                <select name="options[${optionIndex}][id]" class="form-control mb-2 option-select">
                    <option value="">--Select Option--</option>
                    @foreach($options as $option)
                <option value="{{ $option->id }}" data-is-boolean="{{ $option->is_boolean }}">{{ $option->name }}</option>
                    @endforeach
                </select>
                <input type="text" name="options[${optionIndex}][value]" class="form-control mb-2 option-value" placeholder="Enter Option Value">
                <button type="button" class="btn btn-danger remove-option">Remove</button>
            </div>
        `);
                optionIndex++;
            });

            // Handle option type change
            $(document).on('change', '.option-select', function () {
                let selectedOption = $(this).find('option:selected');
                let isBoolean = selectedOption.data('is-boolean');  // Get the data-is-boolean attribute of the selected option

                // Find the corresponding value input
                let valueInput = $(this).closest('.option-row').find('.option-value');

                // If the option is boolean, hide the value input and set value to 1
                if (isBoolean === 1) {  // Checking if is_boolean is true
                    valueInput.val('1');  // Set value to 1 for boolean options
                    valueInput.hide();    // Hide the input field
                } else {
                    valueInput.val('');   // Clear the value if not boolean
                    valueInput.show();    // Show the input field for non-boolean
                }
            });

            // Remove an option row but ensure that at least one option remains
            $(document).on('click', '.remove-option', function () {
                const optionRows = $('.option-row');

                // If more than one option-row, remove the selected row
                if (optionRows.length > 1) {
                    $(this).closest('.option-row').remove();
                }

                // After removing an option, ensure the last option's "Remove" button is disabled
                toggleRemoveButtons();
            });

            // Disable "Remove" button for the last remaining option row
            function toggleRemoveButtons() {
                const optionRows = $('.option-row');

                // If there is only one option-row, disable the "Remove" button and change its style
                if (optionRows.length === 1) {
                    optionRows.find('.remove-option').attr('disabled', true).removeClass('btn-danger').addClass('btn-secondary');
                } else {
                    // Enable the "Remove" button for all option-rows and restore its original style
                    optionRows.find('.remove-option').attr('disabled', false).removeClass('btn-secondary').addClass('btn-danger');
                }
            }

            // Initialize the buttons on page load
            toggleRemoveButtons();
        });

    </script>
@endpush
