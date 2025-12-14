@extends('master.master')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/adminDashboard.css') }}">
@endsection

@section('content')
<div class="container-fluid py-5" style="background: #f5f7fa;">

    <div class="container">
        <h2 class="mb-3 fw-bold">Management</h5>
        <div class="row g-4 mb-5">

            <div class="col-md-4">
            <a href="{{ route('books.index') }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm h-100 border-0 admin-card p-3">
                    <div class="text-center py-3">
                        <i class="bi bi-book-fill admin-icon"></i>
                        <h5 class="mt-3 admin-card-title">{{ __('dashboard.manage_book') }}</h5>
                        <p class="text-muted small mb-0">
                            {{ __('dashboard.manage_book_desc') }}
                        </p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('categories.index') }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm h-100 border-0 admin-card p-3">
                    <div class="text-center py-3">
                        <i class="bi bi-tags-fill admin-icon"></i>
                        <h5 class="mt-3 admin-card-title">{{ __('dashboard.manage_category') }}</h5>
                        <p class="text-muted small mb-0">{{ __('dashboard.manage_category_desc') }}</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('authors.index') }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm h-100 border-0 admin-card p-3">
                    <div class="text-center py-3">
                        <i class="bi bi-person-lines-fill admin-icon"></i>
                        <h5 class="mt-3 admin-card-title">{{ __('dashboard.manage_author') }}</h5>
                        <p class="text-muted small mb-0">{{ __('dashboard.manage_author_desc') }}</p>
                    </div>
                </div>
            </a>
        </div>

        <h2 class="mb-2 fw-bold">Admin Dashboard</h2>

        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-md-6">
                <div class="card stat-card blue-card p-4 h-100">
                    <div class="text-center">
                        <div class="stat-icon">
                            <i class="bi bi-book-fill"></i>
                        </div>
                        <div class="stat-number">{{ $stats['total_books'] }}</div>
                        <p class="stat-label mb-0">{{ __('dashboard.total_books') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card stat-card green-card p-4 h-100">
                    <div class="text-center">
                        <div class="stat-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="stat-number">{{ $stats['total_users'] }}</div>
                        <p class="stat-label mb-0">{{ __('dashboard.active_users') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card stat-card orange-card p-4 h-100">
                    <div class="text-center">
                        <div class="stat-icon">
                            <i class="bi bi-box2-heart-fill"></i>
                        </div>
                        <div class="stat-number">{{ $stats['total_borrowed'] }}</div>
                        <p class="stat-label mb-0">{{ __('dashboard.currently_borrowed') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card stat-card red-card p-4 h-100">
                    <div class="text-center">
                        <div class="stat-icon">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div class="stat-number">{{ $stats['pending_returns'] }}</div>
                        <p class="stat-label mb-0">{{ __('dashboard.overdue_returns') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-8">
                <div class="chart-card">
                    <h4 class="chart-title">{{ __('dashboard.borrowing_trends_last_7_days') }}</h4>
                    <canvas id="borrowingChart"></canvas>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="chart-card">
                    <h4 class="chart-title">{{ __('dashboard.top_categories') }}</h4>
                    <canvas id="categoriesChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                <div class="chart-card">
                    <h4 class="chart-title">{{ __('dashboard.books_availability') }}</h4>
                    <canvas id="availabilityChart"></canvas>
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="availability-stat">
                                <span class="number" style="color: #4CAF50;">{{ $booksAvailability['available'] }}</span>
                                <span class="label">{{ __('dashboard.available') }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="availability-stat">
                                <span class="number" style="color: #FF9800;">{{ $booksAvailability['borrowed'] }}</span>
                                <span class="label">{{ __('dashboard.borrowed') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="chart-card">
                    <h4 class="chart-title">{{ __('dashboard.recent_borrowings') }}</h4>
                    @forelse($recentBorrows as $borrow)
                        <div class="recent-borrow-item">
                            <div class="borrow-user">
                                <i class="bi bi-person-circle"></i> {{ $borrow->user->name }}
                            </div>
                            <div class="borrow-book">
                                <i class="bi bi-book"></i> {{ $borrow->book->title }}
                            </div>
                            <div class="borrow-date">
                                <i class="bi bi-calendar"></i> {{ __('dashboard.borrowed:') }} {{ $borrow->borrowed_at ? $borrow->borrowed_at->format('M d, Y H:i') : 'N/A' }}
                                @if($borrow->due_date)
                                    | {{ __('dashboard.due') }} {{ $borrow->due_date->format('M d, Y') }}
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">No recent borrowings</p>
                    @endforelse
                </div>
            </div>
        </div>

        

    </div>

</div>

@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const borrowingCtx = document.getElementById('borrowingChart');
        if (borrowingCtx) {
            new Chart(borrowingCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_map(fn($item) => $item['date'], $borrowingTrend)) !!},
                    datasets: [{
                        label: 'Books Borrowed',
                        data: {!! json_encode(array_map(fn($item) => $item['count'], $borrowingTrend)) !!},
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#667eea',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: { size: 12 }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false,
                                color: '#f0f0f0'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        const categoriesCtx = document.getElementById('categoriesChart');
        if (categoriesCtx) {
            new Chart(categoriesCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($topCategories->pluck('name')) !!},
                    datasets: [{
                        data: {!! json_encode($topCategories->pluck('books_count')) !!},
                        backgroundColor: [
                            '#667eea',
                            '#f5576c',
                            '#4facfe',
                            '#00f2fe',
                            '#ffd89b'
                        ],
                        borderColor: '#fff',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        }

        const availabilityCtx = document.getElementById('availabilityChart');
        if (availabilityCtx) {
            new Chart(availabilityCtx, {
                type: 'doughnut',
                data: {
                    // labels: ['Available', 'Borrowed'],
                    labels: ['{{ __("dashboard.available") }}', '{{ __("dashboard.borrowed") }}'],
                    datasets: [{
                        data: [{{ $booksAvailability['available'] }}, {{ $booksAvailability['borrowed'] }}],
                        backgroundColor: [
                            '#4CAF50',
                            '#FF9800'
                        ],
                        borderColor: '#fff',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        }
    </script>
@endsection
