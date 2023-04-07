<div class="ml-5 w-96">
    <form class="needs-validation" action="{{ route('admin.products.store') }}" method="POST" novalidate>
        @csrf

        @if (Session::has('success'))
            <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
                <div class="bg-success me-3 icon-item">
                    <span class="fas fa-check-circle text-white fs-3"></span>
                </div>
                <p class="mb-0 flex-1">{{ Session::get('message') }}</p>
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="form-input model-search my-3" data-api-url="/api/test" data-searchkey-min="3" data-loading-msg="Loading ...">
            <label class="form-label" for="">Search Product</label>
            <input type="hidden" name="" value="" class="model-value-input form-control" />
            <input value="" class="search-box form-control" />
            <div class="search-result d-none">
                <div class="loading">
                    <span>Loading ...</span>
                </div>
                <ul class="list"></ul>
            </div>
        </div>

        <div class="d-flex flex-row-reverse">
            <button class="btn btn-falcon-primary" type="submit">Submit</button>
        </div>

    </form>
</div>
