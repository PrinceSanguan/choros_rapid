<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online Project Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome to Online Project Management System</h1>
            <p class="text-lg text-gray-600 mb-8">Your new project is ready to go!</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Login</a>
                <a href="#" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Learn More</a>
            </div>
        </div>
    </div>
</body>
</html>
