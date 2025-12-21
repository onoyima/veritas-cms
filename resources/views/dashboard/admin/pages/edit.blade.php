<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page - Veritas CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-4 text-xl font-bold border-b border-gray-700">Veritas CMS</div>
            <nav class="flex-1 p-4">
                <ul class="space-y-2">
                    <li><a href="{{ route('admin.dashboard') }}" class="block p-2 rounded hover:bg-gray-700">Dashboard</a></li>
                    <li><a href="{{ route('admin.pages.index') }}" class="block p-2 rounded bg-gray-700">Pages</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <header class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Edit Page: {{ $page->title }}</h1>
                <a href="{{ route('admin.pages.index') }}" class="text-gray-600 hover:text-gray-900">Back to List</a>
            </header>

            <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
                <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Page Title</label>
                        <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required value="{{ old('title', $page->title) }}">
                        @error('title') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="slug" class="block text-gray-700 text-sm font-bold mb-2">Slug</label>
                        <input type="text" name="slug" id="slug" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('slug', $page->slug) }}">
                        @error('slug') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="meta_title" class="block text-gray-700 text-sm font-bold mb-2">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('meta_title', $page->meta_title) }}">
                    </div>

                    <div class="mb-4">
                        <label for="meta_description" class="block text-gray-700 text-sm font-bold mb-2">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('meta_description', $page->meta_description) }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_active" class="form-checkbox h-5 w-5 text-blue-600" {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Active</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update Page
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
