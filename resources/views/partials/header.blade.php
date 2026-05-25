<header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="container mx-auto px-4 flex items-center justify-between gap-4 md:gap-8 h-16">
        
        <a href="/" class="text-3xl font-serif font-bold text-v2t-green shrink-0">
            V2T Bookstore
        </a>

        <div class="hidden lg:flex items-center h-full group cursor-pointer">
            <div class="flex items-center gap-2 text-gray-600 group-hover:text-v2t-green transition">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <svg class="w-4 h-4 text-gray-400 group-hover:text-v2t-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"  stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>

            <div class="absolute left-0 top-full w-full bg-white border-t border-gray-200 shadow-2xl opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 ease-in-out z-50">
                <div class="container mx-auto flex h-112.5">
                    
                    <div class="w-1/4 border-r border-gray-100 py-6 pr-4 bg-gray-50/50">
                        <h3 class="font-bold text-lg mb-4 px-4 text-gray-800">Danh mục sản phẩm</h3>
                        <ul class="text-sm font-medium text-gray-600">
                            @foreach($categories as $cat)
                            <li class="px-4 py-2.5 hover:bg-white hover:text-v2t-green rounded cursor-pointer flex justify-between items-center transition">
                                {{ $cat->name }} <span class="text-lg leading-none">›</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="w-3/4 py-6 pl-8 pr-4 overflow-y-auto">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="bg-red-500 w-5 h-5 rounded-sm flex items-center justify-center text-white text-xs font-bold">VN</span>
                            <h3 class="font-bold text-xl text-gray-800">Sách Trong Nước</h3>
                        </div>
                        
                        <div class="grid grid-cols-4 gap-x-6 gap-y-8">
                            <div>
                                <h4 class="font-bold text-sm text-gray-800 mb-3 uppercase">Văn Học</h4>
                                <ul class="space-y-2 text-[13px] text-gray-500">
                                    <li><a href="#" class="hover:text-v2t-green transition">Tiểu Thuyết</a></li>
                                    <li><a href="#" class="hover:text-v2t-green transition">Truyện Ngắn - Tản Văn</a></li>
                                    <li><a href="#" class="hover:text-v2t-green transition">Light Novel</a></li>
                                    <li><a href="#" class="hover:text-v2t-green transition">Ngôn Tình</a></li>
                                </ul>
                                <a href="#" class="text-blue-500 hover:text-blue-700 text-xs mt-2 inline-block">Xem tất cả</a>
                            </div>

                            <div>
                                <h4 class="font-bold text-sm text-gray-800 mb-3 uppercase">Kinh Tế</h4>
                                <ul class="space-y-2 text-[13px] text-gray-500">
                                    <li><a href="#" class="hover:text-v2t-green transition">Nhân Vật - Bài Học Kinh Doanh</a></li>
                                    <li><a href="#" class="hover:text-v2t-green transition">Quản Trị - Lãnh Đạo</a></li>
                                    <li><a href="#" class="hover:text-v2t-green transition">Marketing - Bán Hàng</a></li>
                                    <li><a href="#" class="hover:text-v2t-green transition">Phân Tích Kinh Tế</a></li>
                                </ul>
                                <a href="#" class="text-blue-500 hover:text-blue-700 text-xs mt-2 inline-block">Xem tất cả</a>
                            </div>

                            <div>
                                <h4 class="font-bold text-sm text-gray-800 mb-3 uppercase">Tâm Lý - Kỹ Năng Sống</h4>
                                <ul class="space-y-2 text-[13px] text-gray-500">
                                    <li><a href="#" class="hover:text-v2t-green transition">Kỹ Năng Sống</a></li>
                                    <li><a href="#" class="hover:text-v2t-green transition">Rèn Luyện Nhân Cách</a></li>
                                    <li><a href="#" class="hover:text-v2t-green transition">Tâm Lý</a></li>
                                    <li><a href="#" class="hover:text-v2t-green transition">Sách Cho Tuổi Mới Lớn</a></li>
                                </ul>
                                <a href="#" class="text-blue-500 hover:text-blue-700 text-xs mt-2 inline-block">Xem tất cả</a>
                            </div>

                            <div>
                                <h4 class="font-bold text-sm text-gray-800 mb-3 uppercase">Nuôi Dạy Con</h4>
                                <ul class="space-y-2 text-[13px] text-gray-500">
                                    <li><a href="#" class="hover:text-v2t-green transition">Cẩm Nang Làm Cha Mẹ</a></li>
                                    <li><a href="#" class="hover:text-v2t-green transition">Phương Pháp Giáo Dục Trẻ</a></li>
                                    <li><a href="#" class="hover:text-v2t-green transition">Phát Triển Trí Tuệ Cho Trẻ</a></li>
                                </ul>
                                <a href="#" class="text-blue-500 hover:text-blue-700 text-xs mt-2 inline-block">Xem tất cả</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <form action="{{ route('shop.index') }}" method="GET" class="flex flex-1 max-w-xl mx-8 border border-gray-200 rounded-lg overflow-hidden bg-white shadow-sm focus-within:border-v2t-green">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            
            <input type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Tìm kiếm tựa sách, tác giả, nhà xuất bản..." 
                class="w-full px-4 py-2 text-sm text-gray-700 focus:outline-none bg-transparent">
            
            <button type="submit" class="bg-v2t-green hover:opacity-95 px-5 text-white transition flex items-center justify-center focus:outline-none">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </form>

        <div class="hidden md:flex items-center gap-6">
            <div class="flex flex-col items-center cursor-pointer text-gray-600 hover:text-v2t-green transition">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="text-[11px] font-medium">Thông Báo</span>
            </div>
            
            <a href="{{ route('cart.index') }}" class="flex flex-col items-center cursor-pointer text-gray-600 hover:text-v2t-green transition relative">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                
                <span class="absolute top-0 right-0 -mt-1 -mr-3 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none">
                    {{ count(session('cart', [])) }}
                </span>
                
                <span class="text-[11px] font-medium">Giỏ Hàng</span>
            </a>

            @guest
            <a href="{{ route('login') }}" class="flex flex-col items-center cursor-pointer text-gray-600 hover:text-v2t-green transition">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span class="text-[11px] font-medium">Tài Khoản</span>
            </a>
            @endguest
            @auth
                <div class="relative" style="display: inline-block;">
                    
                    <button type="button" onclick="toggleUserDropdown(event)" class="flex items-center gap-1.5 py-2 text-sm font-medium text-gray-700 hover:text-[var(--color-v2t-green)] transition focus:outline-none cursor-pointer border-none bg-transparent">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>{{ Auth::user()->name }}</span>
                        
                        <svg id="dropdown-arrow" class="w-3.5 h-3.5 opacity-60 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div id="user-dropdown-menu" class="absolute right-0 w-44 bg-white border border-gray-200 rounded-lg shadow-lg py-1 mt-1 z-50" style="display: none; position: absolute; right: 0; top: 100%; width: 11rem; background-color: white; border: 1px solid #e5e7eb; border-radius: 8px; padding-top: 4px; padding-bottom: 4px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                        
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-[var(--color-v2t-green)] transition" style="text-decoration: none; display: block; padding: 8px 16px; font-size: 0.75rem; color: #374151; font-weight: 700;">
                            👤 Hồ sơ cá nhân
                        </a>
                        
                        <div style="border-top: 1px solid #f3f4f6; margin-top: 4px; margin-bottom: 4px;"></div>

                        <form action="{{ route('logout') }}" method="POST" class="m-0" style="margin: 0;">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50/60 transition focus:outline-none cursor-pointer border-none bg-transparent" style="width: 100%; text-align: left; display: block; padding: 8px 16px; font-size: 0.75rem; color: #dc2626; font-weight: 700; border: none; background: transparent; cursor: pointer;">
                                🚪 Đăng xuất
                            </button>
                        </form>
                        
                    </div>
                </div>

                <script>
                    function toggleUserDropdown(event) {
                        // Ngăn chặn sự kiện click lan ra ngoài cửa sổ gây đóng menu lập tức
                        event.stopPropagation(); 
                        
                        const menu = document.getElementById('user-dropdown-menu');
                        const arrow = document.getElementById('dropdown-arrow');
                        
                        if (menu.style.display === 'none' || menu.style.display === '') {
                            menu.style.display = 'block';
                            arrow.style.transform = 'rotate(180deg)';
                        } else {
                            menu.style.display = 'none';
                            arrow.style.transform = 'rotate(0deg)';
                        }
                    }

                    // Tự động đóng menu ẩn đi khi người dùng click ra bất kỳ vùng nào khác ngoài màn hình
                    window.addEventListener('click', function(e) {
                        const menu = document.getElementById('user-dropdown-menu');
                        const arrow = document.getElementById('dropdown-arrow');
                        
                        if (menu && menu.style.display === 'block') {
                            menu.style.display = 'none';
                            arrow.style.transform = 'rotate(0deg)';
                        }
                    });
                </script>
            @endauth
        </div>
    </div>
</header>