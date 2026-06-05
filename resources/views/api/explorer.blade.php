<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - V2T Bookstore API Explorer</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <!-- Tailwind CDN for robust fallback, and custom branding variables -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'v2t-bg': '#f5f4ef',
                        'v2t-green': '#0a3622',
                        'v2t-green-hover': '#062416',
                        'v2t-text': '#1f2937',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Syntax highlighting for JSON */
        .json-key { color: #f43f5e; font-weight: 500; }
        .json-string { color: #10b981; }
        .json-number { color: #f59e0b; }
        .json-boolean { color: #8b5cf6; font-weight: bold; }
        .json-null { color: #6b7280; font-style: italic; }
    </style>
</head>
<body class="bg-v2t-bg text-v2t-text font-sans min-h-screen flex flex-col pb-12">

    <!-- Header Navigation -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto px-4 flex items-center justify-between h-16">
            <div class="flex items-center gap-3">
                <a href="/" class="text-2xl font-serif font-bold text-v2t-green">
                    V2T Bookstore
                </a>
                <span class="text-gray-300">|</span>
                <span class="text-sm font-semibold uppercase tracking-wider text-gray-500">API Explorer</span>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="text-sm font-semibold text-v2t-green hover:underline">
                    Quay lại Web chính
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8 max-w-6xl">
        
        <!-- API Info Header Card -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-serif font-bold text-v2t-green mb-1">{{ $title }}</h1>
                <p class="text-sm text-gray-500">Trình khám phá và thử nghiệm API của V2T Bookstore dành cho lập trình viên.</p>
            </div>
            <div class="flex items-center gap-2 self-start md:self-auto">
                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 font-mono font-bold rounded-lg text-xs">GET</span>
                <span class="px-3 py-1 bg-gray-100 text-gray-700 border border-gray-200 font-mono rounded-lg text-xs tracking-wide">{{ $endpoint }}</span>
            </div>
        </div>

        <!-- API Endpoint Switcher -->
        <div class="flex gap-2 mb-6">
            <a href="{{ url('/api/books') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition border {{ $type === 'books' ? 'bg-v2t-green text-white border-v2t-green' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                📚 Books API
            </a>
            <a href="{{ url('/api/categories') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition border {{ $type === 'categories' ? 'bg-v2t-green text-white border-v2t-green' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                🏷️ Categories API
            </a>
        </div>

        <!-- Explorer Container -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <!-- Tabs Header -->
            <div class="border-b border-gray-100 bg-gray-50/50 flex">
                <button id="btn-visual" onclick="switchTab('visual')" class="px-6 py-4 text-sm font-semibold border-b-2 border-v2t-green text-v2t-green transition focus:outline-none">
                    📊 Dữ liệu trực quan (UI)
                </button>
                <button id="btn-json" onclick="switchTab('json')" class="px-6 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 transition focus:outline-none">
                    💻 Dữ liệu JSON thô
                </button>
            </div>

            <!-- Tab Contents -->
            <div class="p-6">
                <!-- Visual Content -->
                <div id="tab-visual" class="block">
                    @if($type === 'books')
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-100 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                        <th class="py-3 px-4">ID</th>
                                        <th class="py-3 px-4">Ảnh bìa</th>
                                        <th class="py-3 px-4">Tên Sách</th>
                                        <th class="py-3 px-4">Tác Giả</th>
                                        <th class="py-3 px-4">Thể Loại</th>
                                        <th class="py-3 px-4 text-right">Giá Bán</th>
                                        <th class="py-3 px-4 text-center">Tồn Kho</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-sm">
                                    @forelse($data as $book)
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-4 px-4 font-mono text-gray-400">#{{ $book['id'] }}</td>
                                            <td class="py-4 px-4">
                                                @if(!empty($book['image_url']))
                                                    <img src="{{ $book['image_url'] }}" alt="{{ $book['title'] }}" class="w-10 h-14 object-cover rounded shadow-sm">
                                                @else
                                                    <div class="w-10 h-14 bg-gray-100 rounded flex items-center justify-center text-gray-300 text-xs font-bold shadow-sm">
                                                        N/A
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="py-4 px-4 font-semibold text-gray-800">{{ $book['title'] }}</td>
                                            <td class="py-4 px-4 text-gray-600">{{ $book['author'] }}</td>
                                            <td class="py-4 px-4">
                                                <span class="inline-block px-2.5 py-0.5 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full border border-gray-200">
                                                    {{ $book['category']['name'] ?? 'Chưa rõ' }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-4 text-right font-bold text-amber-600">{{ number_format($book['price']) }}đ</td>
                                            <td class="py-4 px-4 text-center">
                                                @if($book['stock'] > 10)
                                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 px-2 py-1 rounded-md border border-emerald-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>{{ $book['stock'] }} (Còn hàng)
                                                    </span>
                                                @elseif($book['stock'] > 0)
                                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-700 bg-amber-50 px-2 py-1 rounded-md border border-amber-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>{{ $book['stock'] }} (Sắp hết)
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-700 bg-rose-50 px-2 py-1 rounded-md border border-rose-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Hết hàng
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-12 text-center text-gray-400 font-medium">Chưa có dữ liệu sách nào được lưu trữ.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @elseif($type === 'categories')
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-100 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                        <th class="py-3 px-4">ID</th>
                                        <th class="py-3 px-4">Tên Thể Loại</th>
                                        <th class="py-3 px-4">Mô Tả</th>
                                        <th class="py-3 px-4 text-right">Ngày Tạo</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-sm">
                                    @forelse($data as $cat)
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-4 px-4 font-mono text-gray-400">#{{ $cat['id'] }}</td>
                                            <td class="py-4 px-4 font-semibold text-teal-700">{{ $cat['name'] }}</td>
                                            <td class="py-4 px-4 text-gray-500">{{ $cat['description'] ?? 'Chưa có mô tả' }}</td>
                                            <td class="py-4 px-4 text-right font-mono text-gray-400">{{ date('d-m-Y H:i', strtotime($cat['created_at'])) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-12 text-center text-gray-400 font-medium">Chưa có dữ liệu thể loại nào được lưu trữ.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- JSON Content -->
                <div id="tab-json" class="hidden">
                    <pre class="bg-gray-900 border border-gray-800 rounded-xl p-6 overflow-x-auto max-h-[600px] text-gray-100 font-mono text-xs md:text-sm leading-relaxed"><code id="json-renderer"></code></pre>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="mt-auto border-t border-gray-200 py-6 text-center text-sm text-gray-400 bg-white">
        &copy; {{ date('Y') }} V2T Bookstore API Portal. Phát triển bởi Antigravity.
    </footer>

    <script>
        // Lấy dữ liệu PHP truyền sang JS
        const rawJsonData = @json($raw_data);

        // Chuyển đổi tab
        function switchTab(type) {
            const visualTab = document.getElementById('tab-visual');
            const jsonTab = document.getElementById('tab-json');
            const btnVisual = document.getElementById('btn-visual');
            const btnJson = document.getElementById('btn-json');

            if (type === 'visual') {
                visualTab.classList.remove('hidden');
                visualTab.classList.add('block');
                jsonTab.classList.remove('block');
                jsonTab.classList.add('hidden');

                btnVisual.className = "px-6 py-4 text-sm font-semibold border-b-2 border-v2t-green text-v2t-green transition focus:outline-none";
                btnJson.className = "px-6 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 transition focus:outline-none";
            } else {
                visualTab.classList.remove('block');
                visualTab.classList.add('hidden');
                jsonTab.classList.remove('hidden');
                jsonTab.classList.add('block');

                btnVisual.className = "px-6 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 transition focus:outline-none";
                btnJson.className = "px-6 py-4 text-sm font-semibold border-b-2 border-v2t-green text-v2t-green transition focus:outline-none";
            }
        }

        // Hàm tô màu Syntax Highlight cho JSON
        function syntaxHighlight(json) {
            if (typeof json != 'string') {
                 json = JSON.stringify(json, undefined, 4);
            }
            json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+-]?\d+)?)/g, function (match) {
                var cls = 'number';
                if (/^"/.test(match)) {
                    if (/:$/.test(match)) {
                        cls = 'key';
                    } else {
                        cls = 'string';
                    }
                } else if (/true|false/.test(match)) {
                    cls = 'boolean';
                } else if (/null/.test(match)) {
                    cls = 'null';
                }
                return '<span class="json-' + cls + '">' + match + '</span>';
            });
        }

        // Đổ JSON đã tô màu vào thẻ <code>
        document.getElementById('json-renderer').innerHTML = syntaxHighlight(rawJsonData);
    </script>
</body>
</html>
