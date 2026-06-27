@section('title', 'Contacts')
@section('page-title', 'Contacts')

@section('breadcrumb')
    <li class="text-brand-500">
        <span class="mx-1 text-gray-500">/</span>
        Contacts
    </li>
@endsection

<div class="flex flex-col lg:flex-row gap-6 relative items-start">

    <!-- Contact List -->
    <div class="{{ $selectedContact ? 'w-full lg:w-7/12' : 'w-full' }} transition-all duration-300">

        <!-- Toolbar -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] mb-6 flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div class="w-full sm:w-1/2 relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search name, email, subject..."
                       class="w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pl-10 pr-4 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 transition-colors">
            </div>
            <div class="w-full sm:w-auto flex gap-2">
                <button wire:click="$set('filter','')" class="px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $filter==='' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}">All</button>
                <button wire:click="$set('filter','unread')" class="px-4 py-2.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5 {{ $filter==='unread' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                    Unread
                    @if($totalUnread > 0)
                        <span class="{{ $filter==='unread' ? 'bg-white text-brand-600' : 'bg-brand-500 text-white' }} text-[10px] rounded-full px-2 py-0.5">{{ $totalUnread }}</span>
                    @endif
                </button>
                <button wire:click="$set('filter','read')" class="px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $filter==='read' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}">Read</button>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 flex w-full border-l-4 border-success-500 bg-success-50 px-4 py-3 shadow-sm dark:bg-success-500/15">
                <p class="text-sm text-success-600 dark:text-success-500">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Table -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="max-w-full overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50 text-left dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400 w-8"></th>
                            <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400 text-sm">Sender</th>
                            <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400 text-sm">Subject</th>
                            <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400 text-sm">Date</th>
                            <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400 text-sm text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                            <tr class="border-b border-gray-100 dark:border-gray-800 last:border-b-0 hover:bg-gray-50 dark:hover:bg-gray-800/50 cursor-pointer transition-colors {{ $selectedContact && $selectedContact->id === $contact->id ? 'bg-brand-50/50 dark:bg-brand-500/5' : '' }}"
                                wire:click="view({{ $contact->id }})">
                                <td class="px-5 py-4 relative">
                                    @if(!$contact->read_at)
                                        <div class="w-2.5 h-2.5 rounded-full bg-brand-500"></div>
                                        <div class="absolute inset-y-0 left-0 w-1 bg-brand-500"></div>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-brand-100 dark:bg-brand-500/20 flex items-center justify-center text-brand-600 dark:text-brand-400 text-sm font-bold uppercase shrink-0">
                                            {{ substr($contact->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-800 dark:text-white/90 {{ !$contact->read_at ? 'font-bold' : 'font-medium' }}">{{ $contact->name }}</p>
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $contact->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 max-w-xs">
                                    <p class="text-sm {{ !$contact->read_at ? 'text-gray-800 dark:text-white/90 font-semibold' : 'text-gray-600 dark:text-gray-300' }} truncate">{{ $contact->subject }}</p>
                                    <p class="text-xs text-gray-500 truncate mt-0.5">{{ Str::limit($contact->message, 50) }}</p>
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $contact->created_at->diffForHumans() }}</td>
                                <td class="px-5 py-4 text-right" wire:click.stop>
                                    <button wire:click="delete({{ $contact->id }})" wire:confirm="Delete this message?"
                                            class="text-gray-400 hover:text-error-500 transition-colors p-1.5 rounded-lg hover:bg-error-50 dark:hover:bg-error-500/10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-gray-500 text-sm">No messages found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($contacts->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">{{ $contacts->links() }}</div>
            @endif
        </div>
    </div>

    <!-- Detail Panel -->
    @if($selectedContact)
        <div class="w-full lg:w-5/12">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] sticky top-24 shadow-lg shadow-gray-100/50 dark:shadow-none">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">Message Details</h3>
                    <button wire:click="closeDetail" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors p-1 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-6 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-brand-100 dark:bg-brand-500/20 flex items-center justify-center text-brand-600 dark:text-brand-400 text-xl font-bold uppercase shrink-0">
                                {{ substr($selectedContact->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-base font-bold text-gray-800 dark:text-white/90">{{ $selectedContact->name }}</p>
                                <a href="mailto:{{ $selectedContact->email }}" class="text-sm text-brand-500 hover:underline">{{ $selectedContact->email }}</a>
                                @if($selectedContact->phone)
                                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        {{ $selectedContact->phone }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $selectedContact->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $selectedContact->created_at->format('h:i A') }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Subject</p>
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $selectedContact->subject }}</h4>
                    </div>

                    <div class="mb-8">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Message</p>
                        <div class="rounded-xl bg-gray-50 dark:bg-gray-900 p-4 border border-gray-100 dark:border-gray-800">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-sm whitespace-pre-line">{{ $selectedContact->message }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs font-medium pt-4 border-t border-gray-100 dark:border-gray-800 mb-6">
                        <span class="text-gray-500">Status</span>
                        @if($selectedContact->read_at)
                            <span class="flex items-center gap-1 text-success-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Read {{ $selectedContact->read_at->diffForHumans() }}
                            </span>
                        @else
                            <span class="text-brand-500">Unread</span>
                        @endif
                    </div>

                    <a href="mailto:{{ $selectedContact->email }}?subject=Re: {{ urlencode($selectedContact->subject) }}"
                       class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-3 text-sm font-medium text-white hover:bg-brand-600 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Reply via Email
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
