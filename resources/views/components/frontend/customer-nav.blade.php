<div>
   <div class="card border py-2 flex flex-col space-y-2 shadow-lg sm:shadow-lg md:shadow-lg lg:shadow-none xl:shadow-none 2xl:shadow-none">
        <a href="{{ route('my.dashboard') }}" class="{{ Route::currentRouteName() == 'my.dashboard' ? 'bg-primary-lightest' : '' }} py-1 sm:py-1 md:py-2 px-4 hover:bg-primary-lightest transition duration-300 flex items-center space-x-4">
            <span class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded text-primary"><i class="fa-solid fa-gauge"></i></span>
            <span class="font-medium text-primary text-sm sm:text-sm md:text-base">Dashboard</span>
        </a>
        <a href="{{ route('my.order') }}" class="{{ Route::currentRouteName() == 'my.order' ? 'bg-primary-lightest' : '' }} py-1 sm:py-1 md:py-2 px-4 hover:bg-primary-lightest transition duration-300 flex items-center space-x-4">
            <span class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded text-primary"><i class="fa-solid fa-cart-shopping"></i></span><span class="font-medium text-primary text-sm sm:text-sm md:text-base">Order</span>
        </a>
        <a href="{{ route('my.address') }}" class="{{ Route::currentRouteName() == 'my.address' ? 'bg-primary-lightest' : '' }} py-1 sm:py-1 md:py-2 px-4 hover:bg-primary-lightest transition duration-300 flex items-center space-x-4">
            <span class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded text-primary"><i class="fa-solid fa-location-dot"></i></span><span class="font-medium text-primary text-sm sm:text-sm md:text-base">Address</span>
        </a>
        <a href="{{ route('my.profile') }}" class="{{ Route::currentRouteName() == 'my.profile' ? 'bg-primary-lightest' : '' }} py-1 sm:py-1 md:py-2 px-4 hover:bg-primary-lightest transition duration-300 flex items-center space-x-4">
            <span class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded text-primary"><i class="fa-solid fa-user"></i></span><span class="font-medium text-primary text-sm sm:text-sm md:text-base">Profile</span>
        </a>
    </div>
</div>
