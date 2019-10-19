@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card w-75">
                <div class="card-header title">
                    Pregled dugovanja
                </div>
                <form method="post" action="/biljeske">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <span class='hr-title'>Unesite parametre izvještaja</span>
                        <div class="border p-2 mb-4">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="input-group-prepend">
                                        <span class="bg-transparent">Period od:</span>
                                    </div>
                                    <input type="text" class="form-control" class="form-control inline-block" id="period_od" name="period_od" autocomplete="off">
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group-prepend">
                                        <span class="bg-transparent">Period do:</span>
                                    </div>
                                    <input type="text" class="form-control" class="form-control inline-block" id="period_do" name="period_do" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 overflow-auto">
                                    <div class="input-group-prepend">
                                        <span class="bg-transparent" for="vrsta_imovine">Vrsta imovine:</span>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" onClick="toggle(this)" value="Označi/Odznači sve">
                                        <label class="form-check-label">Označi/Odznači sve</label>
                                    </div>
                                    @foreach ($vrste_imovine as $imovina)
                                        <div class="form-check">
                                            <input class="form-check-input checkbox" type="checkbox" id="{{$imovina->id}}" value="{{$imovina->id}}" name="{{$imovina->id}}">
                                            <label class="form-check-label" for="inlineCheckbox1">{{$imovina->naziv}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 overflow-auto">
                                    <div class="input-group-prepend">
                                        <span class="bg-transparent">Mjesto troška:</span>
                                    </div>
                                    <input class="input-group" type="text" name="mjesto_troska" id="mjesto_troska" autocomplete="off">
                                </div>
                                <div class="col-md-6 overflow-auto">
                                    <div class="input-group-prepend">
                                        <span class="bg-transparent" for="vrsta_imovine">Šifra mjesta troška:</span>
                                    </div>
                                    <input type="text" class="input-group" name="sifra_troska" id="sifra_troska" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 overflow-auto">
                                    <div class="input-group-prepend">
                                        <span class="bg-transparent">Ispis:</span>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="mjesecni" value="mjesecni" name="mjesecni">
                                        <label class="form-check-label" for="inlineCheckbox1">Mjesečni</label>
                                        <br>
                                        <input class="form-check-input" type="radio" id="mjesecni" value="godisnji" name="mjesecni">
                                        <label class="form-check-label" for="inlineCheckbox1">Godišnji</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <button class="btn buttonOutline btn-lg fontVariant w-100"  type="submit">Kreiraj izvještaj</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        function toggle(source) {
            checkboxes = document.getElementsByClassName('checkbox')
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }
        $( function() {
            $( "#period_od" ).datepicker({
                dateFormat : 'yy/mm/dd',
                changeMonth: true,
                changeYear: true,
                onSelect: function(t) {
                    if ($('#pocetak_koristenja_imovine')[0].value != '' && $('#istek_ugovora')[0].value != '') {
                        var diff = monthDiff(new Date($('#pocetak_koristenja')[0].value), new Date($('#istek_ugovora')[0].value));
                        document.getElementsByName('neoopozivi_period')[0].value = diff + 1;
                        document.getElementsByName('neoopozivi_period_prikaz')[0].value = diff+1;
                        trajanjeUgovoraVrijednost();
                    }
                }
            });
            $( "#period_do" ).datepicker({
                dateFormat : 'yy/mm/dd',
                changeMonth: true,
                changeYear: true,
                onSelect: function(t) {
                    if ($('#pocetak_koristenja_imovine')[0].value != '' && $('#istek_ugovora')[0].value != '') {
                        var diff = monthDiff(new Date($('#pocetak_koristenja')[0].value), new Date($('#istek_ugovora')[0].value));
                        document.getElementsByName('neoopozivi_period')[0].value = diff + 1;
                        document.getElementsByName('neoopozivi_period_prikaz')[0].value = diff+1;
                        trajanjeUgovoraVrijednost();
                    }
                }
            });
        } );
    </script>
@endpush
