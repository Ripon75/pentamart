@extends('frontend.layouts.default')
@section('title', 'Terms and Conditions')
@section('content')
    <section class="page-section page-top-gap">
        <section class="container sm:container md:container lg:px-24 xl:px-52 2xl:px-60 text-gray-800">
            <section class="">
                <div class="text-right">
                    <button id="en" class="eng-btn btn btn-primary btn-icon text-base"><i class="mr-2 fa-solid fa-language"></i>View in English</button>
                    <button id="bn" class="bng-btn btn btn-primary btn-icon text-base"><i class="mr-2 fa-solid fa-language"></i>বাংলায় দেখুন</button>
                </div>
            </section>
            {{-- ======English translate============ --}}
            <div id="show" class="mt-4">
                <div class="">
                    <h1 class="text-lg first-letter:text-4xl">Welcome to <span class="text-secondary font-medium">Medicart.health!</span></h1>
                </div>
                <div class="mt-2 flex flex-col space-y-2 text-justify">
                    <p>These terms and conditions outline the rules and regulations for the use of <a href="http://www.pulsetechltd.com/" target="blank" class="font-medium">Pulse Tech Ltd</a>'s Website, located at <a href="https://medicart.health/" target="blank" class="font-medium">www.medicart.health</a>.</p>
                    <p class="">By accessing this website we assume you accept these terms and conditions. Do not continue to use Medicart.health if you do not agree to take all of the terms and conditions stated on this page.</p>
                    <p class="">The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer Notice and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and compliant to the Company’s terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.</p>
                </div>
                <div class="mt-4">
                    <div class="title-wrapper">
                        <span class="title">Cookies</span>
                    </div>
                    <p class="mt-2">We employ the use of cookies. By accessing Medicart.health, you agreed to use cookies in agreement with the Pulse Tech Ltd.'s Privacy Policy.</p>
                    <p class="mt-2 text-justify">Most interactive websites use cookies to let us retrieve the user’s details for each visit. Cookies are used by our website to enable the functionality of certain areas to make it easier for people visiting our website. Some of our affiliate/advertising partners may also use cookies.</p>
                </div>
                <div class="mt-4">
                    <div class="title-wrapper">
                        <span class="title">License</span>
                    </div>
                    <p class="mt-2 text-justify">Unless otherwise stated, Pulse Tech Ltd. and/or its licensors own the intellectual property rights for all material on Medicart.health. All intellectual property rights are reserved. You may access this from Medicart.health for your own personal use subjected to restrictions set in these terms and conditions.</p>
                    <p class="font-medium mb-2 mt-3">You must not:</p>
                    <ol class="list-disc list-inside text-gray-600">
                        <li>Republish material from Medicart.health</li>
                        <li>Sell, rent or sub-license material from Medicart.health</li>
                        <li>Reproduce, duplicate or copy material from Medicart.health</li>
                        <li>Redistribute content from Medicart.health</li>
                    </ol>
                    <p class="mt-2 text-justify">Parts of this website offer an opportunity for users to post and exchange opinions and information in certain areas of the website. Pulse Tech Ltd. does not filter, edit, publish or review Comments prior to their presence on the website. Comments do not reflect the views and opinions of Pulse Tech Ltd.,its agents and/or affiliates. Comments reflect the views and opinions of the person who post their views and opinions. To the extent permitted by applicable laws, Pulse Tech Ltd. shall not be liable for the Comments or for any liability, damages or expenses caused and/or suffered as a result of any use of and/or posting of and/or appearance of the Comments on this website.</p>
                    <p class="mt-2 text-justify">Pulse Tech Ltd. reserves the right to monitor all Comments and to remove any Comments which can be considered inappropriate, offensive or causes breach of these Terms and Conditions.</p>
                    <p class="font-medium mb-2 mt-3">You warrant and represent that:</p>
                    <ol class="list-disc list-inside text-gray-600">
                        <li>You are entitled to post the Comments on our website and have all necessary licenses and consents to do so;</li>
                        <li>The Comments do not invade any intellectual property right, including without limitation copyright, patent or trademark of any third party;</li>
                        <li>The Comments do not contain any defamatory, libelous, offensive, indecent or otherwise unlawful material which is an invasion of privacy</li>
                        <li>The Comments will not be used to solicit or promote business or custom or present commercial activities or unlawful activity.</li>
                    </ol>
                    <p class="mt-2 text-justify">You hereby grant Pulse Tech Ltd. a non-exclusive license to use, reproduce, edit and authorize others to use, reproduce and edit any of your Comments in any and all forms, formats or media.</p>
                </div>
                <div class="mt-4">
                    <div class="title-wrapper">
                        <span class="title">Hyperlinking to our Content</span>
                    </div>
                    <p class="font-medium mb-2 mt-3">The following organizations may link to our Website without prior written approval:</p>
                    <ol class="list-disc list-inside text-gray-600">
                        <li>Government agencies;</li>
                        <li>Search engines;</li>
                        <li>News organizations;</li>
                        <li>Online directory distributors may link to our Website in the same manner as they hyperlink to the Websites of other listed businesses;</li>
                        <li>System wide Accredited Businesses except soliciting non-profit organizations, charity shopping malls, and charity fundraising groups which may not hyperlink to our Web site;</li>
                    </ol>
                    <p class="font-medium mb-2 mt-3">These organizations may link to our home page, to publications or to other Website information so long as the link:</p>
                    <ol class="list-decimal list-inside text-gray-600">
                        <li>is not in any way deceptive;</li>
                        <li>does not falsely imply sponsorship, endorsement or approval of the linking party and its products and/or services;</li>
                        <li>fits within the context of the linking party’s site.</li>
                    </ol>
                    <p class="font-medium mb-2 mt-3">We may consider and approve other link requests from the following types of organizations:</p>
                    <ol class="list-disc list-inside text-gray-600">
                        <li>commonly-known consumer and/or business information sources;</li>
                        <li>dot.com community sites;</li>
                        <li>associations or other groups representing charities;</li>
                        <li>online directory distributors;</li>
                        <li>internet portals;</li>
                        <li>accounting, law and consulting firms;</li>
                        <li>educational institutions and trade associations.</li>
                    </ol>
                    <p class="font-medium mb-2 mt-3">We will approve link requests from these organizations if we decide that:</p>
                    <ol class="list-decimal list-inside text-gray-600">
                        <li>the link would not make us look unfavorably to ourselves or to our accredited businesses;</li>
                        <li>the organization does not have any negative records with us;</li>
                        <li>the benefit to us from the visibility of the hyperlink compensates the absence of Pulse Tech Ltd;</li>
                        <li>the link is in the context of general resource information.</li>
                    </ol>
                    <p class="font-medium mb-2 mt-3">These organizations may link to our home page so long as the link: </p>
                    <ol class="list-decimal list-inside text-gray-600">
                        <li>is not in any way deceptive;</li>
                        <li>does not falsely imply sponsorship, endorsement or approval of the linking party and its products or services;</li>
                        <li>fits within the context of the linking party’s site.</li>
                    </ol>
                    <p class="mt-2 text-justify">If you are one of the organizations listed in paragraph 2 above and are interested in linking to our website, you must inform us by sending an e-mail to Pulse Tech Ltd.. Please include your name, your organization name, contact information as well as the URL of your site, a list of any URLs from which you intend to link to our Website, and a list of the URLs on our site to which you would like to link. Wait 2-3 weeks for a response.</p>
                    <p class="font-medium mb-2 mt-3">Approved organizations may hyperlink to our Website as follows:</p>
                    <ol class="list-decimal list-inside text-gray-600">
                        <li>By use of our corporate name;</li>
                        <li>By use of the uniform resource locator being linked to;</li>
                        <li>By use of any other description of our Website being linked to that makes sense within the context and format of content on the linking party’s site.</li>
                    </ol>
                    <p class="mt-2 text-justify">No use of Pulse Tech Ltd.'s logo or other artwork will be allowed for linking absent a trademark license agreement.</p>
                </div>
                <div class="mt-4">
                    <div class="title-wrapper">
                        <span class="title">Reservation of Rights</span>
                    </div>
                    <p class="mt-2 text-justify">We reserve the right to request that you remove all links or any particular link to our Website. You approve to immediately remove all links to our Website upon request. We also reserve the right to amen these terms and conditions and it’s linking policy at any time. By continuously linking to our Website, you agree to be bound to and follow these linking terms and conditions.</p>
                </div>
                <div class="mt-4">
                    <div class="title-wrapper">
                        <span class="title">Removal of links from our website</span>
                    </div>
                    <p class="mt-2 text-justify">If you find any link on our Website that is offensive for any reason, you are free to contact and inform us any moment. We will consider requests to remove links but we are not obligated to or so or to respond to you directly.</p>
                    <p class="mt-2 text-justify">We do not ensure that the information on this website is correct, we do not warrant its completeness or accuracy; nor do we promise to ensure that the website remains available or that the material on the website is kept up to date.</p>
                </div>
                <div class="mt-4">
                    <div class="title-wrapper">
                        <span class="title">Disclaimer</span>
                    </div>
                    <p class="font-medium mb-2 mt-3">To the maximum extent permitted by applicable law, we exclude all representations, warranties and conditions relating to our website and the use of this website. Nothing in this disclaimer will:</p>
                    <ol class="list-decimal list-inside text-gray-600">
                        <li>limit or exclude our or your liability for death or personal injury;</li>
                        <li>limit or exclude our or your liability for fraud or fraudulent misrepresentation;</li>
                        <li>limit any of our or your liabilities in any way that is not permitted under applicable law;</li>
                        <li>exclude any of our or your liabilities that may not be excluded under applicable law.</li>
                    </ol>
                    <p class="font-medium mb-2 mt-3">The limitations and prohibitions of liability set in this Section and elsewhere in this disclaimer:</p>
                    <ol class="list-decimal list-inside text-gray-600">
                        <li>are subject to the preceding paragraph;</li>
                        <li>govern all liabilities arising under the disclaimer, including liabilities arising in contract, in tort and for breach of statutory duty.</li>
                    </ol>
                    <p class="mt-2 text-justify">As long as the website and the information and services on the website are provided free of charge, we will not be liable for any loss or damage of any nature.</p>
                </div>
                <div class="mt-4">
                    <div class="title-wrapper">
                        <span class="title">Price Increase Notice and Customer Obligations</span>
                    </div>
                    <p class="mb-2 mt-3">
                        Whenever there is a change in medicine prices as per the regulations set by DGDA (Directorate General of Drug Administration), it may take 5-7 days for us to receive and update the information on our website. In the event that a customer purchases a medicine from our site, and after that we receive the notice of a price increase, we are obliged by law to increase the price of the medicine accordingly. Therefore, the customer is required to pay the increased price for the medicine.
                    </p>
                </div>
            </div>
            {{-- ======./English translate============ --}}

            {{-- ======বাংলায় ট্রান্সলেট============ --}}
            <div id="hide" hidden class="mt-4">
                <div class="">
                    <h1 class="text-lg first-letter:text-4xl text-secondary font-medium">Medicart এ স্বাগতম!</h1>
                </div>
                <div class="mt-2 flex flex-col space-y-2 text-justify">
                    <p>এই নিয়ম ও শর্তাবলী www.medicart.health-এ অবস্থিত মেডিকার্ট -এর ওয়েবসাইট ব্যবহারের নিয়ম ও প্রবিধানের রূপরেখা দেয়৷</p>
                    <p class="">এই ওয়েবসাইট অ্যাক্সেস করে আমরা ধরে নিই যে আপনি এই শর্তাবলী স্বীকার করেন। আপনি যদি এই পৃষ্ঠায় উল্লিখিত সমস্ত শর্তাবলী মেনে চলতে সম্মত না হন তবে মেডিকার্ট ব্যবহার করা চালিয়ে যাবেন না।</p>
                    <p class="">নিম্নলিখিত পরিভাষাগুলি এই শর্তাবলী, গোপনীয়তা বিবৃতি এবং দাবিত্যাগ বিজ্ঞপ্তি এবং সমস্ত চুক্তিতে প্রযোজ্য: "ক্লায়েন্ট", "আপনি" এবং "আপনার" আপনাকে বোঝায়, যে ব্যক্তি এই ওয়েবসাইটে লগ ইন করে এবং কোম্পানির শর্তাবলী মেনে চলে। "কোম্পানি", "আমরা", "আমাদের" এবং "আমাদের", আমাদের কোম্পানিকে বোঝায়। "পার্টি", "পার্টি" বা "আমাদের", ক্লায়েন্ট এবং নিজেদের উভয়কেই বোঝায়। সমস্ত শর্তাবলী ক্লায়েন্টকে আমাদের সহায়তার প্রক্রিয়াটি গ্রহণ করার জন্য প্রয়োজনীয় অফার, গ্রহণযোগ্যতা এবং বিবেচনাকে বোঝায় কোম্পানির উল্লিখিত পরিষেবাগুলির বিধানের ক্ষেত্রে ক্লায়েন্টের চাহিদা মেটানোর জন্য সবচেয়ে উপযুক্ত পদ্ধতিতে। এবং সাপেক্ষে, নেদারল্যান্ডের প্রচলিত আইন। একবচন, বহুবচন, ক্যাপিটালাইজেশন এবং/অথবা সে/সে বা তারা, উপরোক্ত পরিভাষা বা অন্যান্য শব্দের যেকোন ব্যবহারকে বিনিময়যোগ্য এবং সেইজন্য একইভাবে উল্লেখ করা হয়।</p>
                </div>
                <div class="mt-4">
                    <div class="title-wrapper">
                        <span class="title">কুকিজ </span>
                    </div>
                    <p class="mt-2 text-justify">আমরা কুকিজ ব্যবহার নিযুক্ত. মেডিকার্ট অ্যাক্সেস করার মাধ্যমে, আপনি মেডিকার্ট এর গোপনীয়তা নীতির সাথে চুক্তিতে কুকিজ ব্যবহার করতে সম্মত হয়েছেন।</p>
                    <p class="mt-2 text-justify">বেশিরভাগ ইন্টারেক্টিভ ওয়েবসাইটগুলি আমাদের প্রতিটি ভিজিটের জন্য ব্যবহারকারীর বিবরণ পুনরুদ্ধার করতে কুকিজ ব্যবহার করে। আমাদের ওয়েবসাইট ভিজিট করা লোকেদের জন্য সহজতর করার জন্য কিছু নির্দিষ্ট এলাকার কার্যকারিতা সক্ষম করতে আমাদের ওয়েবসাইট দ্বারা কুকি ব্যবহার করা হয়। আমাদের কিছু অনুমোদিত/বিজ্ঞাপন অংশীদাররাও কুকি ব্যবহার করতে পারে।</p>
                </div>
                <div class="mt-4">
                    <div class="title-wrapper">
                        <span class="title">লাইসেন্স</span>
                    </div>
                    <p class="mt-2 text-justify">অন্যথায় বলা না থাকলে, মেডিকার্ট এবং/অথবা এর লাইসেন্সদাতারা মেডিকার্ট -এর সমস্ত উপাদানের জন্য বৌদ্ধিক সম্পত্তির অধিকারের মালিক৷ সমস্ত মেধা সম্পত্তি অধিকার সংরক্ষিত. আপনি এই শর্তাবলীতে সেট করা বিধিনিষেধ সাপেক্ষে আপনার নিজের ব্যক্তিগত ব্যবহারের জন্য মেডিকার্ট থেকে এটি অ্যাক্সেস করতে পারেন।</p>
                    <p class="font-medium mb-2 mt-3">আপনি যা করতে পারবেন না:</p>
                    <ol class="list-disc list-inside text-gray-600">
                        <li>মেডিকার্ট থেকে উপাদান পুনঃপ্রকাশ</li>
                        <li>মেডিকার্ট থেকে বিক্রয়, ভাড়া বা উপ-লাইসেন্স সামগ্রী</li>
                        <li>মেডিকার্ট থেকে উপাদান পুনরুত্পাদন, নকল বা অনুলিপি করুন</li>
                        <li>মেডিকার্ট থেকে সামগ্রী পুনরায় বিতরণ করুন</li>
                    </ol>
                    <p class="mt-2 text-justify">এই ওয়েবসাইটের অংশগুলি ব্যবহারকারীদের ওয়েবসাইটের নির্দিষ্ট কিছু ক্ষেত্রে মতামত এবং তথ্য পোস্ট এবং বিনিময় করার সুযোগ দেয়। মেডিকার্ট ওয়েবসাইটে তাদের উপস্থিতির আগে মন্তব্যগুলি ফিল্টার, সম্পাদনা, প্রকাশ বা পর্যালোচনা করে না। মন্তব্যগুলি মেডিকার্ট এর এজেন্ট এবং/অথবা সহযোগীদের মতামত এবং মতামতকে প্রতিফলিত করে না। মন্তব্যগুলি সেই ব্যক্তির মতামত এবং মতামতকে প্রতিফলিত করে যিনি তাদের মতামত এবং মতামত পোস্ট করেন। প্রযোজ্য আইন দ্বারা অনুমোদিত পরিমাণে, মেডিকার্ট এর মন্তব্যের জন্য বা কোনও দায়বদ্ধতার জন্য দায়বদ্ধ হবে না, ক্ষয়ক্ষতি বা খরচ এবং/অথবা ব্যবহার এবং/অথবা পোস্টিং এবং/অথবা উপস্থিতির ফলে সৃষ্ট এবং/অথবা ক্ষতিগ্রস্ত এই ওয়েবসাইটে মন্তব্য.</p>
                    <p class="mt-2 text-justify">মেডিকার্ট সমস্ত মন্তব্য নিরীক্ষণ করার এবং অনুপযুক্ত, আপত্তিকর বা এই শর্তাবলী লঙ্ঘনের কারণ হিসাবে বিবেচিত হতে পারে এমন যেকোনো মন্তব্য অপসারণের অধিকার সংরক্ষণ করে।</p>
                    <p class="font-medium mb-2 mt-3">আপনি ওয়ারেন্টি এবং প্রতিনিধিত্ব করেন যে:</p>
                    <ol class="list-disc list-inside text-gray-600">
                        <li>আপনি আমাদের ওয়েবসাইটে মন্তব্য পোস্ট করার অধিকারী এবং তা করার জন্য আপনার কাছে সমস্ত প্রয়োজনীয় লাইসেন্স এবং সম্মতি রয়েছে;</li>
                        <li>মন্তব্যগুলি সীমাবদ্ধ কপিরাইট, পেটেন্ট বা তৃতীয় পক্ষের ট্রেডমার্ক ছাড়াই কোনও মেধা সম্পত্তির অধিকারকে আক্রমণ করে না;</li>
                        <li>মন্তব্যগুলিতে কোনও মানহানিকর, আপত্তিকর, অশালীন বা অন্যথায় বেআইনি উপাদান নেই যা গোপনীয়তার আক্রমণ</li>
                        <li>মন্তব্যগুলি ব্যবসা বা কাস্টম বা উপস্থাপনা বাণিজ্যিক কার্যকলাপ বা বেআইনী কার্যকলাপের অনুরোধ বা প্রচার করতে ব্যবহার করা হবে না।</li>
                    </ol>
                    <p class="mt-2 text-justify">আপনি এতদ্বারা মেডিকার্ট কে যে কোনো এবং সমস্ত ফর্ম, ফর্ম্যাট বা মিডিয়াতে আপনার যে কোনো মন্তব্য ব্যবহার, পুনরুত্পাদন এবং সম্পাদনা করার জন্য অন্যদের ব্যবহার, পুনরুত্পাদন, সম্পাদনা এবং অনুমোদন করার জন্য একটি অ-এক্সক্লুসিভ লাইসেন্স প্রদান করছেন।</p>
                </div>
                <div class="mt-4">
                    <div class="title-wrapper">
                        <span class="title">অধিকার সংরক্ষণ:</span>
                    </div>
                    <p class="mt-2 text-justify">আমরা অনুরোধ করার অধিকার সংরক্ষণ করি যে আপনি আমাদের ওয়েবসাইটের সমস্ত লিঙ্ক বা কোনো নির্দিষ্ট লিঙ্ক মুছে ফেলুন। আপনি অনুরোধের ভিত্তিতে আমাদের ওয়েবসাইটের সমস্ত লিঙ্ক অবিলম্বে অপসারণ করতে অনুমোদন করেন। আমরা এই শর্তাবলী এবং এটি যেকোন সময় লিঙ্কিং নীতিতে আমেন করার অধিকারও সংরক্ষণ করি। আমাদের ওয়েবসাইটে ক্রমাগত লিঙ্ক করে, আপনি এই লিঙ্কিং শর্তাবলী মেনে চলতে এবং মেনে চলতে সম্মত হন।</p>
                </div>
                <div class="mt-4">
                    <div class="title-wrapper">
                        <span class="title">আমাদের ওয়েবসাইট থেকে লিঙ্ক অপসারণ:</span>
                    </div>
                    <p class="mt-2 text-justify">আপনি যদি আমাদের ওয়েবসাইটে কোনো লিঙ্ক খুঁজে পান যা কোনো কারণে আপত্তিকর, আপনি যে কোনো মুহূর্তে আমাদের সাথে যোগাযোগ করতে এবং জানাতে মুক্ত। আমরা লিঙ্কগুলি সরানোর অনুরোধগুলি বিবেচনা করব তবে আমরা আপনাকে সরাসরি প্রতিক্রিয়া জানাতে বাধ্য নই।</p>
                    <p class="mt-2 text-justify">আমরা নিশ্চিত করি না যে এই ওয়েবসাইটের তথ্য সঠিক, আমরা এর সম্পূর্ণতা বা নির্ভুলতার নিশ্চয়তা দিই না; অথবা আমরা নিশ্চিত করার প্রতিশ্রুতি দিই না যে ওয়েবসাইটটি উপলব্ধ থাকে বা ওয়েবসাইটের উপাদানগুলি আপ টু ডেট রাখা হয়।</p>
                </div>
                <div class="mt-4">
                    <div class="title-wrapper">
                        <span class="title">ডিসক্লেইমার</span>
                    </div>
                    <p class="font-medium mb-2 mt-3">প্রযোজ্য আইন দ্বারা অনুমোদিত সর্বাধিক পরিমাণে, আমরা আমাদের ওয়েবসাইট এবং এই ওয়েবসাইটের ব্যবহার সম্পর্কিত সমস্ত উপস্থাপনা, ওয়ারেন্টি এবং শর্তাবলী বাদ দিই। এই দাবিত্যাগের কিছুই হবে না:</p>
                    <ol class="list-decimal list-inside text-gray-600">
                        <li>মৃত্যু বা ব্যক্তিগত আঘাতের জন্য আমাদের বা আপনার দায়বদ্ধতা সীমিত বা বাদ দিন;</li>
                        <li>জালিয়াতি বা প্রতারণামূলক ভুল উপস্থাপনের জন্য আমাদের বা আপনার দায়বদ্ধতাকে সীমাবদ্ধ বা বাদ দিন;</li>
                        <li>প্রযোজ্য আইনের অধীনে অনুমোদিত নয় এমন যেকোন উপায়ে আমাদের বা আপনার দায়বদ্ধতাগুলিকে সীমাবদ্ধ করুন;</li>
                        <li>প্রযোজ্য আইনের অধীনে বাদ দেওয়া যাবে না এমন কোনো আমাদের বা আপনার দায় বাদ দিন।</li>
                    </ol>
                    <p class="font-medium mb-2 mt-3">দায়বদ্ধতার সীমাবদ্ধতা এবং নিষেধাজ্ঞাগুলি এই বিভাগে এবং এই দাবিত্যাগের অন্যত্র সেট করা হয়েছে:</p>
                    <ol class="list-decimal list-inside text-gray-600">
                        <li>পূর্ববর্তী অনুচ্ছেদ সাপেক্ষে;</li>
                        <li>দাবিত্যাগের অধীনে উদ্ভূত সমস্ত দায়গুলিকে নিয়ন্ত্রণ করে, যার মধ্যে চুক্তিতে উদ্ভূত দায়, নির্যাতন এবং বিধিবদ্ধ দায়িত্ব লঙ্ঘনের জন্য।</li>
                    </ol>
                    <p class="mt-2 text-justify">যতক্ষণ ওয়েবসাইট এবং ওয়েবসাইটের তথ্য ও পরিষেবাগুলি বিনামূল্যে প্রদান করা হয়, ততক্ষণ আমরা কোনও প্রকৃতির ক্ষতি বা ক্ষতির জন্য দায়ী থাকব না।</p>
                </div>
                <div class="mt-4">
                    <div class="title-wrapper">
                        <span class="title">
                            মূল্য বৃদ্ধি বিজ্ঞপ্তি এবং গ্রাহকের বাধ্যবাধকতা
                        </span>
                    </div>
                    <p class="mb-2 mt-3">
                        যখনই DGDA (Directorate General of Drug Administration) দ্বারা নির্ধারিত বিধান অনুযায়ী ঔষধের মূল্য পরিবর্তন হয়, আমাদের সেই তথ্য পেতে এবং ওয়েবসাইটে সেই পরিবর্তন করতে ৫-৭ দিন সময় লেগে যায় ।কোনো গ্রাহক আমাদের সাইট থেকে কোনো ঔষধ ক্রয় করলে এবং তার পরে যদি আমরা মূল্য বৃদ্ধির নোটিশ পাই, আমরা আইন অনুসারে সেই অনুযায়ী ওষুধের দাম বাড়াতে বাধ্য।। অতএব, গ্রাহককে ঔষধের বর্ধিত মূল্য পরিশোধ করতে হবে।
                    </p>
                </div>
            </div>
            {{-- ======./বাংলায় ট্রান্সলেট============ --}}
        </section>
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
