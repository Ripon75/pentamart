<div class="user-search-box relative">
    <input id="input-user-id" type="hidden" name="user_id" value="0">
    <input id="input-user-phone-number" type="hidden" name="user_phone_number" value="">
    <input id="input-user-search" type="text" name="search_phone_number" value="{{ old('search_phone_number') }}" placeholder="User search and select"class="rounded border form-input w-full">
    <div class="user-search-result hidden bg-white border rounded-b
        absolute left-0 right-0 top-full z-30 shadow-md -mt-1">
        <div class="user-search-list flex flex-col divide-y h-72 overflow-y-auto">
        </div>
    </div>
</div>


@push('scripts')
    <script>
        var searchUserInput      = $('#input-user-search');
        var inputUserId          = $('#input-user-id');
        var inputUserPhoneNumber = $('#input-user-phone-number');
        var userSearchResult     = $('.user-search-result');
        var userSearchResultList = $('.user-search-list');
        var debounceTime         = 750;

        $(function() {
            // If click outside of the model search box hide the search result list
            $(document).click(function(e) {
                var container = $('.user-search-box');
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    userSearchResult.hide();
                }
            });

            searchUserInput.keyup(__debounce(function(e) {
                var key = e.which;
                var phoneNumber = $(this).val();

                if (phoneNumber.length >= 3) {
                    userSearch(phoneNumber);
                    userSearchResult.show();
                }
                if (phoneNumber.length < 3) {
                    userSearchResult.hide();
                }
                // If press Enter key goto the product search page
                // if (key == 13) // the enter key code
                // {
                //     window.location.href = `/products?search_key=${searchKeywords}`;
                // }
            }, debounceTime));

            $('.user-search-list').on('click', '.single-user', function(e) {
                var userId      = $(this).data('user-id');
                var phoneNumber = $(this).data('user-phone-number');
                inputUserId.val(userId);
                searchUserInput.val(phoneNumber);
                inputUserPhoneNumber.val(phoneNumber)
                userSearchResult.hide();
                __userIdOnChangeCallback();
            })
        });

        function userSearch(phoneNumber) {
            axios.get('/api/user/search', {
                params: {
                    phone_number: phoneNumber
                }
            })
            .then((response) => {
                var result = [];
                if (response.data.success) {
                    result = response.data.result;
                    renderUserSearchResult(result)
                }
            })
            .catch((error) => {
                console.log(error);
            });
        }

        function renderUserSearchResult(data) {
            userSearchResultList.html('');
            for(let index = 0; index < data.length; index++) {
                var user = data[index];
                var userHTML = `
                <div class="single-user p-4 hover:bg-gray-100"
                    data-user-id="${user.id}"
                    data-user-phone-number="${user.phone_number}">
                    <div class="flex-1 flex flex-row">
                        <h2 class="text-base text-primary">${user.name}</h2>
                    </div>
                    <div class="">
                        <h2 class="text-sm">${user.email}</h2>
                    </div>
                    <div class="">
                        <h2 class="text-sm">${user.phone_number}</h2>
                    </div>
                </div>`

                userSearchResultList.append(userHTML);
            }
        userSearchResult.show();
        }
    </script>
@endpush
