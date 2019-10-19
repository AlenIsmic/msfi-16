@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card w-75">
                <div class="card-header title">
                    Pregled dugovanja
                </div>
                <div class="card-body" id="dugovanje">
                </div>
                <hr>
                <div class="card-body">
                    <h5 class="bg-transparent">Ukupan iznos dugovanja:</h5><h5 class="title" id="sumaDugovanja"></h5>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        function formatMoney(amount, decimalCount = 2, decimal = ",", thousands = ".") {
            try {
                decimalCount = Math.abs(decimalCount);
                decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

                const negativeSign = amount < 0 ? "-" : "";

                let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
                let j = (i.length > 3) ? i.length % 3 : 0;

                return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "") + " KM";
            } catch (e) {
                console.log(e)
            }
        }

        var htmlDugovanje = document.getElementById('dugovanje')
        var ugovori = JSON.parse('@php echo JSON_encode($u) @endphp')
        var dugovanje = JSON.parse('@php echo JSON_encode($d) @endphp')
        var sumaDugovnja = JSON.parse('@php echo JSON_encode($sumaDugovanja) @endphp')


        var suma = 0;
        for (var j = 0; j < ugovori.length; j++) suma += parseFloat(dugovanje[j]);

        for (var i = 0; i<ugovori.length; i = i + 2){
            var drugo_dugovanje = (typeof (dugovanje[i+1]) === "undefined") ? "" :  formatMoney(dugovanje[i+1]);
            var drugi_ugovor = (typeof (ugovori[i+1]) === "undefined") ? "" : "Broj ugovora: <b>" + ugovori[i+1]+"</b>";
                htmlDugovanje.innerHTML+=
                '<div class="row">' +
                    '<div class="col-md-6 w-100 mt-1 mb-1">' +
                        '<p class="d-inline-block border-bottom mb-0 w-50" style="font-size: 12px;">Broj ugovora: <b>'+ ugovori[i] + '</b></p>' +
                        '<p class="d-inline-block border-bottom mb-0 text-left" style="font-size: 12px; width:20%">Dugovanje:</p>' +
                        '<p class="d-inline-block border-bottom mb-0 text-right" style="font-size: 12px; width:30%"><b>' + formatMoney(dugovanje[i]) + '</b></p>' +
                    '</div>' +
                    '<div class="col-md-6  mt-1 mb-1">' +
                        '<p class="d-inline-block border-bottom mb-0 w-50" style="font-size: 12px;">'+  drugi_ugovor + '</p>' +
                        '<p class="d-inline-block border-bottom mb-0 text-left" style="font-size: 12px; width:20%">Dugovanje:</p>' +
                        '<p class="d-inline-block border-bottom  mb-0 text-right" style="font-size: 12px; width:30%"><b>' + drugo_dugovanje + '</b></p>' +
                    '</div>' +
                '</div>';
        }
        document.getElementById('sumaDugovanja').innerHTML = formatMoney(suma);
    </script>
@endpush
