@extends('adminend.layouts.default')
@section('title', 'Families')
@section('content')
<section class="">
    <div class="container">
        <div class="my-16 lg:w-2/3 xl:w-2/3 mx-auto">
            <div class="card shadow">
                <div class="body p-4">
                    <form action="{{ route('admin.families.update', $family->id) }}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="flex space-x-4 w-full">
                            <div class="form-item w-1/3">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ $family->name }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item flex-1">
                                <label class="form-label">Description</label>
                                <input type="text" value="{{ $family->description }}" name="description" class="form-input" />
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-lg">Attributes</span>
                                <button class="repeater-add btn" type="button">Add New</button>
                            </div>
                            <div class="repeater-list overflow-y-auto -mx-4">
                                @php $i = 0; @endphp
                                @foreach ($family->attributes as $attr)
                                    <div class="repeater-group border-b pb-1 mb-1">
                                        <div class="bg-gray-100 p-4 relative">
                                            <button class="absolute close right-0 top-0 w-8 h-8 bg-gray-300">&times;</button>
                                            <div class="flex space-x-4">
                                                <div class="form-item flex-1">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="attributes[{{ $i }}][name]" class="form-input" value="{{ $attr['name'] }}" />
                                                    @error('name')
                                                        <span class="form-helper error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-item flex-1">
                                                    <label class="form-label">Input Type</label>
                                                    <select name="attributes[{{ $i }}][input_type]" id="">
                                                        @foreach ($inputTypes as $type)
                                                        <option value="{{ $type['value'] }}" {{ $type['value'] === $attr['input_type'] ? "selected" : '' }}>
                                                            {{ $type['label'] }}
                                                        </option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-item flex-1">
                                                    <label class="form-label">Group</label>
                                                    <input type="text" name="attributes[{{ $i }}][group]" class="form-input" value="{{ $attr['attribute_group'] }}" />
                                                </div>
                                            </div>
                                            <div class="flex space-x-4">
                                                <div class="form-item w-32">
                                                    <label class="form-label">Required</label>
                                                    <select name="attributes[{{ $i }}][required]" id="">
                                                        <option value="1" {{ $attr['required'] == 1 ? "selected" : '' }}>Yes</option>
                                                        <option value="0" {{ $attr['required'] == 0 ? "selected" : '' }}>No</option>
                                                    </select>
                                                </div>
                                                <div class="form-item flex-1">
                                                    <label class="form-label">Visible On Front</label>
                                                    <select name="attributes[{{ $i }}][visible_on_front]" id="">
                                                        <option value="1" {{ $attr['visible_on_front'] == 1 ? "selected" : '' }}>Yes</option>
                                                        <option value="0" {{ $attr['visible_on_front'] == 0 ? "selected" : '' }}>No</option>
                                                    </select>
                                                </div>
                                                <div class="form-item flex-1">
                                                    <label class="form-label">Comparable</label>
                                                    <select name="attributes[{{ $i }}][comparable]" id="">
                                                        <option value="1" {{ $attr['comparable'] == 1 ? "selected" : '' }}>Yes</option>
                                                        <option value="0" {{ $attr['comparable'] == 0 ? "selected" : '' }}>No</option>
                                                    </select>
                                                </div>
                                                <div class="form-item flex-1">
                                                    <label class="form-label">Filterable</label>
                                                    <select name="attributes[{{ $i }}][filterable]" id="">
                                                        <option value="1" {{ $attr['filterable'] == 1 ? "selected" : '' }}>Yes</option>
                                                        <option value="0" {{ $attr['filterable'] == 0 ? "selected" : '' }}>No</option>
                                                    </select>
                                                </div>
                                                <div class="form-item flex-1">
                                                    <label class="form-label">Value Cast</label>
                                                    <select name="attributes[{{ $i }}][value_cast]" id="">
                                                        @foreach ($valueCasts as $cast)
                                                        <option value="{{ $cast['value'] }}" {{ $cast['value'] === $attr['value_cast'] ? "selected" : '' }}>
                                                            {{ $cast['label'] }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @php
                                                $optionString = '';
                                                foreach ($attr->options as $opt) {
                                                    if ($optionString) {
                                                        $optionString = "{$optionString},{$opt->label}";
                                                    } else {
                                                        $optionString = "{$opt->label}";
                                                    }
                                                }
                                            @endphp
                                            <div>
                                                <div class="form-item flex-1">
                                                    <label class="form-label">Options</label>
                                                    <input type="text" name="attributes[{{ $i }}][options]" class="form-input" value="{{ $optionString }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php $i++; @endphp
                                @endforeach
                            </div>
                            <div class="repeater-group-template">
                                <div class="repeater-group border-b pb-1 mb-1">
                                    <div class="bg-gray-100 p-4 relative">
                                        <button class="absolute close right-0 top-0 w-8 h-8 bg-gray-300">&times;</button>
                                        <div class="flex space-x-4">
                                            <div class="form-item flex-1">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="attributes[index][name]" class="form-input" />
                                                @error('name')
                                                    <span class="form-helper error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-item flex-1">
                                                <label class="form-label">Input Type</label>
                                                <select name="attributes[index][input_type]" id="">
                                                    <option value="text">Text</option>
                                                    <option value="textarea">Textarea</option>
                                                    <option value="select-single">Select Single</option>
                                                    <option value="select-multiple">Select Multiple</option>
                                                    <option value="checkbox-single">Checkbox Single</option>
                                                    <option value="checkbox-multiple">Checkbox Multiple</option>
                                                </select>
                                            </div>
                                            <div class="form-item flex-1">
                                                <label class="form-label">Group</label>
                                                <input type="text" name="attributes[index][group]" class="form-input" />
                                            </div>
                                        </div>
                                        <div class="flex space-x-4">
                                            <div class="form-item w-32">
                                                <label class="form-label">Required</label>
                                                <select name="attributes[index][required]" id="">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="form-item flex-1">
                                                <label class="form-label">Visible On Front</label>
                                                <select name="attributes[index][visible_on_front]" id="">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="form-item flex-1">
                                                <label class="form-label">Comparable</label>
                                                <select name="attributes[index][comparable]" id="">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="form-item flex-1">
                                                <label class="form-label">Value Cast</label>
                                                <select name="attributes[index][value_cast]" id="">
                                                    <option value="string">String</option>
                                                    <option value="integer">Integer</option>
                                                    <option value="float">Float</option>
                                                    <option value="boolean">Boolean</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-item flex-1">
                                                <label class="form-label">Options</label>
                                                <input type="text" name="attributes[index][options]" class="form-input" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    let index = {{ $i }};
    index = +index;
    $(function () {
        let repeaterTemplate = $('.repeater-group-template').html();
        $('.repeater-group-template').remove();

        $('.repeater-list').on('click', '.repeater-group .close', function () {
            $(this).closest('.repeater-group').remove();
        });

        $('.repeater-add').click(function () {
            let newrepeaterTemplate = repeaterTemplate.replaceAll('[index]', `[${index}]`);
            $('.repeater-list').prepend(newrepeaterTemplate);
            index = index + 1;
        });
    });
</script>
@endpush
