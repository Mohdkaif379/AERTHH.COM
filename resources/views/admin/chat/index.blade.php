@extends('layout.app')

@section('title', 'Chat Support')
@section('page-title', 'Chat Support')
@section('page-subtitle', 'Manage customer inquiries and support requests')

@section('content')
<div class="h-[calc(100vh-140px)] flex flex-col md:flex-row bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    
    {{-- Sidebar: Chat List --}}
    <div class="w-full md:w-1/3 flex flex-col border-r border-slate-100 bg-slate-50/50">
        {{-- Search / Header --}}
        <div class="p-4 border-b border-slate-100 bg-white">
            <div class="relative">
                <input type="text" id="searchChats" placeholder="Search customers..." 
                    class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-sky-400 focus:ring-1 focus:ring-sky-400 bg-slate-50 relative z-10 transition-colors">
                <i class="fa-solid fa-search absolute left-3.5 top-3 text-slate-400 text-sm z-20"></i>
            </div>
        </div>

        {{-- Conversations List --}}
        <div id="chatsList" class="flex-1 overflow-y-auto w-full p-2 space-y-1">
            <div class="flex flex-col items-center justify-center h-40 text-slate-400">
                <i class="fa-solid fa-spinner fa-spin text-2xl mb-2 text-sky-400"></i>
                <span class="text-sm">Loading chats...</span>
            </div>
            <!-- Chat Items injected via JS -->
        </div>
    </div>

    {{-- Main Chat Area --}}
    <div class="w-full md:w-2/3 flex flex-col bg-white hidden md:flex" id="activeChatArea">
        
        {{-- Empty State (Default) --}}
        <div id="emptyChatState" class="flex-1 flex flex-col items-center justify-center bg-slate-50/50 text-slate-400">
            <div class="w-24 h-24 bg-sky-50 rounded-full flex items-center justify-center mb-4">
                <i class="fa-regular fa-comments text-4xl text-sky-400"></i>
            </div>
            <h3 class="text-lg font-medium text-slate-600">No Chat Selected</h3>
            <p class="text-sm mt-1">Select a customer from the list to start messaging</p>
        </div>

        {{-- Active Chat Workspace --}}
        <div id="chatWorkspace" class="hidden flex-1 flex flex-col h-full">
            {{-- Chat Header --}}
            <div class="h-16 border-b border-slate-100 px-6 flex items-center justify-between shrink-0 bg-white">
                <div class="flex items-center gap-3">
                    <button class="md:hidden text-slate-400 hover:text-slate-600 mr-2" id="backToChatsBtn">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 text-white flex items-center justify-center font-bold text-sm shadow-sm" id="chatHeaderInitials">
                        -
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-800 text-sm" id="chatHeaderName">Loading...</h3>
                        <p class="text-xs text-emerald-500 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Active
                        </p>
                    </div>
                </div>
            </div>

            {{-- Messages Area --}}
            <div id="chatMessages" class="flex-1 overflow-y-auto p-4 md:p-6 bg-[#f8fafc] space-y-4">
                <!-- Messages injected via JS -->
            </div>

            {{-- Input Area --}}
            <div class="p-4 bg-white border-t border-slate-100 shrink-0">
                <form id="replyForm" class="flex items-end gap-2" onsubmit="handleReplySubmit(event)">
                    <div class="flex-1 bg-slate-50 border border-slate-200 rounded-2xl overflow-hidden focus-within:border-sky-400 focus-within:ring-1 focus-within:ring-sky-400 transition-all">
                        <textarea id="replyMessage" rows="1" placeholder="Type your reply here..." 
                            class="w-full max-h-32 p-3 bg-transparent border-none outline-none resize-none text-sm text-slate-700 placeholder-slate-400"
                            oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>
                    </div>
                    <button type="submit" id="sendReplyBtn" disabled
                        class="h-[46px] px-5 rounded-2xl bg-gradient-to-r from-sky-500 to-blue-600 text-white font-medium text-sm flex items-center gap-2 shadow-md hover:shadow-lg transition-transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <span>Send</span>
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@stack('styles')
<style>
    /* Message scrolling tweaks */
    #chatMessages::-webkit-scrollbar {
        width: 4px;
    }
    #chatMessages::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 4px;
    }
    .chat-item.active {
        background: linear-gradient(to right, #f0f9ff, #ffffff);
        border-left: 3px solid #0ea5e9;
    }
</style>

@push('scripts')
<script>
    const MAIN_API_BASE = '{{ url("/api") }}';
    const ADMIN_ID = {{ session('admin_id', 1) }}; 

    let currentCustomerId = null;
    let chatsInterval = null;
    let activeChatInterval = null;

    document.addEventListener('DOMContentLoaded', () => {
        loadConversations();
        
        // Auto-refresh chat list every 15s
        chatsInterval = setInterval(loadConversations, 15000);

        // Enter key to submit
        const textarea = document.getElementById('replyMessage');
        const sendBtn = document.getElementById('sendReplyBtn');

        textarea.addEventListener('input', () => {
            sendBtn.disabled = textarea.value.trim() === '';
        });

        textarea.addEventListener('keydown', (e) => {
            if(e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                handleReplySubmit(e);
            }
        });

        // Mobile back button
        document.getElementById('backToChatsBtn').addEventListener('click', () => {
            document.querySelector('.md\\:w-1\\/3').classList.remove('hidden');
            document.getElementById('activeChatArea').classList.add('hidden');
            document.getElementById('activeChatArea').classList.remove('flex');
            currentCustomerId = null;
            if (activeChatInterval) clearInterval(activeChatInterval);
            document.querySelectorAll('.chat-item').forEach(el => el.classList.remove('active'));
        });

        // Search
        document.getElementById('searchChats').addEventListener('input', (e) => {
            const val = e.target.value.toLowerCase();
            document.querySelectorAll('.chat-item').forEach(el => {
                const name = el.getAttribute('data-name').toLowerCase();
                el.style.display = name.includes(val) ? 'flex' : 'none';
            });
        });
    });

    async function loadConversations() {
        try {
            const res = await fetch(`${MAIN_API_BASE}/admin/chats`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            
            if (data.success) {
                renderConversations(data.data);
            }
        } catch (error) {
            console.error('Error loading conversations:', error);
            if(document.getElementById('chatsList').innerHTML.includes('spinner')) {
                document.getElementById('chatsList').innerHTML = '<div class="p-4 text-center text-red-400 text-sm">Failed to load chats.</div>';
            }
        }
    }

    function renderConversations(chats) {
        const list = document.getElementById('chatsList');
        if (!chats || chats.length === 0) {
            list.innerHTML = '<div class="p-8 text-center text-slate-400 text-sm">No conversations found.</div>';
            return;
        }

        let html = '';
        chats.forEach(chat => {
            const customer = chat.customer;
            const name = customer ? `${customer.first_name} ${customer.last_name}` : 'Unknown Customer';
            const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            
            // Time formatting
            const date = new Date(chat.last_time);
            const isToday = new Date().toDateString() === date.toDateString();
            const timeStr = isToday ? date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : date.toLocaleDateString([], {month:'short', day:'numeric'});

            const isActive = currentCustomerId == chat.customer_id ? 'active' : 'border-l-[3px] border-transparent cursor-pointer hover:bg-slate-50';
            
            const unreadBadge = chat.unread_count > 0 
                ? `<span class="bg-sky-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0">${chat.unread_count}</span>` 
                : '';

            const lastMsg = chat.last_message.length > 35 ? chat.last_message.substring(0, 35) + '...' : chat.last_message;

            html += `
                <div class="chat-item flex items-start gap-3 p-3 rounded-lg transition-colors ${isActive}" 
                     data-name="${name}" 
                     data-initials="${initials}"
                     onclick="openChat(${chat.customer_id}, '${name}', '${initials}')">
                    
                    <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold text-xs shrink-0 relative mt-0.5">
                        ${initials}
                        ${chat.unread_count > 0 ? '<span class="absolute top-0 right-0 w-2.5 h-2.5 bg-sky-500 border border-white rounded-full"></span>' : ''}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline mb-0.5">
                            <h4 class="font-semibold text-slate-800 text-sm truncate pr-2">${name}</h4>
                            <span class="text-[10px] text-slate-400 shrink-0">${timeStr}</span>
                        </div>
                        <div class="flex justify-between items-center gap-2">
                            <p class="text-xs ${chat.unread_count > 0 ? 'text-slate-800 font-medium' : 'text-slate-500'} truncate">${lastMsg}</p>
                            ${unreadBadge}
                        </div>
                    </div>
                </div>
            `;
        });

        // Ensure we don't lose the search state and maintain the active highlighted item
        list.innerHTML = html;
        
        // Re-trigger search filter
        const currentSearch = document.getElementById('searchChats').value.toLowerCase();
        if(currentSearch) {
            document.querySelectorAll('.chat-item').forEach(el => {
                const name = el.getAttribute('data-name').toLowerCase();
                el.style.display = name.includes(currentSearch) ? 'flex' : 'none';
            });
        }
    }

    async function openChat(customerId, name, initials) {
        // Agar same customer par click kiya hai, toh spinner mat dikhao, bas mobile me view toggle karo
        if (currentCustomerId === customerId) {
            if (window.innerWidth < 768) {
                document.querySelector('.md\\:w-1\\/3').classList.add('hidden');
                document.getElementById('activeChatArea').classList.remove('hidden');
                document.getElementById('activeChatArea').classList.add('flex');
            }
            return;
        }

        currentCustomerId = customerId;
        
        // Update UI state
        document.querySelectorAll('.chat-item').forEach(el => {
            el.classList.remove('active', 'bg-slate-50', 'border-transparent');
            el.classList.add('border-transparent');
            if (el.getAttribute('onclick').includes(`(${customerId},`)) {
                el.classList.remove('border-transparent', 'hover:bg-slate-50');
                el.classList.add('active');
            }
        });

        // Mobile specific logic
        if (window.innerWidth < 768) {
            document.querySelector('.md\\:w-1\\/3').classList.add('hidden');
            document.getElementById('activeChatArea').classList.remove('hidden');
            document.getElementById('activeChatArea').classList.add('flex');
        }

        // Toggle Workspace Panels
        document.getElementById('emptyChatState').classList.add('hidden');
        document.getElementById('chatWorkspace').classList.remove('hidden');
        
        // Set Header
        document.getElementById('chatHeaderName').textContent = name;
        document.getElementById('chatHeaderInitials').textContent = initials;
        
        // Loading animation in chat area
        const container = document.getElementById('chatMessages');
        container.innerHTML = '<div class="flex justify-center p-8"><i class="fa-solid fa-spinner fa-spin text-sky-400 text-xl"></i></div>';
        container.removeAttribute('data-last-html'); // Cache clear karo takki next render miss na ho
        
        // Clear interval for previous chat and start for new one
        if (activeChatInterval) clearInterval(activeChatInterval);
        
        await fetchChatMessages();
        markAsRead(customerId);

        // Auto-refresh active chat messages
        activeChatInterval = setInterval(fetchChatMessages, 3000);
    }

    async function fetchChatMessages() {
        if (!currentCustomerId) return;

        try {
            const res = await fetch(`${MAIN_API_BASE}/admin/chats/${currentCustomerId}`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            
            if (data.success) {
                renderMessages(data.data);
            }
        } catch (error) {
            console.error('Error fetching chat messages:', error);
        }
    }

    function renderMessages(messages) {
        const container = document.getElementById('chatMessages');
        let html = '';
        
        // Keep track of scroll height before rendering
        const wasAtBottom = container.scrollHeight - container.clientHeight <= container.scrollTop + 50;

        messages.forEach(msg => {
            const time = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            
            if (msg.sender_type === 'customer') {
                html += `
                    <div class="flex items-end gap-2 max-w-[85%]">
                        <div class="w-7 h-7 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-[10px] shrink-0 mb-5">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="flex flex-col gap-1 items-start">
                            <div class="bg-white p-3 rounded-2xl rounded-bl-sm border border-slate-200 shadow-sm text-[13px] text-slate-700 leading-relaxed whitespace-pre-wrap">
                                ${msg.message}
                            </div>
                            <span class="text-[10px] text-slate-400 ml-1">${time}</span>
                        </div>
                    </div>
                `;
            } else {
                const readIcon = msg.is_read 
                    ? '<i class="fa-solid fa-check-double text-sky-500 ml-1"></i>' 
                    : '<i class="fa-solid fa-check text-slate-400 ml-1"></i>';

                html += `
                    <div class="flex items-end gap-2 max-w-[85%] ml-auto justify-end">
                        <div class="flex flex-col gap-1 items-end">
                            <div class="bg-gradient-to-br from-sky-500 to-blue-600 p-3 rounded-2xl rounded-br-sm shadow border border-sky-400/50 text-[13px] text-white leading-relaxed whitespace-pre-wrap">
                                ${msg.message}
                            </div>
                            <span class="text-[10px] text-slate-400 mr-1 flex items-center gap-1">${time} ${readIcon}</span>
                        </div>
                    </div>
                `;
            }
        });

        // Only update DOM if HTML changed (prevents flicker)
        if (container.getAttribute('data-last-html') !== html) {
            container.innerHTML = html;
            container.setAttribute('data-last-html', html);
            
            // Auto scroll to bottom
            if (wasAtBottom || document.getElementById('replyMessage').value.trim() !== '') {
                container.scrollTop = container.scrollHeight;
            }
        }
    }

    async function markAsRead(customerId) {
        try {
            await fetch(`${MAIN_API_BASE}/admin/chats/${customerId}/read`, {
                method: 'PATCH',
                headers: { 'Accept': 'application/json' }
            });
            // Immediately reload lists to update badges without waiting for 15s interval
            loadConversations();
        } catch(e) { console.error('Mark read failed', e); }
    }

    async function handleReplySubmit(e) {
        e.preventDefault();
        if (!currentCustomerId) return;

        const input = document.getElementById('replyMessage');
        const message = input.value.trim();
        if (!message) return;

        const btn = document.getElementById('sendReplyBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i>';

        try {
            const formData = new FormData();
            formData.append('message', message);
            formData.append('support_id', ADMIN_ID);

            const res = await fetch(`${MAIN_API_BASE}/admin/chats/${currentCustomerId}/reply`, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: formData
            });

            const data = await res.json();
            if (data.success) {
                input.value = '';
                input.style.height = ''; 
                // Refresh messages forcefully
                await fetchChatMessages();
                // Scroll strictly to bottom after user sends
                const container = document.getElementById('chatMessages');
                container.scrollTop = container.scrollHeight;
                
                // Refresh sidebar to bump chat to top
                loadConversations();
            } else {
                alert(data.message || 'Failed to send reply');
            }
        } catch (error) {
            console.error('Send reply error:', error);
            alert('A network error occurred.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<span>Send</span><i class="fa-solid fa-paper-plane text-xs"></i>';
            input.focus();
        }
    }
</script>
@endpush
