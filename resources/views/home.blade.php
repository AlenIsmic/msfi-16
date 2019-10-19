@extends('layouts.app')
@section('content')
    <div class="container mt-3">
        <div class="row justify-content-center mb-3">
                <div class="col-md-6 bghome">
                    <table class="border w-100">
                        <tr>
                            <td><img src="/images/info.png"></td>
                            <td><a href="/odredjivanje_najma" class="fontVariant w-100 title">Određivanje najma</a></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 bghome">
                    <table class="border w-100">
                        <tr>
                            <td><img src="/images/novi_ugovor.png"></td>
                            <td><a href="/ugovori/kreiraj" class="fontVariant w-100 title">Kreiranje novog ugovora</a></td>
                        </tr>
                    </table>
                </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 bghome">
                <table class="border w-100">
                    <tr>
                        <td><img src="/images/pregled_ugovora.png"></td>
                        <td><a href="/ugovori/pregled" class="fontVariant w-100 title">Pregled postojećih ugovora</a></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 bghome">
                <table class="border w-100">
                    <tr>
                        <td><img src="/images/otplatni_plan.png"></td>
                        <td><a href="/odabir_ugovora" class="fontVariant w-100 title">Odabir izvještaja</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush
