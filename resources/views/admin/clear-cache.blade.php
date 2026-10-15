@extends('layouts.app')

@section('title', 'Clear Cache - RoyalWay Media')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow">
                    <div class="card-header bg-burgundy text-white">
                        <h3 class="mb-0">Cache Management</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div id="response-message"></div>

                        <p class="text-muted mb-4">
                            Clear various caches to ensure your application is running with the latest changes.
                        </p>

                        <!-- Clear All Cache -->
                        <div class="card mb-3 border-burgundy">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">Clear All Caches</h5>
                                        <p class="text-muted mb-0 small">
                                            Clears application, route, config, view, and compiled caches
                                        </p>
                                    </div>
                                    <button onclick="clearAllCache()" class="btn btn-burgundy">
                                        <i class="fas fa-trash-alt me-2"></i>Clear All
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Individual Cache Types -->
                        <h5 class="mt-4 mb-3">Clear Specific Cache</h5>

                        <div class="row g-3">
                            <!-- Application Cache -->
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-database text-primary me-2"></i>Application Cache
                                        </h6>
                                        <p class="card-text small text-muted">
                                            Clear the application cache
                                        </p>
                                        <button onclick="clearSpecificCache('cache')" class="btn btn-sm btn-outline-burgundy w-100">
                                            Clear
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Route Cache -->
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-route text-info me-2"></i>Route Cache
                                        </h6>
                                        <p class="card-text small text-muted">
                                            Clear cached routes
                                        </p>
                                        <button onclick="clearSpecificCache('route')" class="btn btn-sm btn-outline-burgundy w-100">
                                            Clear
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Config Cache -->
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-cog text-warning me-2"></i>Config Cache
                                        </h6>
                                        <p class="card-text small text-muted">
                                            Clear configuration cache
                                        </p>
                                        <button onclick="clearSpecificCache('config')" class="btn btn-sm btn-outline-burgundy w-100">
                                            Clear
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- View Cache -->
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-eye text-success me-2"></i>View Cache
                                        </h6>
                                        <p class="card-text small text-muted">
                                            Clear compiled views
                                        </p>
                                        <button onclick="clearSpecificCache('view')" class="btn btn-sm btn-outline-burgundy w-100">
                                            Clear
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Access URLs -->
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="mb-2">Quick Access URLs:</h6>
                            <div class="small">
                                <code>{{ url('/clear-cache') }}</code> - Direct cache clear (redirects back)<br>
                                <code>{{ url('/api/cache/clear-all') }}</code> - Clear all (JSON response)<br>
                                <code>{{ url('/api/cache/clear/view') }}</code> - Clear specific (JSON response)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-burgundy {
            background-color: #8B0000;
        }

        .text-burgundy {
            color: #8B0000;
        }

        .border-burgundy {
            border-color: #8B0000;
        }

        .btn-burgundy {
            background-color: #8B0000;
            color: white;
            border-color: #8B0000;
        }

        .btn-burgundy:hover {
            background-color: #6B0000;
            border-color: #6B0000;
            color: white;
        }

        .btn-outline-burgundy {
            color: #8B0000;
            border-color: #8B0000;
        }

        .btn-outline-burgundy:hover {
            background-color: #8B0000;
            color: white;
        }
    </style>

    <script>
        function showMessage(message, type = 'success') {
            const messageDiv = document.getElementById('response-message');
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';

            messageDiv.innerHTML = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fas fa-${icon} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

            // Auto dismiss after 5 seconds
            setTimeout(() => {
                messageDiv.innerHTML = '';
            }, 5000);
        }

        async function clearAllCache() {
            const button = event.target;
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Clearing...';

            try {
                const response = await fetch('/api/cache/clear-all');
                const data = await response.json();

                if (data.success) {
                    showMessage(data.message, 'success');
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                showMessage('Error clearing cache: ' + error.message, 'error');
            } finally {
                button.disabled = false;
                button.innerHTML = originalText;
            }
        }

        async function clearSpecificCache(type) {
            const button = event.target;
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            try {
                const response = await fetch(`/api/cache/clear/${type}`);
                const data = await response.json();

                if (data.success) {
                    showMessage(data.message, 'success');
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                showMessage('Error: ' + error.message, 'error');
            } finally {
                button.disabled = false;
                button.innerHTML = originalText;
            }
        }
    </script>
@endsection
