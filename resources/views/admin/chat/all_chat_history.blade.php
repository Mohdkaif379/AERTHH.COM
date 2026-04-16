@extends('layout.app')

@section('title', 'Chat History')
@section('page-title', 'Completed Chat History')
@section('page-subtitle', 'Review chats that have already been marked as completed')

@section('content')
<div id="historyShell" class="relative h-[calc(100dvh-140px)] min-h-[calc(100dvh-140px)] md:min-h-[620px] flex flex-col md:flex-row bg-white rounded-none md:rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div id="historySidebar" class="w-full md:w-[360px] lg:w-[380px] shrink-0 flex flex-col min-h-0 border-r border-slate-100 bg-slate-50/50">
        <div class="p-4 border-b border-slate-100 bg-white">
            <div class="relative">
                <input type="text" id="searchHistoryChats" placeholder="Search customers..."
                    class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg text-[16px] sm:text-sm focus:outline-none focus:border-sky-400 focus:ring-1 focus:ring-sky-400 bg-slate-50 relative z-10 transition-colors">
                <i class="fa-solid fa-search absolute left-3.5 top-3 text-slate-400 text-sm z-20"></i>
            </div>
        </div>

        <div id="historyChatsList" class="flex-1 min-h-0 overflow-y-auto w-full p-2 space-y-1">
            @if($completedChats->isEmpty())
                <div class="p-8 text-center text-slate-400 text-sm">No completed chat history found.</div>
            @else
                @foreach($completedChats as $chat)
                    @if(($chat['status'] ?? null) !== 'completed')
                        @continue
                    @endif
                    @php
                        $customer = $chat['customer'];
                        $name = $customer ? trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')) : 'Unknown Customer';
                        $initials = collect(explode(' ', $name))
                            ->filter()
                            ->map(fn ($part) => mb_substr($part, 0, 1))
                            ->take(2)
                            ->implode('');
                        $initials = strtoupper($initials ?: 'U');
                        $lastTime = \Carbon\Carbon::parse($chat['last_time'])->format('h:i A');
                    @endphp

                    <button
                        type="button"
                        class="history-chat-item w-full text-left flex items-start gap-3 p-3 rounded-lg transition-colors border-l-[3px] border-transparent hover:bg-slate-50 {{ $loop->first ? 'active bg-sky-50' : '' }}"
                        data-name="{{ strtolower($name) }}"
                        data-initials="{{ $initials }}"
                        data-target="history-chat-{{ $chat['customer_id'] }}"
                        onclick="openHistoryChat('{{ $chat['customer_id'] }}')">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 text-white flex items-center justify-center font-bold text-xs shrink-0 relative mt-0.5">
                            {{ $initials }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-0.5 gap-2">
                                <h4 class="font-semibold text-slate-800 text-sm truncate pr-2">{{ $name }}</h4>
                                <span class="text-[10px] text-slate-400 shrink-0">{{ $lastTime }}</span>
                            </div>
                            <p class="text-xs text-slate-500 truncate">{{ $chat['total_messages'] }} messages, closed by {{ $chat['support_name'] }}</p>
                        </div>
                    </button>
                @endforeach
            @endif
        </div>
    </div>

    <div class="w-full flex-1 flex-col min-h-0 bg-white hidden md:flex" id="historyChatArea">
        @if($completedChats->isEmpty())
            <div class="flex-1 min-h-0 flex flex-col items-center justify-center bg-slate-50/50 text-slate-400 px-6 text-center">
                <div class="w-24 h-24 bg-sky-50 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-regular fa-comments text-4xl text-sky-400"></i>
                </div>
                <h3 class="text-lg font-medium text-slate-600">No History Available</h3>
                <p class="text-sm mt-1">Completed conversations will appear here.</p>
            </div>
        @else
            <div class="min-h-16 border-b border-slate-100 px-4 sm:px-6 py-3 flex items-center justify-between gap-3 shrink-0 bg-white">
                <div class="flex items-center gap-3 min-w-0">
                    <button class="md:hidden shrink-0 text-slate-400 hover:text-slate-600" id="historyBackBtn" type="button">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 text-white flex items-center justify-center font-bold text-sm shadow-sm shrink-0" id="historyHeaderInitials">
                        -
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-semibold text-slate-800 text-sm truncate max-w-[180px] sm:max-w-[260px] md:max-w-none" id="historyHeaderName">Select a customer</h3>
                        <p class="text-xs text-slate-400" id="historyHeaderMeta">Completed chat thread</p>
                    </div>
                </div>
            </div>

            <div id="historyEmptyState" class="flex-1 min-h-0 flex flex-col items-center justify-center bg-slate-50/50 text-slate-400 px-6 text-center">
                <div class="w-24 h-24 bg-sky-50 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-regular fa-comments text-4xl text-sky-400"></i>
                </div>
                <h3 class="text-lg font-medium text-slate-600">Select a Customer</h3>
                <p class="text-sm mt-1">Open a completed chat from the left list</p>
            </div>

            <div id="historyThreadsWrapper" class="hidden flex-1 min-h-0 overflow-y-auto p-4 md:p-6 bg-[#f8fafc]">
                @foreach($completedChats as $chat)
                    @if(($chat['status'] ?? null) !== 'completed')
                        @continue
                    @endif
                    @php
                        $customer = $chat['customer'];
                        $name = $customer ? trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')) : 'Unknown Customer';
                        $initials = collect(explode(' ', $name))
                            ->filter()
                            ->map(fn ($part) => mb_substr($part, 0, 1))
                            ->take(2)
                            ->implode('');
                        $initials = strtoupper($initials ?: 'U');
                    @endphp

                    <div id="history-chat-{{ $chat['customer_id'] }}" class="history-chat-thread hidden space-y-3">
                        <div class="space-y-3">
                            @foreach($chat['messages'] as $message)
                                <div class="flex {{ $message->sender_type === 'support' ? 'justify-end' : 'justify-start' }}">
                                    <div class="flex flex-col {{ $message->sender_type === 'support' ? 'items-end' : 'items-start' }} w-fit max-w-[85%] sm:max-w-[75%] md:max-w-[60%] lg:max-w-[45%]">
                                        <div class="text-[10px] mb-1 {{ $message->sender_type === 'support' ? 'text-right text-sky-600' : 'text-left text-slate-500' }}">
                                            {{ $message->sender_type === 'support' ? 'Support' : 'Customer' }}
                                            <span class="text-slate-400 ml-1">
                                                {{ \Carbon\Carbon::parse($message->created_at)->format('h:i A') }}
                                            </span>
                                        </div>
                                        <div class="{{ $message->sender_type === 'support' ? 'self-end bg-sky-500 text-white rounded-br-sm border-sky-400/50 px-2 py-1' : 'self-start bg-white text-slate-700 rounded-bl-sm border-slate-200 px-1 py-1' }} inline-block w-fit max-w-full rounded-2xl shadow-sm border text-[12px] leading-tight text-left whitespace-pre-wrap break-words">
                                            {!! nl2br(e(trim($message->message))) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="pt-4 flex justify-center">
                                <div class="px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 text-xs font-medium shadow-sm">
                                    Query Resolved on {{ \Carbon\Carbon::parse($chat['completed_at'])->format('d M Y, h:i A') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    const historyThreads = Array.from(document.querySelectorAll('.history-chat-thread'));
    const historyItems = Array.from(document.querySelectorAll('.history-chat-item'));

    function setHistoryMobileView(isThreadOpen) {
        const sidebar = document.getElementById('historySidebar');
        const area = document.getElementById('historyChatArea');

        if (!sidebar || !area) return;

        if (window.innerWidth < 768) {
            sidebar.classList.toggle('hidden', isThreadOpen);
            area.classList.toggle('hidden', !isThreadOpen);
            area.classList.toggle('flex', isThreadOpen);
        } else {
            sidebar.classList.remove('hidden');
            area.classList.remove('hidden');
            area.classList.add('flex');
        }
    }

    function openHistoryChat(customerId) {
        const targetId = `history-chat-${customerId}`;
        const target = document.getElementById(targetId);
        if (!target) return;

        const emptyState = document.getElementById('historyEmptyState');
        const threadsWrapper = document.getElementById('historyThreadsWrapper');

        if (emptyState) emptyState.classList.add('hidden');
        if (threadsWrapper) threadsWrapper.classList.remove('hidden');

        historyThreads.forEach(thread => thread.classList.add('hidden'));
        target.classList.remove('hidden');

        historyItems.forEach(item => {
            const isActive = item.getAttribute('data-target') === targetId;
            item.classList.toggle('active', isActive);
            item.classList.toggle('bg-sky-50', isActive);
        });

        const activeItem = historyItems.find(item => item.getAttribute('data-target') === targetId);
        const name = activeItem ? activeItem.querySelector('h4')?.textContent?.trim() : 'Customer';
        const initials = activeItem ? activeItem.getAttribute('data-initials') : '-';

        const headerName = document.getElementById('historyHeaderName');
        const headerInitials = document.getElementById('historyHeaderInitials');
        const headerMeta = document.getElementById('historyHeaderMeta');

        if (headerName) headerName.textContent = name || 'Customer';
        if (headerInitials) headerInitials.textContent = initials || '-';
        if (headerMeta) headerMeta.textContent = 'Completed chat thread';

        setHistoryMobileView(true);
    }

    document.addEventListener('DOMContentLoaded', () => {
        setHistoryMobileView(false);

        const search = document.getElementById('searchHistoryChats');
        if (search) {
            search.addEventListener('input', (e) => {
                const val = e.target.value.toLowerCase();
                historyItems.forEach(item => {
                    const name = item.getAttribute('data-name') || '';
                    item.style.display = name.includes(val) ? 'flex' : 'none';
                });
            });
        }

        const backBtn = document.getElementById('historyBackBtn');
        if (backBtn) {
            backBtn.addEventListener('click', () => {
                setHistoryMobileView(false);
            });
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                const visibleThread = historyThreads.find(thread => !thread.classList.contains('hidden'));
                setHistoryMobileView(Boolean(visibleThread));
            }
        });
    });
</script>
@endpush
