@section('title', 'Contacts')
@section('page-title', 'Contacts')

<div class="flex gap-6">

    <!-- Contact List -->
    <div class="{{ $selectedContact ? 'w-1/2' : 'w-full' }} transition-all duration-300">

        <!-- Toolbar -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 mb-6 flex flex-col sm:flex-row gap-4">
            <div class="flex-1 relative">
                <svg class="w-4 h-4 text-gray-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search name, email, subject..."
                       class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg pl-10 pr-4 py-2 text-sm focus:border-amber-500 outline-none">
            </div>
            <div class="flex gap-2">
                <button wire:click="$set('filter','')" class="px-3 py-2 rounded-lg text-xs font-medium transition {{ $filter==='' ? 'bg-amber-500 text-white' : 'bg-gray-800 text-gray-400 hover:text-white' }}">All</button>
                <button wire:click="$set('filter','unread')" class="px-3 py-2 rounded-lg text-xs font-medium transition {{ $filter==='unread' ? 'bg-blue-500 text-white' : 'bg-gray-800 text-gray-400 hover:text-white' }}">
                    Unread
                    @if($totalUnread > 0)
                        <span class="ml-1 bg-red-500 text-white text-[9px] rounded-full px-1.5">{{ $totalUnread }}</span>
                    @endif
                </button>
                <button wire:click="$set('filter','read')" class="px-3 py-2 rounded-lg text-xs font-medium transition {{ $filter==='read' ? 'bg-gray-600 text-white' : 'bg-gray-800 text-gray-400 hover:text-white' }}">Read</button>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
        @endif

        <!-- Table -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-950/50 text-gray-400 border-b border-gray-800">
                    <tr>
                        <th class="px-5 py-4 font-medium w-8"></th>
                        <th class="px-5 py-4 font-medium">Sender</th>
                        <th class="px-5 py-4 font-medium">Subject</th>
                        <th class="px-5 py-4 font-medium">Date</th>
                        <th class="px-5 py-4 font-medium text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800 text-gray-300">
                    @forelse($contacts as $contact)
                        <tr class="hover:bg-gray-800/50 cursor-pointer {{ !$contact->read_at ? 'border-l-2 border-l-amber-500' : '' }}"
                            wire:click="view({{ $contact->id }})">
                            <td class="px-5 py-4">
                                @if(!$contact->read_at)
                                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-xs font-bold uppercase shrink-0">
                                        {{ substr($contact->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-white {{ !$contact->read_at ? 'font-semibold' : '' }}">{{ $contact->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $contact->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 truncate max-w-xs">
                                <p class="{{ !$contact->read_at ? 'text-white font-medium' : 'text-gray-400' }}">{{ $contact->subject }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Str::limit($contact->message, 50) }}</p>
                            </td>
                            <td class="px-5 py-4 text-gray-500 text-xs">{{ $contact->created_at->diffForHumans() }}</td>
                            <td class="px-5 py-4 text-right" wire:click.stop>
                                <button wire:click="delete({{ $contact->id }})" wire:confirm="Delete this message?"
                                        class="text-gray-500 hover:text-red-400 transition p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-gray-500">No messages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($contacts->hasPages())
                <div class="px-5 py-4 border-t border-gray-800">{{ $contacts->links() }}</div>
            @endif
        </div>
    </div>

    <!-- Detail Panel -->
    @if($selectedContact)
        <div class="w-1/2">
            <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden sticky top-24">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-800 bg-gray-950/30">
                    <h3 class="text-sm font-semibold text-white">Message Detail</h3>
                    <button wire:click="closeDetail" class="text-gray-500 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="p-6 space-y-5">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-lg font-bold uppercase">
                            {{ substr($selectedContact->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-white text-base">{{ $selectedContact->name }}</p>
                            <p class="text-sm text-gray-400">{{ $selectedContact->email }}</p>
                            @if($selectedContact->phone)
                                <p class="text-xs text-gray-500">📞 {{ $selectedContact->phone }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-950 rounded-lg px-4 py-3">
                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wider">Subject</p>
                        <p class="text-white font-medium">{{ $selectedContact->subject }}</p>
                    </div>

                    <div class="bg-gray-950 rounded-lg px-4 py-4">
                        <p class="text-xs text-gray-500 mb-2 uppercase tracking-wider">Message</p>
                        <p class="text-gray-300 leading-relaxed text-sm whitespace-pre-line">{{ $selectedContact->message }}</p>
                    </div>

                    <div class="flex items-center justify-between text-xs text-gray-500 pt-2 border-t border-gray-800">
                        <span>Received {{ $selectedContact->created_at->format('d M Y, H:i') }}</span>
                        @if($selectedContact->read_at)
                            <span class="text-emerald-400">✓ Read {{ $selectedContact->read_at->diffForHumans() }}</span>
                        @endif
                    </div>

                    <a href="mailto:{{ $selectedContact->email }}?subject=Re: {{ urlencode($selectedContact->subject) }}"
                       class="w-full inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-medium py-2.5 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Reply via Email
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
