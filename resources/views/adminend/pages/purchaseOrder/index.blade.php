@extends('adminend.layouts.default')
@section('title', 'Purchase Orders')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Purchase Orders</h6>
        <div class="actions">
            <a class="action btn btn-primary" href="{{ route('admin.purchase.orders.create') }}">Create</a>
        </div>
    </div>
    <div class="page-content">
        <div class="">
             {{-- Show flash message --}}
            <div class="col-span-12">
                @if(Session::has('message'))
                    <div class="alert success">{{ Session::get('message') }}</div>
                @endif
                @if(Session::has('error'))
                    <div class="alert error">{{ Session::get('error') }}</div>
                @endif
            </div>
            @csrf
            <table class="table-report w-full">
                <thead class="bg-gray-100 shadow-sm sticky top-0">
                    <th class="text-left w-28">ID</th>
                    <th class="text-left w-28">Order ID</th>
                    <th class="text-left w-28">Created At</th>
                    <th class="text-left w-28">User</th>
                    <th class="w-24">Pharmacy</th>
                    <th class="w-24">Total Price</th>
                </thead>
                <tbody>
                    @foreach ($purchaseOrders as $pItem)
                        <tr class="hover:bg-gray-100 transition-all duration-300 ease-in-out">
                            <td>{{ $pItem->id }}</td>
                            <td>{{ $pItem->order_id }}</td>
                            <td>{{ $pItem->created_at ? $pItem->created_at->format('d/m/Y') : '' }}</td>
                            <td>{{ $pItem->purchaseBy->name ?? 'N/A' }}</td>
                            <td>{{ $pItem->pharmacy_id ?? 'N/A' }}</td>
                            <td>{{ number_format($pItem->getTotalPrice(), 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($purchaseOrders->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $purchaseOrders->appends(request()->input())->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        var posBaseURL         = '{{ config('app.pos_api_base_url') }}';
        var posToken           = localStorage.getItem('pos_token');
        var mediposBranch      = $('.medipos-branch');
        var selectParantBranch = $('.select-parant-branch');
        __getAllMediposBranch();

        $(() => {
            
        });

        // Get area wise branch
        function __getAllMediposBranch(areaID){
            axios.get(`${posBaseURL}/api/branch/data/private/index`, {
                headers: {
                    Authorization: `Bearer ${posToken}`,
                },
                params: {
                    sort: 'display_name.ascend'
                }
            })
            .then(function (res) {
                if (res) {
                    var branches = res.data.result.data
                    if (branches) {
                        renderMediposBranches(branches);
                    }
                }
            })
            .catch(function (err) {
                console.log(err);
            });
        }

        // Render medipos area wise branch
        function renderMediposBranches (branches) {
            mediposBranch.html('');
            mediposBranch.html('<option value="">Select</option>');
            if (branches.length > 0) {
                branches.forEach( function (item) {
                    branchHTML =
                        `<option value="${item.id}" data-business-id="${item.business_info.id}">
                            ${item.business_info.display_name} - (${item.display_name})
                        </option>`;
                    mediposBranch.append(branchHTML);
                });
            }
        }
    </script>
@endpush
