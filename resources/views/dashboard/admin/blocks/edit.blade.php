<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Block - Veritas CMS</title>
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
                <h1 class="text-3xl font-bold text-gray-800">Edit Block</h1>
                <a href="{{ route('admin.pages.blocks.index', $block->page_id) }}" class="text-gray-600 hover:text-gray-900">Back to Blocks</a>
            </header>

            <div class="bg-white rounded-lg shadow p-6 max-w-4xl">
                <form action="{{ route('admin.blocks.update', $block->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Block Type</label>
                            <input type="text" name="type" id="type" value="{{ old('type', $block->type) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div>
                            <label for="identifier" class="block text-gray-700 text-sm font-bold mb-2">Identifier (Optional)</label>
                            <input type="text" name="identifier" id="identifier" value="{{ old('identifier', $block->identifier) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="order" class="block text-gray-700 text-sm font-bold mb-2">Sort Order</label>
                        <input type="number" name="order" id="order" value="{{ old('order', $block->order) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-6">
                        <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content (JSON)</label>
                        <p class="text-xs text-gray-500 mb-2">Enter valid JSON structure for the block content.</p>
                        <textarea name="content" id="content" rows="15" class="font-mono shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('content', json_encode($block->content, JSON_PRETTY_PRINT)) }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_active" class="form-checkbox h-5 w-5 text-blue-600" {{ old('is_active', $block->is_active) ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Active</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update Block
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
