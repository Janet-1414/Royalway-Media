<!-- File Path: resources/views/filament/widgets/quick-actions-widget.blade.php -->

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Add New Project -->
            <a href="{{ route('filament.admin.resources.projects.create') }}"
               class="flex items-center p-4 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 group">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-white font-semibold text-lg">New Project</h3>
                    <p class="text-blue-100 text-sm">Add a new project</p>
                </div>
            </a>

            <!-- Add New Service -->
            <a href="{{ route('filament.admin.resources.services.create') }}"
               class="flex items-center p-4 bg-gradient-to-r from-cyan-500 to-cyan-600 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 group">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-white font-semibold text-lg">New Service</h3>
                    <p class="text-cyan-100 text-sm">Add a new service</p>
                </div>
            </a>

            <!-- View Contact Forms -->
            <a href="{{ route('filament.admin.resources.contact-submissions.index') }}"
               class="flex items-center p-4 bg-gradient-to-r from-amber-500 to-amber-600 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 group">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-white font-semibold text-lg">Contact Forms</h3>
                    <p class="text-amber-100 text-sm">View submissions</p>
                </div>
            </a>

            <!-- View Event Briefs -->
            <a href="{{ route('filament.admin.resources.event-briefs.index') }}"
               class="flex items-center p-4 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 group">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-white font-semibold text-lg">Event Briefs</h3>
                    <p class="text-purple-100 text-sm">View submissions</p>
                </div>
            </a>
        </div>
    </x-filament::section>

</x-filament-widgets::widget>
