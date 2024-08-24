@extends('backend.layouts.master')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Edit Product Option</h5>
        <div class="card-body">
            <form method="post" action="{{ route('product-options.update', $productOption->id) }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="name">Option Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $productOption->name }}" required>
                </div>

                <div class="form-group">
                    <label for="type">Option Type <span class="text-danger">*</span></label>
                    <input type="text" name="type" id="type" class="form-control" value="{{ $productOption->type }}" required>
                </div>

                <div class="form-group">
                    <label for="is_boolean">Is Boolean</label>
                    <input type="checkbox" name="is_boolean" id="is_boolean" value="1" {{ $productOption->is_boolean ? 'checked' : '' }}>
                </div>

                <div class="form-group" id="value-group" style="{{ $productOption->is_boolean ? 'display:none;' : '' }}">
                    <label for="value">Option Values</label>
                    <textarea id="value" name="value" placeholder="Enter option values, separated by commas" class="form-control">{{ $productOption->value }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('is_boolean').addEventListener('change', function () {
            var valueGroup = document.getElementById('value-group');
            valueGroup.style.display = this.checked ? 'none' : 'block';
        });
    </script>


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

            $('#description').summernote({
                placeholder: "Write detail Description.....",
                tabsize: 2,
                height: 150
            });

            var child_cat_id = '{{ isset($product) ? $product->child_cat_id : '' }}';
            $('#cat_id').change(function() {
                var cat_id = $(this).val();

                if (cat_id != null) {
                    // ajax call
                    $.ajax({
                        url: "/admin/category/" + cat_id + "/child",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (typeof(response) != 'object') {
                                response = $.parseJSON(response);
                            }
                            var html_option = "<option value=''>--Select any one--</option>";
                            if (response.status) {
                                var data = response.data;
                                if (data) {
                                    $('#child_cat_div').removeClass('d-none');
                                    $.each(data, function(id, title) {
                                        html_option += "<option value='" + id + "' " + (child_cat_id == id ? 'selected ' : '') + ">" + title + "</option>";
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

            if (child_cat_id != null) {
                $('#cat_id').change();
            }

            // Handle dynamic options for create and edit views
            let optionIndex = {{ isset($product) && $product->options ? count($product->options) : 1 }};

            function addOptionRow(option = {}) {
                $('#options-container').append(`
                <div class="option-row mb-3">
                    <select name="options[${optionIndex}][name]" class="form-control mb-2">
                        <option value="">Select Option</option>
                        @foreach($options as $opt)
                <option value="{{ $opt->name }}" ${option.name === "{{ $opt->name }}" ? 'selected' : ''}>{{ $opt->name }}</option>
                        @endforeach
                </select>
                <input type="text" name="options[${optionIndex}][value]" class="form-control mb-2" placeholder="Option Value" value="${option.value || ''}">
                    <button type="button" class="btn btn-danger remove-option">Remove</button>
                </div>
            `);
                optionIndex++;
            }

            @if(isset($product) && $product->options)
            @foreach($product->options as $option)
            addOptionRow({ name: "{{ $option->name }}", value: "{{ $option->value }}" });
            @endforeach
            @endif

            $('#add-option').click(function () {
                addOptionRow();
            });

            $(document).on('click', '.remove-option', function () {
                $(this).closest('.option-row').remove();
            });
        });
    </script>

@endpush
