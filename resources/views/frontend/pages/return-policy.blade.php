@extends('frontend.layouts.default')
@section('title', 'Return-Policy')
@section('content')
    <section class="page-section page-top-gap">
        <div class="container sm:container md:container lg:px-24 xl:px-52 2xl:px-60 mx-auto">
            {{-- ========English Translate================ --}}
            <section class="mt-4">
                <p>Medicart offers a flexible return policy for items ordered with us. Under this policy, unopened and unused items must be returned within <strong>7 days</strong> from the date of delivery. The return window will be listed in the returns section of the order, once delivered.</p>
                <p class="mt-4 mb-2 text-base font-medium">Items are not eligible for return under the following circumstances:</p>
                <div class="flex flex-col space-y-2">
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                        If items have been opened, partially used or disfigured. Please check the package carefully at the time of delivery before opening and using.
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                        If the item’s packaging/box or seal has been tampered with. Do not accept the delivery if the package appears to be tampered with.
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                        If it is mentioned on the product details page that the item is non-returnable.
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                        If the return window for items in an order has expired. No items can be returned after 7 days from the delivery date.
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                        If any accessories supplied with the items are missing.
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                        If the item does not have the original serial number/UPC number/barcode affixed, which was present at the time of delivery.
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                        If there is any damage/defect which is not covered under the manufacturer's warranty.
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                        If the item is damaged due to visible misuse.
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                        Any refrigerated items like insulin or products that are heat sensitive are non-returnable.
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                        Items related to baby care, food & nutrition, healthcare devices and sexual wellness such as but not limited to diapers, health drinks, health supplements, glucometers, glucometer strips/lancets, health monitors, condoms, pregnancy/fertility kits, etc.
                    </span>
                </div>
                <section class="flex flex-col space-y-3 pt-4">
                    <div class="flex flex-col space-y-2">
                        <span class="font-medium">When can I expect delivery?</span>
                        <span><i class="mr-2 fa-solid fa-hand-point-right"></i>Currently we offer <strong>12-48 hours </strong>delivery time for inside dhaka and and soon we will be launching outside dhaka.
                        We are constantly working on improving delivery time, hopefully in future we can offer 3-4 hour expedite delivery service.</span>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <span class="font-medium">I have broken the seal, can I return it?</span>
                        <span><i class="mr-2 fa-solid fa-hand-point-right"></i>No, you can not return any items with a broken seal.</span>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <span class="font-medium">Can I return medicine that is partially consumed?</span>
                        <span><i class="mr-2 fa-solid fa-hand-point-right"></i>No, you cannot return partially consumed items. Only unopened items that have not been used can be returned.</span>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <span class="font-medium">Can I ask for a return if the strip is cut?</span>
                        <span><i class="mr-2 fa-solid fa-hand-point-right"></i>We provide customers with the option of purchasing medicines as single units. Even if ordering a single tablet of paracetamol, we can deliver that. It is common to have medicines in your order with some strips that are cut. If you want to get a full strip in your order, please order a full strip amount and you will get it accordingly. If you do not order a full strip, you will get cut pieces. If you have ordered 4 single units which are cut pieces and want to return, all 4 pieces must be returned. We do not allow partial return of 1 or 2 pieces.</span>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <span class="font-medium">When can I expect to get a refund?</span>
                        <span><i class="mr-2 fa-solid fa-hand-point-right"></i>If eligible for refund, your refund will be disbursed within 1-7 days.</span>
                    </div>
                </section>
            </section>
            {{-- ========./English Translate================ --}}
        </div>
    </section>
@endsection
