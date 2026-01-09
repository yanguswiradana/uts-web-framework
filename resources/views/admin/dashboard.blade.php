<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex flex-col md:flex-row">
        <div class="bg-gray-800 shadow-xl h-16 fixed bottom-0 md:relative md:h-screen z-10 w-full md:w-64">
            <div class="md:mt-12 md:w-64 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
                <div class="p-4 text-white font-bold text-xl">Admin Panel</div>
                <ul class="list-reset flex flex-row md:flex-col py-0 md:py-3 px-1 md:px-2 text-center md:text-left">
                    <li class="mr-3 flex-1">
                        <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-blue-600">
                            <span class="pb-1 md:pb-0 text-xs md:text-base text-white block md:inline-block">Dashboard</span>
                        </a>
                    </li>
                    <li class="mr-3 flex-1">
                        <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-400 no-underline hover:text-white border-b-2 border-gray-800 hover:border-pink-500 transition">
                            <span class="pb-1 md:pb-0 text-xs md:text-base block md:inline-block">Users</span>
                        </a>
                    </li>
                    <li class="mr-3 flex-1">
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left py-1 md:py-3 pl-1 align-middle text-gray-400 no-underline hover:text-red-500 border-b-2 border-gray-800 hover:border-red-500 transition">
                                <span class="pb-1 md:pb-0 text-xs md:text-base block md:inline-block">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-2 pb-24 md:pb-5">
            <div class="bg-blue-600 p-2 shadow text-xl text-white">
                <h3 class="font-bold pl-2">Dashboard</h3>
            </div>

            <div class="flex flex-wrap p-6">
                <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                    <div class="bg-white border-b-4 border-green-500 rounded-lg shadow-xl p-5">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded-full p-5 bg-green-600"><i class="fa fa-wallet fa-2x fa-inverse"></i></div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <h5 class="font-bold uppercase text-gray-600">Total User</h5>
                                <h3 class="font-bold text-3xl">152</h3>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>

</body>
</html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex flex-col md:flex-row">
        <div class="bg-gray-800 shadow-xl h-16 fixed bottom-0 md:relative md:h-screen z-10 w-full md:w-64">
            <div class="md:mt-12 md:w-64 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
                <div class="p-4 text-white font-bold text-xl">Admin Panel</div>
                <ul class="list-reset flex flex-row md:flex-col py-0 md:py-3 px-1 md:px-2 text-center md:text-left">
                    <li class="mr-3 flex-1">
                        <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-blue-600">
                            <span class="pb-1 md:pb-0 text-xs md:text-base text-white block md:inline-block">Dashboard</span>
                        </a>
                    </li>
                    <li class="mr-3 flex-1">
                        <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-400 no-underline hover:text-white border-b-2 border-gray-800 hover:border-pink-500 transition">
                            <span class="pb-1 md:pb-0 text-xs md:text-base block md:inline-block">Users</span>
                        </a>
                    </li>
                    <li class="mr-3 flex-1">
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left py-1 md:py-3 pl-1 align-middle text-gray-400 no-underline hover:text-red-500 border-b-2 border-gray-800 hover:border-red-500 transition">
                                <span class="pb-1 md:pb-0 text-xs md:text-base block md:inline-block">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-2 pb-24 md:pb-5">
            <div class="bg-blue-600 p-2 shadow text-xl text-white">
                <h3 class="font-bold pl-2">Dashboard</h3>
            </div>

            <div class="flex flex-wrap p-6">
                <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                    <div class="bg-white border-b-4 border-green-500 rounded-lg shadow-xl p-5">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded-full p-5 bg-green-600"><i class="fa fa-wallet fa-2x fa-inverse"></i></div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <h5 class="font-bold uppercase text-gray-600">Total User</h5>
                                <h3 class="font-bold text-3xl">152</h3>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>

</body>
</html>