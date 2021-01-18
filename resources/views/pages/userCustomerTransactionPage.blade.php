@extends('layouts.base')

@section('title', 'Beranda')

@section('extra-fonts')

@endsection

@section('prerender-js')
<script>
    const dummyData = [
            {
                id: "12d11dx",
                name: "Relawan Covid A",
                price: "120000",
                start_date: "10/05/2020, 12:38:00 AM",
                end_date: "10/30/2020, 12:38:00 AM",
            },
            {
                id: "12d11da",
                name: "Demo Omnibus Law A",
                price: "120000",
                start_date: "10/05/2020, 12:38:00 AM",
                end_date: "10/30/2020, 12:38:00 AM",
            },
        ]

        function getTransactionData(id) {

            const data = dummyData.find((data) => data.id == id);
            const name = data.name
            const price = data.price
            const start_date = new Date(data.start_date)
            const end_date = new Date(data.end_date)

            return {
                id,
                name,
                price,
                start_date,
                end_date,
            }
        }

    function getPercentage(start, end) {
        const startDate = new Date(start).getTime();
        const endDate = new Date(end).getTime();
        const today = new Date().getTime();
        const total = endDate - startDate;
        const indicator = today - startDate;
        const progress = indicator / total;
        return progress.toFixed(2) * 100;
    }

    function getRemainingDay(end) {
        const endDate = new Date(end).getTime();
        const today = new Date().getTime();
        const difference = endDate - today;
        const remainingDay = difference / (1000 * 3600 * 24);
        if (remainingDay > 1) return Math.round(remainingDay) + " hari lagi";
        else if (remainingDay * 24 > 1)
            return Math.round(remainingDay * 24) + " jam lagi";
        else if (remainingDay * 24 * 60 > 1) return Math.round(remainingDay * 24 * 60) + "menit lagi";
        else return "selesai"
    }
</script>
@endsection

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/userCustomerTransaction.css') }}">
    <link rel="stylesheet" href="{{ asset('css/listItem.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
@include('layouts/modalUploadPayment')

<div class="userCustomerTransaction">
    <div class="userCustomerTransaction__container">
        <div class="userCustomerTransaction__header">
            <h2 class="userCustomerTransaction__title">Transaksi</h2>
        </div>
        <div class="userCustomerTransaction__transactions">
            <div class="userCustomerTransaction__transactions__header list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active" id="list-all-list" data-toggle="list" href="#list-all" role="tab" aria-controls="all">Semua</a>
                <a class="list-group-item list-group-item-action" id="list-sample-list" data-toggle="list" href="#list-sample" role="tab" aria-controls="sample">Sample</a>
                <a class="list-group-item list-group-item-action" id="list-deposit-list" data-toggle="list" href="#list-deposit" role="tab" aria-controls="deposit">Deposit</a>
                <a class="list-group-item list-group-item-action" id="list-repayment-list" data-toggle="list" href="#list-repayment" role="tab" aria-controls="repayment">Pelunasan</a>
            </div>
            <div class="userCustomerTransaction__transactions__list header tab-content" id="nav-tabContent">
                
                <!-- Semua Transaksi -->
                <div class="tab-pane fade show active" id="list-all" role="tabpanel" aria-labelledby="list-all-list">
                    <!-- TODO: Make List Item -->
                    <div class="listItem">
                        <a href="/user/customer/transaction/1" class="listItem--left">
                            <div class="listItem__header">
                                <h5 class="listItem__name mb-0"></h5>
                                <p class="listItem__price"></p>
                                <p class="listItem__amount"></p>
                            </div>
                        </a>
                        <div class="listItem--right">
                            <a href="/user/customer/transaction/1" class="listItem__label">
                                <p class="listItem__category"></p>
                                <p class="listItem__paidStatus"></p>
                                <!-- Uncomment if paidStatus is not SUDAH DIBAYAR -->
                                <div 
                                    data-startDate="2020-10-18T02:00"
                                    data-endDate="2020-12-18T10:00"
                                    class="listItem__status--progress progress">
                                    <div class="progress-bar" role="progressbar"></div>
                                </div>
                            </a>
                            <div class="listItem__credential">
                                <!-- Uncomment one of element if paidStatus is BELUM DIBAYAR or SUDAH DIBAYAR  -->
                                <button data-modalId="12d11dx" class="btn btn-outline-danger mr-0" data-toggle="modal" data-target="#uploadPayment">Unggah Bukti Pembayaran</button>
                                <!-- <a href="#"><button class="btn btn-outline-danger mr-0">Unduh MOU</button></a> -->
                                <a href="#"><button class="btn btn-outline-danger mr-0">Unduh Invoice</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Penawaran Terbuka -->
                <div class="tab-pane fade" id="list-sample" role="tabpanel" aria-labelledby="list-sample-list">
                </div>
                
                <!-- Transaksi Dalam Pengerjaan -->
                <div class="tab-pane fade" id="list-deposit" role="tabpanel" aria-labelledby="list-deposit-list">
                    <!-- TODO: Make List Item -->
                </div>
                
                <!-- Transaksi Selesai -->
                <div class="tab-pane fade" id="list-repayment" role="tabpanel" aria-labelledby="list-repayment-list">
                    <!-- TODO: Make List Item -->
                </div>
                
                <!-- Transaksi Dibatalkan -->
                <div class="tab-pane fade" id="list-cancel" role="tabpanel" aria-labelledby="list-cancel-list">
                    <!-- TODO: Make List Item -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script src="{{ asset('js/form.js') }}"></script>
<script src="{{ asset('js/helper.js') }}"></script>
<script>
    $(".listItem__status--progress").each((e, el) => {
        const startDate = el.getAttribute("data-startDate");
        const endDate = el.getAttribute("data-endDate");
        const percentage = getPercentage(startDate, endDate);
        const remainingDay = getRemainingDay(endDate)
        el.children[0].style.width = `${percentage !== Infinity ? percentage: 100}%`;
        if (percentage === Infinity || percentage > 100) {
            el.children[0].style.backgroundColor = "#1CAE94"
            el.children[0].style.color = "#fff"
        }
        el.children[0].innerHTML = `<p>${remainingDay}</p>`
    })

    $("button[data-target='#uploadPayment']").on("click", (e) => {
        const id = e.target.getAttribute("data-modalId")
        const data = getTransactionData(id);
        $("#payment-id-text").text(data.id);
        $("#payment-name-text").text(data.name);
        $("#payment-price-text").text(priceFormat(data.price));
        $("#payment-id").val(data.id);
    })
</script>
@endsection
