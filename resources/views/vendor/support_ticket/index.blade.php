@extends('vendor.layout.navbar')

@section('content')
<div class="min-h-screen py-6 px-4 transition-colors duration-300 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                <i class="fas fa-headset text-orange-500 mr-2"></i>
                Support Ticket System
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Manage and track your support tickets</p>
        </div>

        {{-- Main Content: 75% Listing + 25% Form --}}
        <div class="flex flex-col lg:flex-row gap-6">

            {{-- LEFT SIDE: 75% - Tickets Listing --}}
            <div class="w-full lg:w-3/4">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    {{-- Listing Header --}}
                    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h2 class="font-semibold text-gray-800 dark:text-white">
                            <i class="fas fa-ticket-alt text-orange-500 mr-2"></i>
                            All Tickets ({{ $tickets->total() }})
                        </h2>
                        <form method="GET" action="{{ route('vendor.support-ticket.index') }}" class="flex items-center gap-3">
                            <select name="priority" class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:outline-none" onchange="this.form.submit()">
                                <option value="all" {{ request('priority') == 'all' ? 'selected' : '' }}>All Priority</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                            <select name="status" class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:outline-none" onchange="this.form.submit()">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                            <div class="relative flex">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tickets..." 
                                       class="pl-9 pr-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-l-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:outline-none w-48">
                                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 rounded-r-lg text-sm transition">Search</button>
                            </div>
                        </form>
                    </div>

                    {{-- Tickets Table --}}
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">ID</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Subject</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Status</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Priority</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Created</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($tickets as $ticket)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-5 py-3 text-sm text-gray-800 dark:text-white">{{ str_pad($ticket->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-800 dark:text-white">{{ $ticket->subject }}</td>
                                    <td class="px-5 py-3">
                                        @php
                                            $statusColor = match($ticket->status) {
                                                'open' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
                                                'in_progress' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
                                                'resolved' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                                                'closed' => 'bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300',
                                                default => 'bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300',
                                            };
                                        @endphp
                                        <span class="px-2 py-1 text-xs rounded-full {{ $statusColor }}">{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</span>
                                    </td>
                                    <td class="px-5 py-3">
                                        @php
                                            $priorityColor = match($ticket->priority) {
                                                'low' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                                                'medium' => 'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300',
                                                'high', 'urgent' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
                                                default => 'bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300',
                                            };
                                        @endphp
                                        <span class="px-2 py-1 text-xs rounded-full {{ $priorityColor }}">{{ ucfirst($ticket->priority) }}</span>
                                    </td>
                                    <td class="px-5 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $ticket->created_at->format('Y-m-d') }}</td>
                                    <td class="px-5 py-3">
                                        <button type="button" class="text-orange-500 hover:text-orange-600 text-sm view-ticket-btn" title="View Ticket" data-ticket="{{ json_encode($ticket) }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-8 text-center text-gray-500 dark:text-gray-400">No tickets found. Create one from the form!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($tickets->hasPages())
                    <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $tickets->links() }}
                    </div>
                    @else
                    <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Showing all {{ $tickets->total() }} tickets</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- RIGHT SIDE: 25% - Create Ticket Form --}}
            <div class="w-full lg:w-1/4">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden sticky top-6">
                    {{-- Form Header --}}
                    <div class="bg-orange-500 dark:bg-orange-400 px-4 py-3">
                        <h2 class="text-white dark:text-gray-900 font-semibold flex items-center gap-2">
                            <i class="fas fa-plus-circle"></i>
                            Create New Ticket
                        </h2>
                    </div>

                    {{-- Form Body --}}
                    <div class="p-4">
                        <form id="ticketForm" action="">
                            {{-- Subject --}}
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-1">
                                    Subject <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="subject" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:outline-none text-sm"
                                       placeholder="Enter ticket subject">
                            </div>

                            {{-- Priority --}}
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-1">
                                    Priority <span class="text-red-500">*</span>
                                </label>
                                <select id="priority" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:outline-none text-sm">
                                    <option value="">Select priority</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>

                            {{-- Message --}}
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-1">
                                    Message <span class="text-red-500">*</span>
                                </label>
                                <textarea id="message" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:outline-none text-sm resize-none"
                                          placeholder="Describe your issue..."></textarea>
                            </div>

                            {{-- File Attachment with Preview --}}
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-1">
                                    Attachment (Optional)
                                </label>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center cursor-pointer hover:border-orange-500 transition" id="uploadArea">
                                    <input type="file" id="fileInput" class="hidden" multiple>
                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Click to upload or drag and drop</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Max file size: 5MB (JPG, PNG, PDF, DOC)</p>
                                </div>
                                
                                {{-- File Preview List --}}
                                <div id="filePreviewList" class="mt-3 space-y-2"></div>
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit" id="submitBtn"
                                    class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold py-2 rounded-lg hover:from-orange-600 hover:to-orange-700 transition">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Create Ticket
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

     
    </div>
</div>

<!-- Ticket View Modal -->
<div id="viewTicketModal" class="fixed inset-0 z-[60] hidden bg-black bg-opacity-50 flex items-center justify-center transition-opacity opacity-0 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300 m-4" id="viewTicketModalContent">
        <!-- Modal Header -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fas fa-ticket-alt text-orange-500"></i>
                Ticket Details <span id="modalTicketId" class="text-gray-500 dark:text-gray-400 font-normal text-sm ml-2"></span>
            </h3>
            <button id="closeTicketModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <!-- Modal Body -->
        <div class="p-6 max-h-[70vh] overflow-y-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1 font-semibold">Subject</p>
                    <p id="modalTicketSubject" class="font-medium text-gray-800 dark:text-white text-base"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1 font-semibold">Created On</p>
                    <p id="modalTicketDate" class="font-medium text-gray-800 dark:text-white text-base"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1 font-semibold">Status</p>
                    <div id="modalTicketStatusContainer" class="mt-1"></div>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1 font-semibold">Priority</p>
                    <div id="modalTicketPriorityContainer" class="mt-1"></div>
                </div>
            </div>
            
            <div class="mb-6">
                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 font-semibold">Message</p>
                <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700/50">
                    <p id="modalTicketMessage" class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap text-sm leading-relaxed"></p>
                </div>
            </div>

            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 font-semibold">Attachments</p>
                <div id="modalTicketAttachments" class="flex flex-wrap gap-2">
                    <!-- Attachments injected here -->
                </div>
            </div>
        </div>
        <!-- Modal Footer -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600 flex justify-end">
            <button id="closeTicketModalBtn" class="px-5 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-500 transition font-medium text-sm shadow-sm">
                Close
            </button>
        </div>
    </div>
</div>

<script>
    // File Upload with Preview
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const filePreviewList = document.getElementById('filePreviewList');
    let selectedFiles = [];

    // Click to upload
    uploadArea.addEventListener('click', () => {
        fileInput.click();
    });

    // Drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('border-orange-500', 'bg-orange-50', 'dark:bg-gray-700');
    });

    uploadArea.addEventListener('dragleave', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-orange-500', 'bg-orange-50', 'dark:bg-gray-700');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-orange-500', 'bg-orange-50', 'dark:bg-gray-700');
        const files = Array.from(e.dataTransfer.files);
        addFiles(files);
    });

    // File selection
    fileInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);
        addFiles(files);
    });

    function addFiles(newFiles) {
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        newFiles.forEach(file => {
            // Validate file type
            if (!validTypes.includes(file.type)) {
                showToast('Invalid file type: ' + file.name, 'error');
                return;
            }

            // Validate file size
            if (file.size > maxSize) {
                showToast('File too large: ' + file.name + ' (Max 5MB)', 'error');
                return;
            }

            selectedFiles.push(file);
            displayFilePreview(file);
        });

        // Clear input
        fileInput.value = '';
    }

    function displayFilePreview(file) {
        const reader = new FileReader();
        const fileId = 'file_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        
        const previewDiv = document.createElement('div');
        previewDiv.id = fileId;
        previewDiv.className = 'flex items-center justify-between p-2 bg-gray-100 dark:bg-gray-700 rounded-lg';
        
        const leftDiv = document.createElement('div');
        leftDiv.className = 'flex items-center gap-2';
        
        // File icon based on type
        let icon = 'fa-file';
        if (file.type.startsWith('image/')) {
            icon = 'fa-file-image';
        } else if (file.type === 'application/pdf') {
            icon = 'fa-file-pdf';
        } else if (file.type.includes('word')) {
            icon = 'fa-file-word';
        }
        
        const iconElem = document.createElement('i');
        iconElem.className = `fas ${icon} text-orange-500`;
        
        const infoDiv = document.createElement('div');
        infoDiv.className = 'flex flex-col';
        
        const nameSpan = document.createElement('span');
        nameSpan.className = 'text-sm text-gray-700 dark:text-gray-300';
        nameSpan.textContent = file.name;
        
        const sizeSpan = document.createElement('span');
        sizeSpan.className = 'text-xs text-gray-500';
        sizeSpan.textContent = formatFileSize(file.size);
        
        infoDiv.appendChild(nameSpan);
        infoDiv.appendChild(sizeSpan);
        leftDiv.appendChild(iconElem);
        leftDiv.appendChild(infoDiv);
        
        // Preview for images
        if (file.type.startsWith('image/')) {
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-8 h-8 rounded object-cover';
                leftDiv.insertBefore(img, leftDiv.firstChild);
                iconElem.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
        
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'text-red-500 hover:text-red-700 text-sm';
        removeBtn.innerHTML = '<i class="fas fa-trash"></i>';
        removeBtn.onclick = () => {
            selectedFiles = selectedFiles.filter(f => f !== file);
            document.getElementById(fileId).remove();
            showToast('File removed: ' + file.name, 'info');
        };
        
        previewDiv.appendChild(leftDiv);
        previewDiv.appendChild(removeBtn);
        filePreviewList.appendChild(previewDiv);
        
        showToast('File added: ' + file.name, 'success');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function showToast(message, type) {
        // Create toast element
        const toast = document.createElement('div');
        const colors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            info: 'bg-blue-500'
        };
        toast.className = `fixed bottom-4 right-4 ${colors[type]} text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-pulse`;
        toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'} mr-2"></i>${message}`;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // Form Submit
    document.getElementById('ticketForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const subject = document.getElementById('subject').value;
        const priority = document.getElementById('priority').value;
        const message = document.getElementById('message').value;
        const form = this;
        
        if (!subject || !priority || !message) {
            showToast('Please fill all required fields!', 'error');
            return;
        }

        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Creating...';
        submitBtn.disabled = true;

        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('subject', subject);
        formData.append('priority', priority);
        formData.append('message', message);
        
        selectedFiles.forEach((file) => {
            formData.append('attachments[]', file);
        });

        fetch('{{ route("vendor.support-ticket.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showToast(data.message, 'success');
                // Reset form
                form.reset();
                selectedFiles = [];
                filePreviewList.innerHTML = '';
                // Optional: reload page to see new ticket in list
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showToast(data.message || 'Error creating ticket', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Something went wrong!', 'error');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });



    // Modal Logic
    const viewTicketModal = document.getElementById('viewTicketModal');
    const viewTicketModalContent = document.getElementById('viewTicketModalContent');
    const closeButtons = [document.getElementById('closeTicketModal'), document.getElementById('closeTicketModalBtn')];
    
    function openModal(ticket) {
        // Populate data
        document.getElementById('modalTicketId').textContent = '' + String(ticket.id).padStart(3, '0');
        document.getElementById('modalTicketSubject').textContent = ticket.subject;
        
        const dateObj = new Date(ticket.created_at);
        document.getElementById('modalTicketDate').textContent = dateObj.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
        
        document.getElementById('modalTicketMessage').textContent = ticket.message;

        // Status badge
        let statusClass = 'bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300';
        if(ticket.status === 'open') statusClass = 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300';
        if(ticket.status === 'in_progress') statusClass = 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300';
        if(ticket.status === 'resolved') statusClass = 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300';
        
        let statusText = ticket.status.replace('_', ' ');
        statusText = statusText.charAt(0).toUpperCase() + statusText.slice(1);
        
        document.getElementById('modalTicketStatusContainer').innerHTML = `<span class="px-3 py-1 text-xs font-semibold rounded-full ${statusClass}">${statusText}</span>`;

        // Priority badge
        let priorityClass = 'bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300';
        if(ticket.priority === 'low') priorityClass = 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300';
        if(ticket.priority === 'medium') priorityClass = 'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300';
        if(ticket.priority === 'high' || ticket.priority === 'urgent') priorityClass = 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300';
        
        let priorityText = ticket.priority;
        priorityText = priorityText.charAt(0).toUpperCase() + priorityText.slice(1);
        
        document.getElementById('modalTicketPriorityContainer').innerHTML = `<span class="px-3 py-1 text-xs font-semibold rounded-full ${priorityClass}">${priorityText}</span>`;

        // Attachments
        const attachmentsContainer = document.getElementById('modalTicketAttachments');
        attachmentsContainer.innerHTML = '';
        if(ticket.attachment) {
            try {
                let attachments = JSON.parse(ticket.attachment);
                if(Array.isArray(attachments) && attachments.length > 0) {
                    attachments.forEach(path => {
                        let filename = path.split('/').pop();
                        attachmentsContainer.innerHTML += `
                            <a href="/storage/${path}" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-orange-500 dark:hover:border-orange-500 hover:text-orange-600 dark:hover:text-orange-400 rounded-lg text-sm text-gray-700 dark:text-gray-300 transition-colors">
                                <i class="fas fa-paperclip text-orange-500"></i> ${filename}
                            </a>
                        `;
                    });
                } else {
                    attachmentsContainer.innerHTML = '<span class="text-sm text-gray-500 dark:text-gray-400 italic">No attachments provided</span>';
                }
            } catch(e) {
                 attachmentsContainer.innerHTML = '<span class="text-sm text-gray-500 dark:text-gray-400 italic">No attachments provided</span>';
            }
        } else {
            attachmentsContainer.innerHTML = '<span class="text-sm text-gray-500 dark:text-gray-400 italic">No attachments provided</span>';
        }

        // Show modal
        viewTicketModal.classList.remove('hidden');
        setTimeout(() => {
            viewTicketModal.classList.remove('opacity-0');
            viewTicketModalContent.classList.remove('scale-95');
        }, 10);
    }

    function closeModal() {
        viewTicketModal.classList.add('opacity-0');
        viewTicketModalContent.classList.add('scale-95');
        setTimeout(() => {
            viewTicketModal.classList.add('hidden');
        }, 300);
    }

    // Attach events to all view buttons
    document.querySelectorAll('.view-ticket-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const ticket = JSON.parse(this.getAttribute('data-ticket'));
            openModal(ticket);
        });
    });

    closeButtons.forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    // Close on backdrop click
    viewTicketModal.addEventListener('click', function(e) {
        if(e.target === viewTicketModal) {
            closeModal();
        }
    });

</script>

<style>
    input:focus, select:focus, textarea:focus {
        box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.1);
    }
</style>
@endsection