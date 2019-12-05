@auth
<div class="bg-gray-900 shadow-lg h-16 fixed bottom-0 mt-12 md:relative md:h-screen z-10 w-full md:w-48">
    <div class="md:mt-12 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
        <ul class="list-reset flex flex-row md:flex-col py-0 md:py-3 px-1 md:px-2 text-center md:text-left">
            <li class="mr-3 flex-1">
                <a href="{{ route('dashboard') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ Request::is('dashboard') ? 'border-blue-800' : 'border-gray-800' }} hover:border-blue-800">
                    <i class="fas fa-tachometer-alt pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Dashboard</span>
                </a>
            </li>
            <li class="mr-3 flex-1">
                <a href="{{ route('clients') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ Request::is('clients') ? 'border-blue-800' : 'border-gray-800' }} hover:border-blue-800">
                    <i class="fas fa-users pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Clients</span>
                </a>
            </li>
            <li class="mr-3 flex-1">
                <a href="{{ route('invoices') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ Request::is('invoices') ? 'border-blue-800' : 'border-gray-800' }} hover:border-blue-800">
                    <i class="fa fa-file-invoice pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Invoices</span>
                </a>
            </li>
            <li class="mr-3 flex-1">
                <a href="{{ route('subscriptions') }}" class="block py-1 md:py-3 pl-0 md:pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ Request::is('subscriptions') ? 'border-blue-800' : 'border-gray-800' }} hover:border-red-500">
                    <i class="fas fa-redo pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Subscriptions</span>
                </a>
            </li>
            <li class="mr-3 flex-1">
                <a href="{{ route('payments') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ Request::is('payments') ? 'border-blue-800' : 'border-gray-800' }} hover:border-blue-800">
                    <i class="fa fa-wallet pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Payments</span>
                </a>
            </li>
            <li class="mr-3 flex-1">
                <a href="{{ route('products') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ Request::is('products') ? 'border-blue-800' : 'border-gray-800' }} hover:border-blue-800">
                    <i class="fa fa-boxes pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Products</span>
                </a>
            </li>
            <li class="mr-3 flex-1">
                <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ Request::is('commissions') ? 'border-blue-800' : 'border-gray-800' }} hover:border-blue-800">
                    <i class="fa fa-hand-holding-usd pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Commissions</span>
                </a>
            </li>
            <li class="mr-3 flex-1">
                <a href="{{ route('credits') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ Request::is('credits') ? 'border-blue-800' : 'border-gray-800' }} hover:border-blue-800">
                    <i class="fa fa-plus pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Credits</span>
                </a>
            </li>
            <li class="mr-3 flex-1">
                <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ Request::is('reports') ? 'border-blue-800' : 'border-gray-800' }} hover:border-blue-800">
                    <i class="fa fa-chart-line pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Reports</span>
                </a>
            </li>
            <li class="mr-3 flex-1">
                <a href="{{ route('settings') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ Request::is('settings') ? 'border-blue-800' : 'border-gray-800' }} hover:border-blue-800">
                    <i class="fa fa-cogs pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</div>
@endif