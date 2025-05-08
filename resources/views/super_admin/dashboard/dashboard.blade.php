@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <h1>Dashboard</h1>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @include('super_admin.dashboard.cards')
            @include('super_admin.dashboard.charts')
            @include('super_admin.dashboard.recent_products')
        </div>
    </section>
@endsection
@section('customJs')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Order Status Chart (Doughnut)
        const orderCtx = document.getElementById('orderStatusChart').getContext('2d');
        new Chart(orderCtx, {
            type: 'doughnut',
            data: {
                labels: ['pending', 'processing', 'completed', 'decline'],
                datasets: [{
                    label: 'Orders',
                    data: @json(array_values($orderStats)), // Đảm bảo $orderStats là mảng key => value
                    backgroundColor: [
                        '#f6c23e',  // yellow
                        '#4e73df', // blue
                        '#1cc88a', // green
                        '#f64e60' // red
                    ],
                    borderWidth: 1,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
        // Monthly Revenue (Bar)
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul',
                    'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Monthly Revenue (VND)',
                    data: @json($monthlyChartData),
                    backgroundColor: 'rgba(78, 115, 223, 0.6)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN') + '₫';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                label += context.raw.toLocaleString('vi-VN') + '₫';
                                return label;
                            }
                        }
                    }
                }
            }
        });
        const ctx = document.getElementById('productPerCategoryChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($categoryLabels),
                datasets: [{
                    label: 'Products',
                    data: @json($categoryData),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    barThickness: 20 // 👈 Làm cột nhỏ lại
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        function deleteProduct(id) {
            var url = '{{ route("products.delete", "ID") }}';
            var newUrl = url.replace("ID", id);
            if (confirm("Are you sure you want to delete")) {
                $.ajax({
                    url: newUrl,
                    type: 'DELETE',
                    data: {},
                    dataType: 'json',
                    success: function (response) {
                        if (response["status"] === true) {
                            window.location.href = "{{ route('products.index') }}";
                        } else{
                            window.location.href = "{{ route('products.index') }}";
                        }
                    },
                });
            }
        }

    </script>

@endsection

