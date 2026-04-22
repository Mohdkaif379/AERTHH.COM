<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aerthh - Vendor Order Report</title>
    <style>
        @page {
            margin: 18px 14px 24px;
            size: A4 landscape;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #0f172a;
            background: #ffffff;
            line-height: 1.35;
        }

        .report {
            width: 100%;
        }

        .header {
            width: 97%;
            background: #0f172a;
            color: #ffffff;
            padding: 14px 16px 12px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .header-left,
        .header-right {
            vertical-align: top;
        }

        .header-left {
            width: 50%;
            padding-right: 10px;
        }

        .header-right {
            width: 50%;
            text-align: right;
        }

        .brand {
            display: inline-block;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 2px;
            vertical-align: middle;
        }

        .brand-logo {
            display: inline-block;
            width: 34px;
            height: 34px;
            object-fit: contain;
            vertical-align: middle;
            margin-right: 8px;
            border-radius: 50%;
            background: #ffffff;
            padding: 3px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .brand-subtitle {
            margin-top: 2px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #cbd5e1;
        }

        .report-title {
            margin-top: 6px;
            font-size: 13px;
            font-weight: 800;
        }

        .report-subtitle {
            margin-top: 4px;
            font-size: 9px;
            color: #cbd5e1;
        }

        .meta {
            display: inline-block;
            width: 100%;
            max-width: 360px;
            margin-left: auto;
            text-align: left;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 12px;
            padding: 7px 8px;
        }

        .meta-line {
            font-size: 9px;
            line-height: 1.35;
            color: #cbd5e1;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .meta-line:last-child {
            margin-bottom: 0;
        }

        .meta-label {
            display: inline;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
        }

        .meta-value {
            display: inline;
            margin-left: 4px;
            font-size: 10px;
            font-weight: 700;
            color: #ffffff;
            word-break: break-word;
        }

        .content {
            padding: 10px 0 4px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 800;
            margin: 0 0 8px;
            color: #0f172a;
        }

        .summary {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 6px;
            margin-bottom: 12px;
            table-layout: fixed;
        }

        .summary td {
            width: 25%;
            padding-right: 6px;
        }

        .summary-card {
            border: 1px solid #dbe3ee;
            border-radius: 12px;
            background: #f8fafc;
            padding: 10px 12px;
        }

        .summary-accent {
            height: 4px;
            border-radius: 999px;
            margin-bottom: 8px;
        }

        .summary-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
        }

        .summary-count {
            margin-top: 5px;
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        .order-card {
            margin-bottom: 10px;
            border: 1px solid #dbe3ee;
            border-radius: 14px;
            overflow: hidden;
        }

        .order-card-header {
            width: 100%;
            border-collapse: collapse;
            background: #f8fafc;
            border-bottom: 1px solid #dbe3ee;
        }

        .order-card-header td {
            padding: 10px 12px;
            vertical-align: top;
        }

        .card-order-no {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
            font-family: "Courier New", monospace;
        }

        .card-order-date {
            margin-top: 2px;
            font-size: 10px;
            color: #64748b;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-delivered { background: #dcfce7; color: #166534; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .badge-confirmed { background: #dbeafe; color: #1d4ed8; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-out_for_delivery { background: #e0f2fe; color: #075985; }
        .badge-returned { background: #ede9fe; color: #5b21b6; }
        .badge-packaging { background: #fae8ff; color: #86198f; }
        .badge-failed_delivery { background: #fee2e2; color: #b91c1c; }
        .badge-default { background: #e2e8f0; color: #334155; }

        .order-details {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .order-details td {
            width: 50%;
            padding: 8px 10px;
            vertical-align: top;
            border-top: 1px solid #edf2f7;
            border-right: 1px solid #edf2f7;
            word-break: break-word;
        }

        .order-details td:nth-child(2n) {
            border-right: 0;
        }

        .field-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .field-value {
            font-size: 11px;
            font-weight: 700;
            color: #0f172a;
        }

        .field-sub {
            margin-top: 2px;
            font-size: 9px;
            color: #64748b;
        }

        .amount {
            color: #059669;
        }

        .empty-state {
            padding: 34px 20px;
            text-align: center;
            color: #64748b;
        }

        .empty-title {
            margin-top: 8px;
            font-size: 16px;
            font-weight: 800;
            color: #334155;
        }

        .footer {
            margin-top: 6px;
            background: #0f172a;
            color: #cbd5e1;
            padding: 10px 12px;
            width: 98%;
        }

        .footer-inner {
            width: 100%;
            text-align: center;
            line-height: 1.45;
        }

        .footer-brand {
            color: #ffffff;
            font-weight: 800;
            font-size: 10px;
            display: inline;
        }

        .footer-sub {
            margin-top: 0;
            font-size: 8px;
            color: #94a3b8;
            display: inline;
        }

        .no-break {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    @php
        $generatedAt = now()->format('d M Y, h:i A');
        $vendorName = data_get(session('vendor'), 'name', 'Vendor');
        $statusSummary = ['pending', 'confirmed', 'delivered', 'cancelled', 'out_for_delivery', 'returned', 'packaging', 'failed_delivery'];
        $statusAccentColors = [
            'pending' => '#d97706',
            'confirmed' => '#2563eb',
            'delivered' => '#16a34a',
            'cancelled' => '#dc2626',
            'out_for_delivery' => '#0284c7',
            'returned' => '#7c3aed',
            'packaging' => '#a21caf',
            'failed_delivery' => '#b91c1c',
        ];
        $logoPath = public_path('2025-03-26-67e3da8f9b411.webp');
    @endphp

    <div class="report">
        <div class="header no-break">
            <table class="header-table">
                <tr>
                    <td class="header-left">
                        <div>
                            <img src="{{ file_exists($logoPath) ? $logoPath : asset('2025-03-26-67e3da8f9b411.webp') }}" alt="Aerthh Logo" class="brand-logo">
                            <span class="brand">Aerthh.com</span>
                        </div>
                        <div class="brand-subtitle">Vendor Order Report</div>
                        <div class="report-title">Complete Order Report</div>
                    </td>
                    <td class="header-right">
                        <div class="meta">
                            <div class="meta-line">
                                <span class="meta-label">Date :</span>
                                <span class="meta-value">{{ $generatedAt }}</span>
                            </div>
                            <div class="meta-line">
                                <span class="meta-label">Vendor Name:</span>
                                <span class="meta-value">{{ $vendorName }}</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="content">
            <div class="section-title no-break">Order Status Summary</div>
            <table class="summary no-break">
                <tr>
                    @foreach($statusSummary as $status)
                        <td>
                            <div class="summary-card">
                                <div class="summary-accent" style="background: {{ $statusAccentColors[$status] ?? '#64748b' }};"></div>
                                <div class="summary-label">{{ ucwords(str_replace('_', ' ', $status)) }}</div>
                                <div class="summary-count">{{ data_get($statusCounts, $status, 0) }}</div>
                            </div>
                        </td>
                    @endforeach
                </tr>
            </table>

            <div class="section-title no-break">Detailed Orders</div>

            @forelse($orders as $order)
                @php
                    $customerName = trim((data_get($order, 'customer.first_name', '') . ' ' . data_get($order, 'customer.last_name', '')));
                    $customerName = $customerName !== '' ? $customerName : data_get($order, 'customer.name', 'N/A');
                    $customerName = $customerName !== 'N/A' ? ucwords(strtolower($customerName)) : $customerName;
                    $customerPhone = data_get($order, 'customer.phone');
                    $productName = data_get($order, 'product.product_name', 'N/A');
                    $unitPrice = (float) data_get($order, 'product.unit_price', 0);
                    $shippingCost = (float) ($order->shipping_cost ?? 0);
                    $grandTotal = (float) $order->total_price + $shippingCost;
                    $statusClass = in_array($order->status, ['delivered', 'cancelled', 'confirmed', 'pending'], true)
                        ? 'badge-' . $order->status
                        : 'badge-default';
                    if (in_array($order->status, ['out_for_delivery', 'returned', 'packaging', 'failed_delivery'], true)) {
                        $statusClass = 'badge-' . $order->status;
                    }
                @endphp

                <div class="order-card no-break">
                    <table class="order-card-header">
                        <tr>
                            <td>
                                <div class="card-order-no">{{ $order->order_no }}</div>
                                <div class="card-order-date">{{ optional($order->created_at)->format('d M Y, h:i A') }}</div>
                            </td>
                            <td style="text-align: right;">
                                <span class="badge {{ $statusClass }}">{{ ucwords(str_replace('_', ' ', $order->status)) }}</span>
                            </td>
                        </tr>
                    </table>

                    <table class="order-details">
                        <tr>
                            <td>
                                <div class="field-label">Customer Name</div>
                                <div class="field-value">{{ $customerName }}</div>
                            </td>
                            <td>
                                <div class="field-label">Customer Phone</div>
                                <div class="field-value">{{ $customerPhone ?: 'N/A' }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="field-label">Product Name</div>
                                <div class="field-value">{{ $productName }}</div>
                            </td>
                            <td>
                                <div class="field-label">Product Price</div>
                                <div class="field-value">&#8377;{{ number_format($unitPrice, 2) }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="field-label">Qty</div>
                                <div class="field-value">{{ $order->quantity }}</div>
                            </td>
                            <td>
                                <div class="field-label">Status</div>
                                <div class="field-value">{{ ucwords(str_replace('_', ' ', $order->status)) }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="field-label">Total</div>
                                <div class="field-value amount">&#8377;{{ number_format($grandTotal, 2) }}</div>
                            </td>
                            <td>
                                <div class="field-label">Order ID</div>
                                <div class="field-value">{{ $order->order_no }}</div>
                            </td>
                        </tr>
                    </table>
                </div>
            @empty
                <div class="order-card no-break">
                    <div class="empty-state">
                        <div style="font-size: 28px; color: #94a3b8;">No data</div>
                        <div class="empty-title">No Orders Found</div>
                        <div style="margin-top: 4px; font-size: 12px;">Try changing the filter or date range to load data.</div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="footer no-break">
        <div class="footer-inner">
            <span class="footer-brand">Aerthh.com</span>
            <span class="footer-sub"> | Vendor order report | </span>
            <span class="footer-sub"> | Date : {{ $generatedAt }}</span>
        </div>
    </div>
</body>
</html>
