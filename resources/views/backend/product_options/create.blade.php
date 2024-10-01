@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Add Product Option</h5>
        <div class="card-body">
            <form method="post" action="{{ route('product-options.store') }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name">Option Name <span class="text-danger">*</span></label>
                    <input id="name" type="text" name="name" placeholder="Enter option name" value="{{ old('name') }}" class="form-control">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type">Option Type <span class="text-danger">*</span></label>
                    <input id="type" type="text" name="type" placeholder="Enter option type" value="{{ old('type') }}" class="form-control">
                    @error('type')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="is_boolean">Is Boolean?</label>
                    <input type="checkbox" name="is_boolean" id="is_boolean" value="1" {{ old('is_boolean') ? 'checked' : '' }}>
                </div>

                <div class="form-group" id="value-group">
                    <label for="value">Option Values <span class="text-danger">*</span></label>
                    <textarea id="value" name="value" placeholder="Enter option values, separated by commas" class="form-control">{{ old('value') }}</textarea>
                    @error('value')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isBooleanCheckbox = document.getElementById('is_boolean');
            const valueGroup = document.getElementById('value-group');
            const valueInput = document.getElementById('value');

            function toggleValueField() {
                if (isBooleanCheckbox.checked) {
                    valueGroup.style.display = 'none'; // Hide value input when boolean is selected
                    valueInput.value = ''; // Clear the value input when hidden
                } else {
                    valueGroup.style.display = 'block'; // Show value input otherwise
                }
            }

            isBooleanCheckbox.addEventListener('change', toggleValueField);
            toggleValueField(); // Initial check
        });
    </script>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
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

        $('#cat_id').change(function() {
            var cat_id = $(this).val();
            if (cat_id != null) {
                $.ajax({
                    url: "/admin/category/" + cat_id + "/child",
                    data: {
                        _token: "{{ csrf_token() }}",
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
    </script>
@endpush
