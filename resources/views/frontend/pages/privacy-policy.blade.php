@extends('frontend.layouts.default')
@section('title', 'Privacy & Policy')
@section('content')
    <section class="page-section page-top-gap">
        <div class="container sm:container md:container lg:px-24 xl:px-52 2xl:px-60">
            <section class="">
                <div class="text-right">
                    <button id="en" class="eng-btn btn btn-primary btn-icon text-base"><i class="mr-2 fa-solid fa-language"></i>View in English</button>
                    <button id="bn" class="bng-btn btn btn-primary btn-icon text-base"><i class="mr-2 fa-solid fa-language"></i>বাংলায় দেখুন</button>
                </div>
            </section>
            {{-- =============English translate============= --}}
            <div id="show" class="mt-4">
                <p class="mt-2 text-justify text-base">At Medicart.health, accessible from medicart.health, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by Medicart.health and how we use it.</p>
                <p class="mt-2 text-justify">If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p>
                <p class="mt-2 text-justify">This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in Medicart.health. This policy is not applicable to any information collected offline or via channels other than this website.</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">Consent</h1>
                <p class="text-justify mt-2">By using our website, you hereby consent to our Privacy Policy and agree to its terms.</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">Information we collect</h1>
                <p class="text-justify mt-2">The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p>
                <p class="text-justify mt-2">If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide.</p>
                <p class="text-justify mt-2">When you register for an Account, we may ask for your contact information, including items such as name, company name, address, email address, and telephone number.</p>
                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">How we use your information?</h1>
                <p class="font-medium mb-2 mt-3">We use the information we collect in various ways, including to:</p>
                <ol class="list-decimal list-inside text-gray-600">
                    <li>Provide, operate, and maintain our website</li>
                    <li>Improve, personalize, and expand our website</li>
                    <li>Understand and analyze how you use our website</li>
                    <li>Develop new products, services, features, and functionality</li>
                    <li>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the website, and for marketing and promotional purposes</li>
                    <li>Send you emails</li>
                    <li>Find and prevent fraud</li>
                </ol>
                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">Log Files</h1>
                <p class="text-justify mt-2">Medicart.health follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users' movement on the website, and gathering demographic information.</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">Cookies and Web Beacons</h1>
                <p class="text-justify mt-2">Like any other website, Medicart.health uses 'cookies'. These cookies are used to store information including visitors' preferences, and the pages on the website that the visitor accessed or visited. The information is used to optimize the users' experience by customizing our web page content based on visitors' browser type and/or other information.</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">Advertising Partners Privacy Policies</h1>
                <p class="text-justify mt-2">You may consult this list to find the Privacy Policy for each of the advertising partners of Medicart.health.</p>
                <p class="text-justify mt-2">Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on Medicart.health, which are sent directly to users' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</p>
                <p class="text-justify mt-2"><span class="font-medium">Note</span> that Medicart.health has no access to or control over these cookies that are used by third-party advertisers.</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">Third Party Privacy Policies</h1>
                <p class="text-justify mt-2">Medicart.health's Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options.</p>
                <p class="text-justify mt-2">You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers' respective websites.</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">CCPA Privacy Rights (Do Not Sell My Personal Information)</h1>
                <p class="text-justify mt-2">Under the CCPA, among other rights, consumers have the right to.</p>
                <p class="text-justify mt-2">Request that a business that collects a consumer's personal data disclose the categories and specific pieces of personal data that a business has collected about consumers.</p>
                <p class="text-justify mt-2">Request that a business delete any personal data about the consumer that a business has collected.</p>
                <p class="text-justify mt-2">Request that a business that sells a consumer's personal data, not sell the consumer's personal data.</p>
                <p class="text-justify mt-2">If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">GDPR Data Protection Rights</h1>
                <p class="font-medium mb-2 mt-3">We would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:</p>
                <p class="text-justify mt-2"><span class="italic font-medium">The right to access –</span> You have the right to request copies of your personal data. We may charge you a small fee for this service.</p>
                <p class="text-justify mt-2"><span class="italic font-medium">The right to rectification – </span> You have the right to request that we correct any information you believe is inaccurate. You also have the right to request that we complete the information you believe is incomplete.</p>
                <p class="text-justify mt-2"><span class="italic font-medium">The right to erasure – </span> You have the right to request that we erase your personal data, under certain conditions.</p>
                <p class="text-justify mt-2"><span class="italic font-medium">The right to restrict processing – </span> You have the right to request that we restrict the processing of your personal data, under certain conditions.</p>
                <p class="text-justify mt-2"><span class="italic font-medium">The right to object to processing – </span> You have the right to object to our processing of your personal data, under certain conditions.</p>
                <p class="text-justify mt-2"><span class="italic font-medium">The right to data portability – </span> You have the right to request that we transfer the data that we have collected to another organization, or directly to you, under certain conditions.</p>
                <p class="text-justify mt-2">If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">Children's Information</h1>
                <p class="mt-3 text-justify">Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity.</p>
                <p class="mt-2 text-justify">Medicart.health does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records.</p>
            </div>
            {{-- =============./English translate============= --}}

            {{-- =============বাংলায় ট্রান্সলেট=============== --}}
            <div id="hide" hidden class="mt-4">
                <p class="mt-2 text-justify text-base">Medicart.-এ, medicart থেকে অ্যাক্সেসযোগ্য, আমাদের প্রধান অগ্রাধিকারগুলির মধ্যে একটি হল আমাদের দর্শকদের গোপনীয়তা। এই গোপনীয়তা নীতির নথিতে এমন ধরনের তথ্য রয়েছে যা Medicart.health দ্বারা সংগৃহীত এবং রেকর্ড করা হয় এবং আমরা কীভাবে এটি ব্যবহার করি।</p>
                <p class="mt-2 text-justify">আপনার যদি অতিরিক্ত প্রশ্ন থাকে বা আমাদের গোপনীয়তা নীতি সম্পর্কে আরও তথ্যের প্রয়োজন হয়, তাহলে আমাদের সাথে যোগাযোগ করতে দ্বিধা করবেন না।</p>
                <p class="mt-2 text-justify">এই গোপনীয়তা নীতি শুধুমাত্র আমাদের অনলাইন ক্রিয়াকলাপের ক্ষেত্রে প্রযোজ্য এবং আমাদের ওয়েবসাইটের দর্শকরা Medicart.health-এ যে তথ্য শেয়ার করেছেন এবং/অথবা সংগ্রহ করেছেন সেই বিষয়ে তাদের জন্য বৈধ। এই নীতি অফলাইনে বা এই ওয়েবসাইট ছাড়া অন্য চ্যানেলের মাধ্যমে সংগ্রহ করা কোনো তথ্যের ক্ষেত্রে প্রযোজ্য নয়।</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">সম্মতি</h1>
                <p class="text-justify mt-2">আমাদের ওয়েবসাইট ব্যবহার করে, আপনি এতদ্বারা আমাদের গোপনীয়তা নীতিতে সম্মত হন এবং এর শর্তাবলীতে সম্মত হন।</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">তথ্য আমরা সংগ্রহ করি</h1>
                <p class="text-justify mt-2">আপনাকে যে ব্যক্তিগত তথ্য প্রদান করতে বলা হয়েছে, এবং কেন আপনাকে এটি প্রদান করতে বলা হয়েছে, আমরা যখন আপনাকে আপনার ব্যক্তিগত তথ্য প্রদান করতে বলব তখনই আপনাকে স্পষ্ট করা হবে।</p>
                <p class="text-justify mt-2">আপনি যদি আমাদের সাথে সরাসরি যোগাযোগ করেন, আমরা আপনার সম্পর্কে অতিরিক্ত তথ্য পেতে পারি যেমন আপনার নাম, ইমেল ঠিকানা, ফোন নম্বর, বার্তার বিষয়বস্তু এবং/অথবা সংযুক্তিগুলি আপনি আমাদের পাঠাতে পারেন এবং আপনি প্রদান করতে বেছে নিতে পারেন এমন অন্য কোনো তথ্য।</p>
                <p class="text-justify mt-2">আপনি যখন একটি অ্যাকাউন্টের জন্য নিবন্ধন করেন, তখন আমরা নাম, কোম্পানির নাম, ঠিকানা, ইমেল ঠিকানা এবং টেলিফোন নম্বরের মতো আইটেম সহ আপনার যোগাযোগের তথ্য চাইতে পারি।</p>
                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">আমরা কিভাবে আপনার তথ্য ব্যবহার করি?</h1>
                <p class="font-medium mb-2 mt-3">আমরা যে তথ্য সংগ্রহ করি তা বিভিন্ন উপায়ে ব্যবহার করি, যার মধ্যে রয়েছে:</p>
                <ol class="list-decimal list-inside text-gray-600">
                    <li>আমাদের ওয়েবসাইট প্রদান, পরিচালনা এবং বজায় রাখা</li>
                    <li>আমাদের ওয়েবসাইট উন্নত করুন, ব্যক্তিগতকৃত করুন এবং প্রসারিত করুন</li>
                    <li>আপনি আমাদের ওয়েবসাইট কিভাবে ব্যবহার করেন তা বুঝুন এবং বিশ্লেষণ করুন</li>
                    <li>নতুন পণ্য, পরিষেবা, বৈশিষ্ট্য এবং কার্যকারিতা বিকাশ করুন</li>
                    <li>আপনার সাথে যোগাযোগ করুন, সরাসরি বা আমাদের অংশীদারদের একজনের মাধ্যমে, গ্রাহক পরিষেবা সহ, আপনাকে ওয়েবসাইট সম্পর্কিত আপডেট এবং অন্যান্য তথ্য প্রদান করতে এবং বিপণন এবং প্রচারমূলক উদ্দেশ্যে</li>
                    <li>আপনাকে ইমেইল পাঠান</li>
                    <li>খুঁজুন এবং জালিয়াতি প্রতিরোধ</li>
                </ol>
                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">লগ ফাইল</h1>
                <p class="text-justify mt-2">Medicart লগ ফাইল ব্যবহার করার একটি আদর্শ পদ্ধতি অনুসরণ করে। এই ফাইল ভিজিটর লগ লগ যখন তারা ওয়েবসাইট পরিদর্শন. সমস্ত হোস্টিং কোম্পানি এটি করে এবং হোস্টিং পরিষেবার বিশ্লেষণের একটি অংশ। লগ ফাইলের মাধ্যমে সংগৃহীত তথ্যের মধ্যে রয়েছে ইন্টারনেট প্রোটোকল (IP) ঠিকানা, ব্রাউজারের ধরন, ইন্টারনেট পরিষেবা প্রদানকারী (ISP), তারিখ এবং সময় স্ট্যাম্প, উল্লেখ/প্রস্থান পৃষ্ঠা এবং সম্ভবত ক্লিকের সংখ্যা। এগুলি ব্যক্তিগতভাবে শনাক্তযোগ্য এমন কোনও তথ্যের সাথে সংযুক্ত নয়৷ তথ্যের উদ্দেশ্য হল প্রবণতা বিশ্লেষণ করা, সাইট পরিচালনা করা, ওয়েবসাইটে ব্যবহারকারীদের গতিবিধি ট্র্যাক করা এবং জনসংখ্যা সংক্রান্ত তথ্য সংগ্রহ করা।</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">কুকিজ এবং ওয়েব বীকন</h1>
                <p class="text-justify mt-2">অন্য যেকোনো ওয়েবসাইটের মতো, Medicart 'কুকিজ' ব্যবহার করে। এই কুকিগুলি ভিজিটরদের পছন্দ এবং ওয়েবসাইটের পৃষ্ঠাগুলি যা ভিজিটর অ্যাক্সেস করেছে বা পরিদর্শন করেছে সেগুলি সহ তথ্য সংরক্ষণ করতে ব্যবহৃত হয়। তথ্যটি দর্শকদের ব্রাউজারের ধরন এবং/অথবা অন্যান্য তথ্যের উপর ভিত্তি করে আমাদের ওয়েব পৃষ্ঠার বিষয়বস্তু কাস্টমাইজ করে ব্যবহারকারীদের অভিজ্ঞতা অপ্টিমাইজ করতে ব্যবহার করা হয়।</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">বিজ্ঞাপন অংশীদারদের গোপনীয়তা নীতি</h1>
                <p class="text-justify mt-2">আপনি Medicart.health-এর প্রতিটি বিজ্ঞাপনী অংশীদারদের জন্য গোপনীয়তা নীতি খুঁজে পেতে এই তালিকার সাথে পরামর্শ করতে পারেন।</p>
                <p class="text-justify mt-2">তৃতীয় পক্ষের বিজ্ঞাপন সার্ভার বা বিজ্ঞাপন নেটওয়ার্কগুলি কুকিজ, জাভাস্ক্রিপ্ট বা ওয়েব বীকনের মতো প্রযুক্তি ব্যবহার করে যা তাদের নিজ নিজ বিজ্ঞাপনে ব্যবহৃত হয় এবং Medicart.health-এ প্রদর্শিত লিঙ্কগুলিতে ব্যবহৃত হয়, যা সরাসরি ব্যবহারকারীদের ব্রাউজারে পাঠানো হয়। যখন এটি ঘটে তখন তারা স্বয়ংক্রিয়ভাবে আপনার আইপি ঠিকানা গ্রহণ করে। এই প্রযুক্তিগুলি তাদের বিজ্ঞাপন প্রচারাভিযানের কার্যকারিতা পরিমাপ করতে এবং/অথবা আপনি যে ওয়েবসাইটগুলিতে যান সেগুলিতে আপনি যে বিজ্ঞাপন সামগ্রী দেখেন তা ব্যক্তিগতকৃত করতে ব্যবহৃত হয়৷</p>
                <p class="text-justify mt-2"><span class="font-medium">উল্লেখ্য যে Medicart.health-এর এই কুকিগুলিতে কোনো অ্যাক্সেস বা নিয়ন্ত্রণ নেই যা তৃতীয় পক্ষের বিজ্ঞাপনদাতাদের দ্বারা ব্যবহৃত হয়।</span></p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">তৃতীয় পক্ষের গোপনীয়তা নীতি</h1>
                <p class="text-justify mt-2">Medicart.health-এর গোপনীয়তা নীতি অন্যান্য বিজ্ঞাপনদাতা বা ওয়েবসাইটে প্রযোজ্য নয়। সুতরাং, আমরা আপনাকে আরও বিস্তারিত তথ্যের জন্য এই তৃতীয় পক্ষের বিজ্ঞাপন সার্ভারগুলির সংশ্লিষ্ট গোপনীয়তা নীতিগুলির সাথে পরামর্শ করার পরামর্শ দিচ্ছি। এতে তাদের অনুশীলন এবং নির্দিষ্ট বিকল্পগুলি কীভাবে অপ্ট-আউট করা যায় সে সম্পর্কে নির্দেশাবলী অন্তর্ভুক্ত থাকতে পারে।</p>
                <p class="text-justify mt-2">আপনি আপনার পৃথক ব্রাউজার বিকল্পগুলির মাধ্যমে কুকিজ নিষ্ক্রিয় করতে বেছে নিতে পারেন। নির্দিষ্ট ওয়েব ব্রাউজারগুলির সাথে কুকি পরিচালনা সম্পর্কে আরও বিস্তারিত তথ্য জানতে, এটি ব্রাউজারগুলির নিজ নিজ ওয়েবসাইটে পাওয়া যেতে পারে।</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">CCPA গোপনীয়তা অধিকার (আমার ব্যক্তিগত তথ্য বিক্রি করবেন না)</h1>
                <p class="text-justify mt-2">CCPA-এর অধীনে, অন্যান্য অধিকারের মধ্যে, ভোক্তাদের অধিকার রয়েছে৷</p>
                <p class="text-justify mt-2">অনুরোধ করুন যে একটি ব্যবসা যেটি একটি ভোক্তার ব্যক্তিগত ডেটা সংগ্রহ করে সেগুলি ভোক্তাদের সম্পর্কে একটি ব্যবসার সংগ্রহ করা ব্যক্তিগত ডেটার বিভাগ এবং নির্দিষ্ট অংশগুলি প্রকাশ করে৷</p>
                <p class="text-justify mt-2">অনুরোধ করুন যে একটি ব্যবসা ভোক্তা সম্পর্কে যে কোনও ব্যক্তিগত ডেটা মুছে ফেলবে যা একটি ব্যবসা সংগ্রহ করেছে৷</p>
                <p class="text-justify mt-2">অনুরোধ করুন যে একটি ব্যবসা যেটি একটি ভোক্তার ব্যক্তিগত ডেটা বিক্রি করে, ভোক্তার ব্যক্তিগত ডেটা বিক্রি না করে৷</p>
                <p class="text-justify mt-2">আপনি যদি একটি অনুরোধ করেন, আমাদের কাছে আপনাকে প্রতিক্রিয়া জানাতে এক মাস সময় আছে। আপনি যদি এই অধিকারগুলির মধ্যে কোনটি ব্যবহার করতে চান তবে অনুগ্রহ করে আমাদের সাথে যোগাযোগ করুন।</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">জিডিপিআর ডেটা সুরক্ষা অধিকার</h1>
                <p class="font-medium mb-2 mt-3">আমরা নিশ্চিত করতে চাই যে আপনি আপনার সমস্ত ডেটা সুরক্ষা অধিকার সম্পর্কে পুরোপুরি সচেতন। প্রতিটি ব্যবহারকারীর নিম্নলিখিতগুলি পাওয়ার অধিকার রয়েছে:</p>
                <p class="text-justify mt-2"><span class="italic font-medium">অ্যাক্সেস করার অধিকার –</span>  আপনার ব্যক্তিগত ডেটার অনুলিপি অনুরোধ করার অধিকার রয়েছে। আমরা এই পরিষেবার জন্য আপনাকে একটি ছোট ফি নিতে পারি।</p>
                <p class="text-justify mt-2"><span class="italic font-medium">সংশোধনের অধিকার – </span>  আপনার কাছে অনুরোধ করার অধিকার রয়েছে যে আমরা যে কোনো তথ্য ভুল বলে মনে করি তা সংশোধন করুন। আপনার কাছে অনুরোধ করার অধিকার আছে যে আমরা যে তথ্যটি অসম্পূর্ণ বলে মনে করেন তা সম্পূর্ণ করার জন্য।</p>
                <p class="text-justify mt-2"><span class="italic font-medium">মুছে ফেলার অধিকার – </span>  আপনার কাছে অনুরোধ করার অধিকার আছে যে আমরা কিছু শর্তের অধীনে আপনার ব্যক্তিগত ডেটা মুছে ফেলি।</p>
                <p class="text-justify mt-2"><span class="italic font-medium">প্রক্রিয়াকরণ সীমাবদ্ধ করার অধিকার  – </span> আপনার কাছে অনুরোধ করার অধিকার রয়েছে যে আমরা কিছু শর্তের অধীনে আপনার ব্যক্তিগত ডেটা প্রক্রিয়াকরণ সীমাবদ্ধ করি।</p>
                <p class="text-justify mt-2"><span class="italic font-medium">প্রক্রিয়াকরণে আপত্তি করার অধিকার – </span>  কিছু শর্তের অধীনে আপনার ব্যক্তিগত ডেটার আমাদের প্রক্রিয়াকরণে আপত্তি করার অধিকার আপনার আছে।</p>
                <p class="text-justify mt-2"><span class="italic font-medium">ডেটা পোর্টেবিলিটির অধিকার – </span>  আপনার কাছে অনুরোধ করার অধিকার রয়েছে যে আমরা নির্দিষ্ট শর্তে আমরা যে ডেটা সংগ্রহ করেছি তা অন্য সংস্থায় বা সরাসরি আপনার কাছে স্থানান্তর করি।</p>
                <p class="text-justify mt-2">আপনি যদি একটি অনুরোধ করেন, আমাদের কাছে আপনাকে প্রতিক্রিয়া জানাতে এক মাস সময় আছে। আপনি যদি এই অধিকারগুলির মধ্যে কোনটি ব্যবহার করতে চান তবে অনুগ্রহ করে আমাদের সাথে যোগাযোগ করুন।</p>

                <h1 class="text-lg font-medium mt-4 tracking-wider underline underline-offset-4">শিশুদের তথ্য</h1>
                <p class="mt-3 text-justify">আমাদের অগ্রাধিকারের আরেকটি অংশ হল ইন্টারনেট ব্যবহার করার সময় শিশুদের জন্য সুরক্ষা যোগ করা। আমরা পিতামাতা এবং অভিভাবকদের তাদের অনলাইন কার্যকলাপ পর্যবেক্ষণ, অংশগ্রহণ, এবং/অথবা নিরীক্ষণ এবং গাইড করার জন্য উত্সাহিত করি।</p>
                <p class="mt-2 text-justify">Medicart.health 13 বছরের কম বয়সী শিশুদের কাছ থেকে জেনেশুনে কোনো ব্যক্তিগত শনাক্তকরণযোগ্য তথ্য সংগ্রহ করে না। আপনি যদি মনে করেন যে আপনার সন্তান আমাদের ওয়েবসাইটে এই ধরনের তথ্য প্রদান করেছে, তাহলে আমরা আপনাকে অবিলম্বে আমাদের সাথে যোগাযোগ করার জন্য জোরালোভাবে উৎসাহিত করব এবং আমরা আমাদের যথাসাধ্য চেষ্টা করব। অবিলম্বে আমাদের রেকর্ড থেকে এই ধরনের তথ্য অপসারণ।</p>
            </div>
            {{-- =============./বাংলায় ট্রান্সলেট=============== --}}
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
