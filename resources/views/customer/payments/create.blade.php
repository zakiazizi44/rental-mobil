@extends('layouts.customer')

@section('title', 'Pembayaran')

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <a href="{{ route('customer.bookings.show', $booking) }}" class="inline-flex items-center gap-1 text-sm font-medium text-navy-700 hover:text-navy-800">
            <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke detail booking
        </a>

        <h1 class="mt-4 text-3xl font-bold text-slate-900">Pembayaran</h1>
        <p class="mt-1 text-slate-500">{{ $booking->booking_code }}</p>

        <div class="mt-8 grid gap-8 lg:grid-cols-2">
            <!-- Ringkasan & metode -->
            <div class="card p-6">
                <h2 class="text-lg font-semibold text-slate-900">Ringkasan Pembayaran</h2>

                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Mobil</dt>
                        <dd class="font-semibold text-slate-900">{{ $booking->car?->name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Periode</dt>
                        <dd class="font-semibold text-slate-900">{{ $booking->start_date->format('d M Y') }} – {{ $booking->end_date->format('d M Y') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Jumlah hari</dt>
                        <dd class="font-semibold text-slate-900">{{ $booking->total_days }} hari</dd>
                    </div>
                    <div class="flex justify-between border-t border-slate-200 pt-3">
                        <dt class="font-medium text-slate-900">Total Bayar</dt>
                        <dd class="text-xl font-bold text-navy-700">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <h3 class="text-sm font-semibold text-slate-900">Metode Pembayaran</h3>
                    <p class="mt-1 text-xs text-slate-500">
                        Silakan klik tombol bayar untuk memilih metode:
                        <strong>Virtual Account (BCA/Mandiri/BRI/BNI), QRIS, atau E-Wallet (GoPay/OVO/Dana/Shopeepay)</strong>.
                    </p>
                </div>

                @if ($isSandbox)
                    <div class="mt-4 rounded-lg bg-yellow-50 p-3 text-xs text-yellow-800">
                        <i data-lucide="flask-conical" class="inline h-4 w-4"></i>
                        Mode Sandbox (uji coba) — pembayaran tidak menggunakan uang sungguhan.
                    </div>
                @endif
            </div>

            <!-- Tombol bayar -->
            <div class="card p-6">
                <h2 class="text-lg font-semibold text-slate-900">Selesaikan Pembayaran</h2>
                <p class="mt-2 text-sm text-slate-600">
                    Klik tombol di bawah, lalu selesaikan pembayaran melalui jendela pembayaran Midtrans yang muncul.
                </p>
                <p class="mt-1 text-xs text-slate-500">
                    Status pembayaran akan diperbarui secara otomatis setelah transaksi berhasil.
                </p>

                <button type="button" id="snapPayBtn" class="btn-primary mt-6 w-full py-3 text-base">
                    <i data-lucide="credit-card" class="h-5 w-5"></i>
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </section>

    {{-- Quick action store setelah snap sukses --}}
    <form id="paymentResultForm" method="POST" action="{{ route('customer.payments.store', $booking) }}" class="hidden">
        @csrf
        <input type="hidden" name="order_id" id="resultOrderId">
        <input type="hidden" name="transaction_id" id="resultTransactionId">
        <input type="hidden" name="payment_type" id="resultPaymentType">
        <input type="hidden" name="transaction_status" id="resultTransactionStatus">
    </form>

    <script src="{{ $isSandbox ? 'https://app.sandbox.midtrans.com/snap/snap.js' : 'https://app.midtrans.com/snap/snap.js' }}" data-client-key="{{ $clientKey }}"></script>
    <script src="https://unpkg.com/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) lucide.createIcons();

            if (typeof snap === 'undefined') {
                document.getElementById('snapPayBtn').addEventListener('click', function () {
                    Swal.fire({ icon: 'error', title: 'Gagal memuat pembayaran', text: 'Sistem pembayaran tidak dapat dimuat. Coba lagi nanti.' });
                });
                return;
            }

            window.snapToken = @json($snapToken);
            window.paymentStoreUrl = @json(route('customer.payments.store', $booking));

            document.getElementById('snapPayBtn').addEventListener('click', function () {
                snap.pay(window.snapToken, {
                    onSuccess: function (result) {
                        fillAndSubmit(result);
                    },
                    onPending: function (result) {
                        fillAndSubmit(result);
                    },
                    onError: function (result) {
                        Swal.fire({ icon: 'error', title: 'Pembayaran gagal', text: result.status_message || 'Terjadi kesalahan.' });
                    },
                    onClose: function () {
                        Swal.fire({ icon: 'info', title: 'Pembayaran ditutup', text: 'Transaksi belum dikonfirmasi. Anda bisa melanjutkan pembayaran kapan saja.' });
                    }
                });
            });

            function fillAndSubmit(result) {
                document.getElementById('resultOrderId').value = result.order_id || '';
                document.getElementById('resultTransactionId').value = result.transaction_id || '';
                document.getElementById('resultPaymentType').value = result.payment_type || '';
                document.getElementById('resultTransactionStatus').value = result.transaction_status || '';
                document.getElementById('paymentResultForm').submit();
            }
        });
    </script>
@endsection
