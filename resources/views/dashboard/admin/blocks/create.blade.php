<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Block - Veritas CMS</title>
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
                <h1 class="text-3xl font-bold text-gray-800">Add Content Block</h1>
                <a href="{{ route('admin.pages.blocks.index', $page->id) }}" class="text-gray-600 hover:text-gray-900">Back to Blocks</a>
            </header>

            <div class="bg-white rounded-lg shadow p-6 max-w-4xl">
                <form action="{{ route('admin.pages.blocks.store', $page->id) }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Block Type</label>
                            <select name="type" id="type" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="hero">Hero Section</option>
                                <option value="text">Text / HTML</option>
                                <option value="features">Features Grid</option>
                                <option value="image_text">Image + Text</option>
                                <option value="cta">Call to Action</option>
                                <option value="custom">Custom JSON</option>
                            </select>
                        </div>

                        <div>
                            <label for="identifier" class="block text-gray-700 text-sm font-bold mb-2">Identifier (Optional)</label>
                            <input type="text" name="identifier" id="identifier" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="e.g., homepage-hero-1">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="order" class="block text-gray-700 text-sm font-bold mb-2">Sort Order</label>
                        <input type="number" name="order" id="order" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="0">
                    </div>

                    <div class="mb-6">
                        <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content (JSON)</label>
                        <p class="text-xs text-gray-500 mb-2">Enter valid JSON structure for the block content.</p>
                        <textarea name="content" id="content" rows="10" class="font-mono shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_active" class="form-checkbox h-5 w-5 text-blue-600" checked>
                            <span class="ml-2 text-gray-700">Active</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Save Block
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
