@extends('layout.app')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700">All Support Tickets</h3>
            <p class="text-[10px] text-gray-400">Manage vendor support requests from one place</p>
        </div>
    </div>

    {{-- Tickets List --}}
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <h3 class="text-sm font-semibold text-gray-700">Tickets List</h3>

                <form method="GET" action="{{ route('admin.support-ticket.index') }}" class="flex flex-col sm:flex-row gap-2 sm:items-center">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search tickets..."
                               class="w-full sm:w-56 pl-8 pr-3 py-1.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 placeholder-gray-400">
                    </div>

                    <select name="status"
                            class="w-full sm:w-auto px-3 py-1.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600">
                        <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>

                    <select name="priority"
                            class="w-full sm:w-auto px-3 py-1.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600">
                        <option value="all" {{ request('priority', 'all') === 'all' ? 'selected' : '' }}>All Priority</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                    </select>

                    <button type="submit"
                            class="inline-flex items-center justify-center px-4 py-1.5 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-xs font-medium rounded-lg hover:from-cyan-600 hover:to-emerald-600 transition-all duration-200 shadow-sm hover:shadow">
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'status', 'priority']))
                    <a href="{{ route('admin.support-ticket.index') }}"
                       class="inline-flex items-center justify-center px-4 py-1.5 bg-white border border-gray-200 text-gray-600 text-xs font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                        Reset
                    </a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="m-4 p-3 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-xs text-green-600 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </p>
        </div>
        @endif

        @if(session('error'))
        <div class="m-4 p-3 bg-rose-50 border border-rose-200 rounded-lg">
            <p class="text-xs text-rose-600 flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </p>
        </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-gray-50 border-y border-gray-100">
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Sr.No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Vendor</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Subject</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Priority</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Created</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tickets as $index => $ticket)
                    <tr class="hover:bg-cyan-50/30 transition-colors duration-200">
                        <td class="px-4 py-3 text-gray-600">{{ $tickets->firstItem() + $index }}</td>

                        <td class="px-4 py-3">
                            <div class="flex flex-col">
                                <span class="font-medium text-gray-700">{{ optional($ticket->vendor)->name ?? 'Unknown Vendor' }}</span>
                                <span class="text-[10px] text-gray-400">#{{ str_pad($ticket->vendor_id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </td>

                        <td class="px-4 py-3 font-medium text-gray-700">
                            {{ $ticket->subject }}
                        </td>

                        <td class="px-4 py-3">
                            @php
                                $statusClass = match($ticket->status) {
                                    'open' => 'bg-amber-50 text-amber-600',
                                    'in_progress' => 'bg-sky-50 text-sky-600',
                                    'resolved' => 'bg-emerald-50 text-emerald-600',
                                    'closed' => 'bg-gray-50 text-gray-500',
                                    default => 'bg-gray-50 text-gray-500',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium {{ $statusClass }}">
                                <i class="fas fa-circle mr-1 text-[6px]"></i>
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            @php
                                $priorityClass = match($ticket->priority) {
                                    'low' => 'bg-emerald-50 text-emerald-600',
                                    'medium' => 'bg-amber-50 text-amber-600',
                                    'high' => 'bg-rose-50 text-rose-600',
                                    default => 'bg-gray-50 text-gray-500',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium {{ $priorityClass }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            {{ optional($ticket->created_at)->format('d M Y, h:i A') }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                <button type="button"
                                        onclick='openTicketModal(@json($ticket))'
                                        class="p-1 hover:bg-cyan-50 rounded text-gray-400 hover:text-cyan-500 transition-colors duration-200"
                                        title="View">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-400 text-xs">
                            <i class="fas fa-folder-open text-3xl mb-2 block text-gray-300"></i>
                            No support tickets found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
            <p class="text-[10px] text-gray-400">
                Showing {{ $tickets->total() }} {{ \Illuminate\Support\Str::plural('entry', $tickets->total()) }}
            </p>
            {{ $tickets->links() }}
        </div>
    </div>
</div>

{{-- Ticket Detail Modal --}}
<div id="ticketModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div id="ticketModalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-cyan-100">
                            <i class="fas fa-ticket-alt text-cyan-600"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-700" id="ticketModalTitle">Ticket Details</h3>
                            <p class="text-xs text-gray-400" id="ticketModalSubtitle"></p>
                        </div>
                    </div>

                    <button type="button" onclick="closeTicketModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-400 mb-1">Vendor</p>
                        <p class="text-sm font-medium text-gray-700" id="ticketVendor"></p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-400 mb-1">Created</p>
                        <p class="text-sm font-medium text-gray-700" id="ticketCreatedAt"></p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-400 mb-1">Status</p>
                        <div id="ticketStatusBadge"></div>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-400 mb-1">Priority</p>
                        <div id="ticketPriorityBadge"></div>
                    </div>
                </div>

                <div class="mt-5">
                    <p class="text-[10px] uppercase tracking-wide text-gray-400 mb-2">Subject</p>
                    <p class="text-sm font-semibold text-gray-800" id="ticketSubject"></p>
                </div>

                <div class="mt-5">
                    <p class="text-[10px] uppercase tracking-wide text-gray-400 mb-2">Message</p>
                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-4">
                        <p class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed" id="ticketMessage"></p>
                    </div>
                </div>

                <div class="mt-5">
                    <p class="text-[10px] uppercase tracking-wide text-gray-400 mb-2">Attachments</p>
                    <div id="ticketAttachments" class="flex flex-wrap gap-2">
                        {{-- Injected via JS --}}
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button"
                        onclick="closeTicketModal()"
                        class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:ml-3 sm:w-auto sm:text-xs">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let activeTicket = null;

function openTicketModal(ticket) {
    activeTicket = ticket;

    document.getElementById('ticketModalTitle').textContent = `Ticket #${String(ticket.id).padStart(3, '0')}`;
    document.getElementById('ticketModalSubtitle').textContent = ticket.vendor?.name || 'Unknown Vendor';
    document.getElementById('ticketVendor').textContent = ticket.vendor?.name || 'Unknown Vendor';
    document.getElementById('ticketCreatedAt').textContent = ticket.created_at ? new Date(ticket.created_at).toLocaleString([], { dateStyle: 'medium', timeStyle: 'short' }) : '-';
    document.getElementById('ticketSubject').textContent = ticket.subject || '-';
    document.getElementById('ticketMessage').textContent = ticket.message || '-';

    let statusClass = 'bg-gray-50 text-gray-500';
    if (ticket.status === 'open') statusClass = 'bg-amber-50 text-amber-600';
    if (ticket.status === 'in_progress') statusClass = 'bg-sky-50 text-sky-600';
    if (ticket.status === 'resolved') statusClass = 'bg-emerald-50 text-emerald-600';
    if (ticket.status === 'closed') statusClass = 'bg-gray-50 text-gray-500';

    let statusText = ticket.status ? ticket.status.replace(/_/g, ' ') : '-';
    statusText = statusText.charAt(0).toUpperCase() + statusText.slice(1);
    document.getElementById('ticketStatusBadge').innerHTML = `<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-medium ${statusClass}">${statusText}</span>`;

    let priorityClass = 'bg-gray-50 text-gray-500';
    if (ticket.priority === 'low') priorityClass = 'bg-emerald-50 text-emerald-600';
    if (ticket.priority === 'medium') priorityClass = 'bg-amber-50 text-amber-600';
    if (ticket.priority === 'high') priorityClass = 'bg-rose-50 text-rose-600';

    let priorityText = ticket.priority ? ticket.priority.charAt(0).toUpperCase() + ticket.priority.slice(1) : '-';
    document.getElementById('ticketPriorityBadge').innerHTML = `<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-medium ${priorityClass}">${priorityText}</span>`;

    const attachmentsContainer = document.getElementById('ticketAttachments');
    attachmentsContainer.innerHTML = '';

    if (ticket.attachment) {
        try {
            const attachments = JSON.parse(ticket.attachment);
            if (Array.isArray(attachments) && attachments.length > 0) {
                attachments.forEach(path => {
                    const filename = path.split('/').pop();
                    attachmentsContainer.innerHTML += `
                        <a href="/storage/${path}" target="_blank"
                           class="inline-flex items-center gap-2 px-3 py-2 bg-gray-50 border border-gray-200 hover:border-cyan-400 hover:text-cyan-600 rounded-lg text-xs text-gray-700 transition-colors">
                            <i class="fas fa-paperclip text-cyan-500"></i>
                            ${filename}
                        </a>
                    `;
                });
            } else {
                attachmentsContainer.innerHTML = '<span class="text-xs text-gray-400 italic">No attachments provided</span>';
            }
        } catch (e) {
            attachmentsContainer.innerHTML = '<span class="text-xs text-gray-400 italic">No attachments provided</span>';
        }
    } else {
        attachmentsContainer.innerHTML = '<span class="text-xs text-gray-400 italic">No attachments provided</span>';
    }

    document.getElementById('ticketModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeTicketModal() {
    document.getElementById('ticketModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    activeTicket = null;
}

document.getElementById('ticketModalOverlay')?.addEventListener('click', closeTicketModal);
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTicketModal();
    }
});

document.querySelector('#ticketModal .bg-white')?.addEventListener('click', function(e) {
    e.stopPropagation();
});
</script>
@endsection
