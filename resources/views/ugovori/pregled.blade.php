@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 bg-white">
                <div class="col-2 mt-3 mb-5">
                    <a href="/ugovori/kreiraj" class="btn buttonOutline btn-lg fontVariant w-100">Kreiraj novi</a>
                </div>
                <table id="ugovori" class="table border">
                    <thead>
                    <tr>
                        <th>Broj ugovora</th>
                        <th>Broj aneksa ugovora</th>
                        <th>Najmodavac</th>
                        <th>Početak ugovora</th>
                        <th>Kraj ugovora</th>
                        <th>Moment plaćanja</th>
                        <th>Šifra dobavljača</th>
                        <th>Mjesto troška</th>
                        <th>Šifra mjesta troška</th>
                        <th>Datum plaćanja</th>
                        <th>Inaktivan</th>
                        <th class="no-sort" style="width: auto">Akcija</th>
                        <th class="no-sort" style="width: auto" ></th>
                        <th class="no-sort" style="width: auto" ></th>
                        <th class="no-sort" style="width: auto" ></th>
                    </tr>
                    </thead>
                    <tbody >
                    @foreach($ugovori as $ugovor)
                        <tr>
                            <td>{{$ugovor['broj_ugovora']}}</td>
                            <td>{{$ugovor['broj_aneksa_ugovora']}}</td>
                            <td>{{$ugovor['najmodavac']}}</td>
                            <td>{{\Carbon\Carbon::createFromFormat('Y-m-d', $ugovor['pocetak_koristenja_imovine'])->format('Y-m-d')}}</td>
                            <td>{{\Carbon\Carbon::createFromFormat('Y-m-d', $ugovor['istek_ugovora'])->format('Y-m-d')}}</td>
                            <td>
                                @if ($ugovor['moment_placanja'] == "na početku perioda") {{"na početku perioda"}}
                                @else {{"na kraju perioda"}}
                                @endif
                            </td>
                            <td>
                                {{$ugovor->sifra_dobavljaca}}
                            </td>
                            <td>{{$ugovor['mjesto_troska']}}</td>
                            <td>{{$ugovor['sifra_troska']}}</td>
                            <td>{{$ugovor['datum_placanja']}}</td>
                            <td>@if($ugovor['inaktivan']) Da @else Ne @endif</td>
                            <td class="block text-center" style="min-width: 90px;">
                                <a href="/ugovori/pregled_ugovora/{{$ugovor['id']}}" class="action"><img src="/images/search.png">Pregled</a>
                            </td>
                            <td class="block text-center" style="min-width: 90px;">
                                <a href="/ugovori/izmijeni/{{$ugovor['id']}}" class="action"><img src="/images/edit.png">Izmjena</a>
                            </td>
                            <td class="block text-center" style="min-width: 90px;">
                                <form action="/ugovori/inaktivan/{{$ugovor['id']}}" method="post">
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button type="button" class="action bg-transparent border-0" onclick="exampleModal()" data-whatever="@getbootstrap"><img src="/images/edit.png">Označi kao inaktivan</button>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Odaberite datum inaktivnosti</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="/ugovori/obrisi/{{$ugovor['id']}}" method="POST">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <input name="_method" type="hidden" value="POST">
                                                        <span>Datum:</span>
                                                        <input type="text" name="datum" id="datum">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                                                        <button type="submit" class="btn btn-primary">Inaktivan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            <td class="block text-center" style="min-width: 90px;">
                                <form action="/ugovori/obrisi/{{$ugovor['id']}}" method="post">
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button class="action bg-transparent border-0" type="submit" onclick="return confirm('Da li ste sigurni da želite da izbrišete ugovor?');"><img src="/images/delete.png">Obriši</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        function exampleModal() {
            $("#exampleModal").modal();
            $( "#datum" ).datepicker({
                dateFormat : 'yy/mm/dd',
                changeMonth: true,
                changeYear: true,
            });
        }
        var table = $(document).ready(function() {
            $('#ugovori').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Svi_ugovori'
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        title: 'Svi_ugovori'
                    }
                ],
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
