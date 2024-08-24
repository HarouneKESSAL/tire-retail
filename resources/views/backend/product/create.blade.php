@extends('backend.layouts.master')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Add Product</h5>
        <div class="card-body">
            <form method="post" action="{{route('product.store')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{old('title')}}" class="form-control">
                    @error('title')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="summary" class="col-form-label">Summary <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="summary" name="summary">{{old('summary')}}</textarea>
                    @error('summary')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="col-form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
                    @error('description')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="is_featured">Is Featured</label><br>
                    <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Yes
                </div>

                <div class="form-group">
                    <label for="cat_id">Category <span class="text-danger">*</span></label>
                    <select name="cat_id" id="cat_id" class="form-control">
                        <option value="">--Select any category--</option>
                        @foreach($categories as $key=>$cat_data)
                            <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
                        @endforeach
                    </select>
                    @error('cat_id')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group d-none" id="child_cat_div">
                    <label for="child_cat_id">Sub Category</label>
                    <select name="child_cat_id" id="child_cat_id" class="form-control">
                        <option value="">--Select any category--</option>
                    </select>
                    @error('child_cat_id')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Price(NRS) <span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Enter price"  value="{{old('price')}}" class="form-control">
                    @error('price')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="discount" class="col-form-label">Discount(%)</label>
                    <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Enter discount"  value="{{old('discount')}}" class="form-control">
                    @error('discount')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="size">Size</label>
                    <select name="size[]" class="form-control selectpicker"  multiple data-live-search="true">
                        <option value="">--Select any size--</option>
                        <option value="S">Small (S)</option>
                        <option value="M">Medium (M)</option>
                        <option value="L">Large (L)</option>
                        <option value="XL">Extra Large (XL)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="brand_id">Car</label>
                    <select name="brand_id" class="form-control">
                        <option value="">--Select Car--</option>
                        @foreach($brands as $brand)
                            <option value="{{$brand->id}}">{{$brand->car_brand . ' ' . $brand->car_model . ' ' . $brand->car_year}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="condition">Condition</label>
                    <select name="condition" class="form-control">
                        <option value="">--Select Condition--</option>
                        <option value="default">Default</option>
                        <option value="new">New</option>
                        <option value="hot">Hot</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="stock">Quantity <span class="text-danger">*</span></label>
                    <input id="quantity" type="number" name="stock" min="0" placeholder="Enter quantity"  value="{{old('stock')}}" class="form-control">
                    @error('stock')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    @error('photo')
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

                <!-- Tire-specific fields -->
                <div class="form-group">
                    <label for="width" class="col-form-label">Width (mm) <span class="text-danger">*</span></label>
                    <input id="width" type="number" name="width" placeholder="Enter width" value="{{old('width')}}" class="form-control">
                    @error('width')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="aspect_ratio" class="col-form-label">Aspect Ratio <span class="text-danger">*</span></label>
                    <input id="aspect_ratio" type="number" name="aspect_ratio" placeholder="Enter aspect ratio" value="{{old('aspect_ratio')}}" class="form-control">
                    @error('aspect_ratio')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="diameter" class="col-form-label">Diameter (inch) <span class="text-danger">*</span></label>
                    <input id="diameter" type="number" name="diameter" placeholder="Enter diameter" value="{{old('diameter')}}" class="form-control">
                    @error('diameter')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Options</label>
                    <div id="options-container">
                        <div class="option-row mb-3">
                            <select name="options[0][id]" class="form-control mb-2">
                                <option value="">--Select Option--</option>
                                @foreach($options as $option)
                                    <option value="{{ $option->id }}">{{ $option->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="options[0][value]" class="form-control mb-2" placeholder="Enter Option Value">
                            <button type="button" class="btn btn-danger remove-option">Remove</button>
                        </div>
                    </div>
                    <button type="button" id="add-option" class="btn btn-primary">Add Option</button>
                </div>



                <div class="form-group">
                    <label for="season" class="col-form-label">Season <span class="text-danger">*</span></label>
                    <select name="season" class="form-control">
                        <option value="summer" {{ old('season') == 'summer' ? 'selected' : '' }}>Summer</option>
                        <option value="all-season" {{ old('season') == 'all-season' ? 'selected' : '' }}>All-Season</option>
                        <option value="winter" {{ old('season') == 'winter' ? 'selected' : '' }}>Winter</option>
                    </select>
                    @error('season')
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
                height: 100
            });
        });

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write detail description.....",
                tabsize: 2,
                height: 150
            });
        });

        $('#cat_id').change(function(){
            var cat_id = $(this).val();
            if (cat_id != null) {
                $.ajax({
                    url: "/admin/category/" + cat_id + "/child",
                    data: {
                        _token: "{{csrf_token()}}",
                        id: cat_id
                    },
                    type: "POST",
                    success: function(response) {
                        if (typeof(response) != 'object') {
                            response = $.parseJSON(response)
                        }
                        var html_option = "<option value=''>----Select sub category----</option>"
                        if (response.status) {
                            var data = response.data;
                            if (data) {
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data, function(id, title) {
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

        $(document).ready(function() {
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
@endpush
