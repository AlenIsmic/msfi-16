@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card w-75">
                <div class="card-header title">
                    Izvještaj za bilješke
                </div>
                @php
                    function money($number) {
                        return number_format($number,2, ',', '.')." KM";
                    }
                @endphp
                @if ($tipIzvjestaja == 'mjesecni')
                    <div class="card-body">
                        <table class="border w-100">
                            <tbody>
                            <tr>
                                <td colspan="9">
                                    <label>Vrste imovine:</label>
                                    @foreach($vrste_imovine as $imovina)
                                        <label class="font-weight-bold">{{$imovina['naziv']}}</label>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9">
                                    <label>Mjesto troška</label>
                                    @foreach($mjesta_troska as $trosak)
                                        <label class="font-weight-bold">{{$trosak}}</label>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9">
                                    <label>Sadašnja vrijednost na prvi dan ugovora:</label>
                                    <label class="font-weight-bold">@php echo(money($sadasnjaZaIzvjestaj)) @endphp</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9">
                                    <label>Nominalna vrijednost:</label>
                                    <label class="font-weight-bold">
                                        @php $suma = 0; @endphp
                                        @foreach($iznos_nominalne as $nominalna)
                                            @php $suma += $nominalna @endphp
                                        @endforeach
                                        @php
                                            echo (money($suma));
                                        @endphp
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="border"></td>
                                <td class="border">Knj. vr. na početku perioda</td>
                                <td class="border">Amortizacija</td>
                                <td class="border">Knj. vr. na kraju perioda</td>
                                <td class="border">Iznos glavnice</td>
                                <td class="border">Kamata</td>
                                <td class="border">Ugovorena najamnnina</td>
                                <td class="border">Ostatak duga</td>
                            </tr>
                            @foreach($datumi as $datum)
                                <tr>
                                    <td>{{\Carbon\Carbon::createFromFormat('Y/m/d',$datum)->format('d.m.Y')}}</td>
                                    <td align="center">
                                        @php
                                            echo (money($knj_na_pocetku[$datum]));
                                        @endphp
                                    </td>
                                    <td align="center">
                                        @php
                                            echo (money($amort[$datum]));
                                        @endphp
                                    </td>
                                    <td align="center">
                                        @php
                                            echo (money($knj_na_kraju[$datum]));
                                        @endphp
                                    </td>
                                    <td align="center">
                                        @php
                                            echo (money($iznos_glavnice[$datum]));
                                        @endphp
                                    </td>
                                    <td align="center">
                                        @php
                                            echo (money($kamata[$datum]));
                                        @endphp
                                    </td>
                                    <td align="center">
                                        @php
                                            echo (money($iznos_naknade[$datum]));
                                        @endphp
                                    </td>
                                    <td align="center">
                                        @php
                                            echo (money($ostatak_duga[$datum]));
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                @else
                    @php
                        $na_pocetku = 0;
                        $na_kraju = 0;
                        $amortizacija = 0;
                        $glavnica = 0;
                        $iznos_kamata = 0;
                        $ugovorena = 0;
                    @endphp
                    <div class="card-body">
                        <table class="border w-100">
                            <tbody>
                            <tr>
                                <td colspan="9">
                                    <label>Vrste imovine:</label>
                                    @foreach($vrste_imovine as $imovina)
                                        <label class="font-weight-bold">{{$imovina['naziv']}}</label>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9">
                                    <label>Mjesto troška</label>
                                    @foreach($mjesta_troska as $trosak)
                                        <label class="font-weight-bold">{{$trosak}}</label>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9">
                                    <label>Sadašnja vrijednost na prvi dan ugovora:</label>
                                    <label class="font-weight-bold">@php echo(money($sadasnjaZaIzvjestaj)) @endphp</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9">
                                    <label>Nominalna vrijednost:</label>
                                    <label class="font-weight-bold">
                                        @php $suma = 0; @endphp
                                        @foreach($iznos_nominalne as $nominalna)
                                            @php $suma += $nominalna @endphp
                                        @endforeach
                                        @php
                                            echo (money($suma));
                                        @endphp
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="border"></td>
                                <td class="border">Knj. vr. na početku perioda</td>
                                <td class="border">Amortizacija</td>
                                <td class="border">Knj. vr. na kraju perioda</td>
                                <td class="border">Iznos glavnice</td>
                                <td class="border">Kamata</td>
                                <td class="border">Ugovorena najamnnina</td>
                                <td class="border">Ostatak duga</td>
                            </tr>
                            @foreach($datumi as $datum)
                                @if (\Carbon\Carbon::createFromFormat('Y/m/d', $datum)->format('m') == '01')
                                    @php
                                        $na_pocetku = $knj_na_pocetku[$datum];
                                        $amortizacija = $amort[$datum];
                                        $glavnica = $iznos_glavnice[$datum];
                                        $iznos_kamata = $kamata[$datum];
                                        $ugovorena = $iznos_naknade[$datum];
                                    @endphp
                                @else
                                    @php
                                        $amortizacija += $amort[$datum];
                                        $na_kraju = $na_pocetku - $amortizacija;
                                        $glavnica += $iznos_glavnice[$datum];
                                        $iznos_kamata += $kamata[$datum];
                                        $ugovorena += $iznos_naknade[$datum];
                                    @endphp
                                @endif
                                @if (\Carbon\Carbon::createFromFormat('Y/m/d', $datum)->format('m')== '12')
                                    <tr>
                                        <td>{{\Carbon\Carbon::createFromFormat('Y/m/d',$datum)->format('Y')}}</td>
                                        <td align="center">
                                            @php
                                                echo (money($na_pocetku));
                                            @endphp
                                        </td>
                                        <td align="center">
                                            @php
                                                echo (money($amortizacija));
                                            @endphp
                                        </td>
                                        <td align="center">
                                            @php
                                                echo (money($na_kraju));
                                            @endphp
                                        </td>
                                        <td align="center">
                                            @php
                                                echo (money($glavnica));
                                            @endphp
                                        </td>
                                        <td align="center">
                                            @php
                                                echo (money($iznos_kamata));
                                            @endphp
                                        </td>
                                        <td align="center">
                                            @php
                                                echo (money($ugovorena));
                                            @endphp
                                        </td>
                                        <td align="center">
                                            @php
                                                echo (money($ostatak_duga[$datum]));
                                            @endphp
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#izvjestaj').DataTable( {
                "language": {
                    "decimal":        "",
                    "emptyTable":     "Nema podataka",
                    "info":           "Prikaz _START_ do _END_ od _TOTAL_ ugovora",
                    "infoEmpty":      "Prikaz 0 do 0 od 0 ugovora",
                    "infoFiltered":   "(filterisano od _MAX_ ukupno ugovora)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Prikaz _MENU_ ugovora",
                    "loadingRecords": "Učitavanje...",
                    "processing":     "Procesiranje...",
                    "search":         "Pretraga:",
                    "zeroRecords":    "Nije pronađeno",
                    "paginate": {
                        "first":      "Početna",
                        "last":       "Zadnja",
                        "next":       "Naredna",
                        "previous":   "Prethodna"
                    },
                    "aria": {
                        "sortAscending":  ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                },
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,
                } ],
                "info": false
            } );
        } );
    </script>
@endpush
