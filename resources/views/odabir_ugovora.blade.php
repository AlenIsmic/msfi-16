@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div class="card-header title">
                    Odabir vrste izvještaja
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col mb-3 pt-3 pb-3  bghome">
                            <table>
                                <tr>
                                    <td><img src="/images/otplatni_plan.png"></td>
                                    <td><a href="/pregled_dugovanja" class="fontVariant w-100 title">Pregled dugovanja</a></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col ml-3 mb-3 pt-3 pb-3  bghome">
                            <table>
                                <tr>
                                    <td><img src="/images/otplatni_plan.png"></td>
                                    <td><a href="/izvjestaj_biljeske" class="fontVariant w-100 title">Izvještaj za bilješke</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush
