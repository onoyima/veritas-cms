<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blocks - {{ $page->title }}</title>
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
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Content Blocks</h1>
                    <p class="text-gray-600 mt-2">Managing content for page: <strong>{{ $page->title }}</strong></p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('admin.pages.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Back to Pages
                    </a>
                    <a href="{{ route('admin.pages.blocks.create', $page->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        + Add New Block
                    </a>
                </div>
            </header>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">
                @forelse($blocks as $block)
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ strtoupper($block->type) }}</span>
                                <h3 class="text-lg font-bold text-gray-800">{{ $block->identifier ?? 'No Identifier' }}</h3>
                                @if(!$block->is_active)
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Inactive</span>
                                @endif
                            </div>
                            <div class="text-sm text-gray-500 font-mono bg-gray-50 p-2 rounded border">
                                Order: {{ $block->order }}
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.blocks.edit', $block->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                            <form action="{{ route('admin.blocks.destroy', $block->id) }}" method="POST" onsubmit="return confirm('Delete this block?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <details>
                            <summary class="cursor-pointer text-sm text-gray-500 hover:text-gray-700">View Content Preview</summary>
                            <pre class="mt-2 text-xs bg-gray-800 text-green-400 p-4 rounded overflow-x-auto">{{ json_encode($block->content, JSON_PRETTY_PRINT) }}</pre>
                        </details>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <p class="text-gray-500 text-lg">No content blocks found for this page.</p>
                    <a href="{{ route('admin.pages.blocks.create', $page->id) }}" class="inline-block mt-4 text-blue-600 hover:underline">Create your first block</a>
                </div>
                @endforelse
            </div>
        </main>
    </div>
</body>
</html>
