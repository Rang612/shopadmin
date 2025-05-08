<div class="row">
    @foreach($statCards as $card)
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="dashboard-card p-4 d-flex justify-content-between align-items-center shadow-sm rounded">
                <div>
                    <div class="text-muted text-uppercase small mb-1 font-weight-bold">{{ $card['label'] }}</div>
                    <div class="h4 font-weight-bold text-dark">{{ $card['value'] }}</div>
                </div>
                <div class="text-primary">
                    <i class="{{ $card['icon'] }} fa-2x"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>
@push('styles')
    <style>
        .dashboard-card {
            background: #ffffff;
            border-radius: 12px;
            transition: all 0.2s ease-in-out;
            border: 1px solid #f0f0f0;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        }

        .dashboard-card .text-muted {
            color: #6c757d !important;
            letter-spacing: 0.5px;
        }

        .dashboard-card .text-primary {
            color: #4e73df !important;
        }

        .dashboard-card i {
            opacity: 0.3;
        }

        .icon-circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-circle i {
            font-size: 20px;
        }
    </style>
@endpush
