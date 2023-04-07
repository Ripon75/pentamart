@extends('frontend.layouts.default')
@section('title', 'Return-Policy')
@section('content')

<!--========Category Banner========-->
    <section class="page-top-gap">
        <x-frontend.header-title
            bgColor="linear-gradient( #112f7a, rgba(111, 111, 211, 0.52))"
            bgImageSrc="/images/banners/home-banner.jpg"
            title="Refund & Return Policy"
        />
    </section>

    <section class="page-section">
        <div class="container sm:container md:container lg:px-24 xl:px-52 2xl:px-60 mx-auto">
            <section class="">
                <div class="text-right">
                    <button id="en" class="eng-btn btn btn-primary btn-icon text-base"><i class="mr-2 fa-solid fa-language"></i>View in English</button>
                    <button id="bn" class="bng-btn btn btn-primary btn-icon text-base"><i class="mr-2 fa-solid fa-language"></i>বাংলায় দেখুন</button>
                </div>
            </section>
            {{-- ========English Translate================ --}}
            <section id="show" class="mt-4">
                <p class="first-letter:text-4xl">Medicart offers a flexible return policy for items ordered with us. Under this policy, unopened and unused items must be returned within <strong>7 days</strong> from the date of delivery. The return window will be listed in the returns section of the order, once delivered.</p>
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

            {{-- =======বাংলায় ট্রান্সলেট=========== --}}
            <section id="hide" hidden class="mt-4">
                <p class="first-letter:text-4xl">মেডিকার্ট আমাদের সাথে অর্ডার করা আইটেমগুলির জন্য একটি নমনীয় রিটার্ন নীতি অফার করে। এই নীতির অধীনে, না খোলা এবং অব্যবহৃত আইটেমগুলি ডেলিভারির তারিখ থেকে 7 দিনের মধ্যে ফেরত দিতে হবে। ফেরত উইন্ডো অর্ডারের রিটার্ন বিভাগে তালিকাভুক্ত করা হবে, একবার বিতরণ করা হবে।</p>
                <p class="mt-4 mb-2 text-base font-medium">নিম্নলিখিত পরিস্থিতিতে আইটেমগুলি ফেরতের জন্য যোগ্য নয়:</p>
                <div class="flex flex-col space-y-2">
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                        আইটেম খোলা হয়েছে, আংশিকভাবে ব্যবহৃত বা বিকৃত করা হয়েছে. খোলা এবং ব্যবহার করার আগে ডেলিভারির সময় সাবধানে প্যাকেজ চেক করুন।
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                         যদি আইটেমটির প্যাকেজিং/বাক্স বা সীলকে টেম্পার করা হয়। যদি প্যাকেজের সাথে বিকৃত করা হয় বলে মনে হয় তবে ডেলিভারি গ্রহণ করবেন না।
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                        যদি পণ্যের বিবরণ পৃষ্ঠায় উল্লেখ করা থাকে যে আইটেমটি ফেরতযোগ্য নয়।
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                         যদি কোনো অর্ডারের আইটেমের রিটার্ন উইন্ডোর মেয়াদ শেষ হয়ে যায়। ডেলিভারির তারিখ থেকে 7 দিন পর কোনো আইটেম ফেরত দেওয়া যাবে না।
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                         আইটেমগুলির সাথে সরবরাহ করা কোনো জিনিসপত্র অনুপস্থিত থাকলে।
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                        যদি আইটেমটিতে আসল সিরিয়াল নম্বর/ইউপিসি নম্বর/বারকোড না থাকে, যা ডেলিভারির সময় উপস্থিত ছিল।
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                        যদি কোন ক্ষতি/ত্রুটি থাকে যা প্রস্তুতকারকের ওয়ারেন্টির আওতায় নেই।
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                         দৃশ্যমান অপব্যবহারের কারণে জিনিসটি ক্ষতিগ্রস্ত হলে।
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                         যেকোন রেফ্রিজারেটেড আইটেম যেমন ইনসুলিন বা পণ্য যা তাপ সংবেদনশীল তা ফেরতযোগ্য নয়।
                    </span>
                    <span>
                        <i class="mr-2 fa-solid fa-hand-point-right"></i>
                         শিশুর যত্ন, খাদ্য ও পুষ্টি, স্বাস্থ্যসেবা ডিভাইস এবং যৌন সুস্থতার সাথে সম্পর্কিত আইটেম যেমন ডায়াপার, স্বাস্থ্য পানীয়, স্বাস্থ্য পরিপূরক, গ্লুকোমিটার, গ্লুকোমিটার স্ট্রিপ/ল্যান্সেট, স্বাস্থ্য মনিটর, কনডম, গর্ভাবস্থা/উর্বরতা কিট ইত্যাদির মধ্যে সীমাবদ্ধ নয়।
                    </span>
                </div>
                <section class="flex flex-col space-y-3 pt-4">
                    <div class="flex flex-col space-y-2">
                        <span class="font-medium">রিফান্ড পলিসি : </span>
                        <span><i class="mr-2 fa-solid fa-hand-point-right"></i>অর্ডার করার সময় গ্রাহক পেমেন্ট করে থাকলে যদি মেডিক্যার্ট পণ্য ডেলিভারি করতে ব্যর্থ হয়।</span>
                        <span><i class="mr-2 fa-solid fa-hand-point-right"></i>মেডিকার্ট ভুল পণ্য ডেলিভারি করে থাকলে অভিযোগের সত্যতা যাচাই সাপেক্ষে যদি অর্ডার কৃত পণ্য সরবরাহ করতে ব্যর্থ হয়।</span>
                        <span><i class="mr-2 fa-solid fa-hand-point-right"></i>প্রকাশিত পণ্য মূল্য অপেক্ষা অতিরিক্ত মূল্য সংগ্রহ করে থাকলে।</span>
                    </div>
                </section>
            </section>
            {{-- =======।/বাংলায় ট্রান্সলেট=========== --}}
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        var engBtn          =$('.eng-btn').hide();
        var bngBtn          =$('.bng-btn');

        $(function() {
            engBtn.click(function(){
                engBtn.hide();
                bngBtn.show();
            })

            bngBtn.click(function() {
                bngBtn.hide();
                engBtn.show();
            });
        })

        $('#bn').click(function() {
            $('#show').css('display', 'none');
            $('#hide').show();
        });
        $('#en').click(function() {
            $('#hide').css('display', 'none');
            $('#show').show();
        });
    </script>
@endpush
