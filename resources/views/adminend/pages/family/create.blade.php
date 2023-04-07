@extends('adminend.layouts.default')
@section('title', 'Families')
@section('content')
<section class="">
    <div class="container">
        <div class="my-16 lg:w-2/3 xl:w-2/3 mx-auto">
            <div class="card shadow">
                <div class="body p-4">
                    <form action="{{ route('admin.families.store') }}" method="POST">
                        @csrf

                        <div class="flex space-x-4 w-full">
                            <div class="form-item w-1/3">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item flex-1">
                                <label class="form-label">Description</label>
                                <input type="text" value="{{ old('description') }}" name="description" class="form-input" />
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-lg">Attributes</span>
                                <button class="repeater-add btn" type="button">Add New</button>
                            </div>
                            <div class="repeater-list overflow-y-auto -mx-4"></div>
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
                                                    @foreach ($inputTypes as $type)
                                                        <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                                                    @endforeach
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
                                                <label class="form-label">Filterable</label>
                                                <select name="attributes[index][filterable]" id="">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="form-item flex-1">
                                                <label class="form-label">Value Cast</label>
                                                <select name="attributes[index][value_cast]" id="">
                                                    @foreach ($valueCasts as $cast)
                                                    <option value="{{ $cast['value'] }}">{{ $cast['label'] }}</option>
                                                    @endforeach
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
                            <button type="submit" class="btn btn-primary">Create</button>
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
    let index = 0;
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
