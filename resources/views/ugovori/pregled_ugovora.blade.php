@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <form method="post" action="/ugovori/izmijeni/{{$ugovori->id}}" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (\Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ \Session::get('success') }}</p>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header title">
                            Pregled postojećeg ugovora
                        </div>
                        <div class="card-body">
                            <span class='hr-title'>Osnovni podaci</span>
                            <div class="border p-2 mb-4">
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="broj_ugovora">Broj ugovora:</span>
                                        </div>
                                        <input type="text" class="form-control inline-block" name="broj_ugovora" autocomplete="off" value="{{$ugovori->broj_ugovora}}" disabled>
                                    </div>
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="broj_aneksa_ugovora">Broj aneksa ugovora:</span>
                                        </div>
                                        <input type="text" class="form-control inline-block" name="broj_aneksa_ugovora" autocomplete="off" value="{{$ugovori->broj_aneksa_ugovora}}" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="najmodavac">Najmodavac:</span>
                                        </div>
                                        <input type="text" class="form-control inline-block" name="najmodavac" value="{{$ugovori->najmodavac}}" disabled>
                                    </div>
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="povezano_lice">Najmodavac je povezano lice:</span>
                                        </div>
                                        <select class="selectpicker form-control" name="povezano_lice" disabled>
                                            <option {{$ugovori->povezano_lice === 'DA' ? 'selected' : ''}}>DA</option>
                                            <option {{$ugovori->povezano_lice === 'NE' ? 'selected' : ''}}>NE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="mjesto_troska">Mjesto troška:</span>
                                        </div>
                                        <input type="text" class="form-control inline-block" name="mjesto_troska" value="{{$ugovori->mjesto_troska}}" disabled>
                                    </div>
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="mjesto_troska">Šifra mjesta troška:</span>
                                        </div>
                                        <input type="text" class="form-control inline-block" name="mjesto_troska" value="{{$ugovori->sifra_troska}}" disabled>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="napomena">Napomena:</span>
                                        </div>
                                        <textarea class="text-body w-100 h-auto" name="napomena" disabled>{{$ugovori->napomena}}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="lokacija">Lokacija:</span>
                                        </div>
                                        <input type="text" class="form-control inline-block" name="lokacija" value="{{$ugovori->lokacija}}" disabled>
                                    </div>
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="vrsta_imovine">Vrsta imovine:</span>
                                        </div>
                                        <select class="selectpicker form-control" onchange="trajanjeUgovora()" name="vrsta_imovine" disabled>
                                            @foreach ($vrste_imovine as $imovina)
                                                <option {{$ugovori->vrsta_imovine_id === $imovina->id ? 'selected' : ''}}>{{$imovina->naziv}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="sifra_dobavljaca">Šifra dobavljača:</span>
                                        </div>
                                        <input type="text" class="form-control inline-block" name="sifra_dobavljaca" value="{{$ugovori->sifra_dobavljaca}}" autocomplete="off">
                                    </div>
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="entitet">Entitet:</span>
                                        </div>
                                        <select class="selectpicker form-control" name="entitet" disabled="">
                                            <option>{{$ugovori->entitet}}</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="tip_dobavljaca">Tip dobavljača:</span>
                                        </div>
                                        <select class="selectpicker form-control" name="tip_dobavljaca" disabled>
                                            <option>{{$ugovori->tip_dobavljaca}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <span class='hr-title'>Trajanje ugovora</span>
                            <div class="border p-2 mb-4">
                                <div class="form-row mb-4">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="opcija_trajanja_ugovora">Odaberite opciju trajanja ugovora:</span>
                                        </div>
                                        <select class="selectpicker form-control" onchange="trajanjeUgovora()" name="opcija_trajanja_ugovora" disabled>
                                            <option {{$ugovori->opcija_trajanja_ugovora === "Do jedne godine sa ugovorenom opcijom produženja" ? 'selected' : ''}}>Do jedne godine sa ugovorenom opcijom produženja</option>
                                            <option {{$ugovori->opcija_trajanja_ugovora === "Do jedne godine bez ugovorene opcije produženja" ? 'selected' : ''}}>Do jedne godine bez ugovorene opcije produženja</option>
                                            <option {{$ugovori->opcija_trajanja_ugovora === "Više od jedne godine" ? 'selected' : ''}}>Više od jedne godine</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row" style="visibility: hidden; height: 0px;" id="izuzece">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="izuzece">Da li želite primjenjivati izuzeće za priznavanje?</span>
                                        </div>
                                        <select class="selectpicker form-control" name="izuzece" disabled>
                                            <option {{$ugovori->povezano_lice === 'DA' ? 'selected' : ''}}>DA</option>
                                            <option {{$ugovori->povezano_lice === 'NE' ? 'selected' : ''}}>NE</option>
                                        </select>
                                    </div>
                                </div>
                                <span class='hr-title-grey'>Vremenski period</span>
                                <div class="form-row border-left  border-right border-top ml-1 mr-1 pt-1 pb-2">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="pocetak_koristenja_imovine">Početak korištenja imovine:</span>
                                        </div>
                                        <input type="text" class="form-control" id="pocetak_koristenja_imovine" name="pocetak_koristenja_imovine" autocomplete="off" value="{{$ugovori->pocetak_koristenja_imovine}}" disabled>
                                    </div>
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="istek_ugovora">Istek ugovora:</span>
                                        </div>
                                        <input type="text" class="form-control" id="istek_ugovora" name="istek_ugovora" autocomplete="off" value="{{$ugovori->istek_ugovora}}" disabled>
                                    </div>
                                </div>


                                <div class="form-row border-left  border-right border-bottom ml-1 mr-1 pt-1 pb-3">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="neoopozivi_period">Inicijalni period:</span>
                                        </div>
                                        <input type="text" class="form-control" name="neoopozivi_period_prikaz" autocomplete="off" value="{{$ugovori->neoopozivi_period}}" disabled>
                                        <input type="text" class="form-control" name="neoopozivi_period" autocomplete="off" value="{{$ugovori->neoopozivi_period}}" hidden>
                                    </div>
                                </div>
                                <div class="form-row border-left  border-right ml-1 mr-1 pt-1 pb-2">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="trajanje_otkaznog_roka">Trajanje otkaznog roka:</span>
                                        </div>
                                        <select class="selectpicker form-control" onchange="trajanjeUgovoraVrijednost()" name="trajanje_otkaznog_roka" id="trajanje_otkaznog_roka" disabled>
                                            @for ($i = 0; $i < 13; $i++)
                                                <option {{$ugovori->trajanje_otkaznog_roka == $i ? 'selected' : ''}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="produzenje">Periodi iskorištene opcije produženja:</span>
                                        </div>
                                        <select class="selectpicker form-control" onchange="trajanjeUgovoraVrijednost()" name="produzenje" id="produzenje" disabled>
                                            @for ($i = 0; $i < 601; $i++)
                                                <option {{$ugovori->produzenje == $i ? 'selected' : ''}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row border-left  border-right border-bottom ml-1 mr-1 pt-1 pb-3">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="trajanje_ugovora">Trajanje ugovora:</span>
                                        </div>
                                        <input type="text" class="form-control" name="trajanje_ugovora_prikaz" autocomplete="off" value="{{$ugovori->trajanje_ugovora}}" disabled>
                                        <input type="text" class="form-control" name="trajanje_ugovora" autocomplete="off" value="{{$ugovori->trajanje_ugovora}}" hidden>
                                    </div>
                                </div>
                            </div>

                            <span class='hr-title'>Predmet ugovora</span>
                            <div class="border p-2">
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="predmet_ugovora">Da li je predmet ugovora imovina male vrijednosti:</span>
                                        </div>
                                        <select class="selectpicker form-control" onchange="imovinaMaleVrijednosti()" name="predmet_ugovora" disabled>
                                            <option {{$ugovori->predmet_ugovora === 'DA' ? 'selected' : ''}}>DA</option>
                                            <option {{$ugovori->predmet_ugovora === 'NE' ? 'selected' : ''}}>NE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row pb-2 mb-4" style="visibility: visible; height: auto;" id="izuzece2">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="izuzece2">Da li želite primjenjivati izuzeće za priznavanje?</span>
                                        </div>
                                        <select class="selectpicker form-control" onchange="" name="izuzece2" disabled>
                                            <option {{$ugovori->izuzece2 === 'DA' ? 'selected' : ''}}>DA</option>
                                            <option {{$ugovori->izuzece2 === 'NE' ? 'selected' : ''}}>NE</option>
                                        </select>
                                    </div>
                                </div>
                                <span class='hr-title-grey'>Naknada</span>
                                <div class="row border-left border-right border-top ml-1 mr-1 pt-1 pb-2">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="moment_placanja">Momenat plaćanja:</span>
                                        </div>
                                        <select class="selectpicker form-control" onchange="imovinaMaleVrijednosti()" id="moment_placanja" name="moment_placanja" disabled>
                                            <option {{$ugovori->moment_placanja === "na početku perioda" ? 'selected' : ''}}>na početku perioda</option>
                                            <option {{$ugovori->moment_placanja === "na kraju perioda" ? 'selected' : ''}}>na kraju perioda</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="vrsta_placanja">Vrsta plaćanja:</span>
                                        </div>
                                        <select class="selectpicker form-control" onchange="iznosiNaknade()" id="vrsta_placanja" name="vrsta_placanja" disabled>
                                            <option {{$ugovori->vrsta_placanja === "fiksne najamnine" ? 'selected' : ''}}>fiksne najamnine</option>
                                            <option {{$ugovori->vrsta_placanja === "varijabilne najamnine" ? 'selected' : ''}}>varijabilne najamnine</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <div id="unaprijed_placeni_iznos_po_najmu" class="row border-left border-right border-bottom ml-1 mr-1 mb-4 pt-1 pb-3">
                                        <div class="col">
                                            <div class="input-group-prepend">
                                                <span class="bg-transparent" for="unaprijed_placeni_iznos">Unaprijed plaćeni iznos po najmu:</span>
                                            </div>
                                            <input type="number" step="any" class="form-control" id="unaprijed_placeni_iznos" name="unaprijed_placeni_iznos" value="{{$ugovori->unaprijed_placeni_iznos}}" autocomplete="off" disabled>
                                        </div>
                                        <div class="col">
                                            <div class="input-group-prepend">
                                                <span class="bg-transparent" for="pocetni_direktni_troskovi">Početni direktni troškovi:</span>
                                            </div>
                                            <input type="number" step="any" class="form-control" id="pocetni_direktni_troskovi" name="pocetni_direktni_troskovi" value="{{$ugovori->pocetni_direktni_troskovi}}" autocomplete="off" disabled>
                                        </div>
                                        <div class="col">
                                            <div class="input-group-prepend">
                                                <span class="bg-transparent" for="troskovi_demontaze">Troškovi demontaže:</span>
                                            </div>
                                            <input type="number" step="any" class="form-control" id="troskovi_demontaze" name="troskovi_demontaze" value="{{$ugovori->troskovi_demontaze}}" autocomplete="off" disabled>
                                        </div>
                                    </div>
                                    <div id="naknade_redovi" class="row border-left border-right border-bottom border-top ml-1 mr-1 mb-4 pt-1 pb-3">
                                        <div class="col">
                                            <div class="input-group-prepend">
                                                <span class="bg-transparent" for="iznos_naknade_0">Iznos naknade:</span>
                                            </div>
                                            <input type="number" step="any" class="form-control" id="iznos_naknade_0" name="iznos_naknade_0"  autocomplete="off" value="{{$iznosi_naknade->iznos_nakande}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <span class='hr-title-grey'>Diskontna stopa</span>
                                <div class="row border ml-1 mr-1 mb-3 pt-1 pb-3">
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="godisnja_kamatna_stopa">Godišnja kamatna stopa:</span>
                                        </div>
                                        <input type="text" class="form-control" id="godisnja_kamatna_stopa" onchange="mjesecnaDiskontnaStopa()" name="godisnja_kamatna_stopa" placeholder="Unesite u formatu 3.56" autocomplete="off" value="{{$ugovori->godisnja_kamatna_stopa}}" disabled>
                                    </div>
                                    <div class="col">
                                        <div class="input-group-prepend">
                                            <span class="bg-transparent" for="mjesecna_diskontna_stopa">Mjesečna diskontna stopa:</span>
                                        </div>
                                        <input type="text" class="form-control" name="mjesecna_diskontna_stopa_prikaz" autocomplete="off" value="{{$ugovori->mjesecna_diskontna_stopa}}" disabled>
                                        <input type="text" class="form-control" name="mjesecna_diskontna_stopa" autocomplete="off" value="{{$ugovori->mjesecna_diskontna_stopa}}" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="container bg-transparent mt-3 pl-0 pr-0" id="otplatna_tabela" style="visibility: hidden">

            <div class="card mb-3">
                <div class="card-header title">
                    <h2 class="title">Obračun sadašnje vrijednosti najma </h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            Godišnja kamatna stopa:
                        </div>
                        <div class="col" name="godisnja_kamatna_stopa_opis"></div>
                    </div>

                    <div class="row">
                        <div class="col">
                            Broj godina trajanja najma:
                        </div>
                        <div class="col" name="broj_godina"></div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Mjesečna stopa:
                        </div>
                        <div class="col" name="mjesecna_stopa"></div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Broj ukupnih plaćanja:
                        </div>
                        <div class="col" name="broj_ukupnih_placanja"></div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Sadašnja vrijednost na prvi dan:
                        </div>
                        <div class="col" name="sadasnja_vrijednost"></div>
                    </div>
                    <div class="row">
                        <div class="col">
                                Šifra mjesta troška:
                        </div>
                        <div class="col">{{$ugovori->sifra_troska}}</div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Šifra dobavljača:
                        </div>
                        <div class="col">{{$ugovori->sifra_dobavljaca}}</div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header title">
                    <h2 class="title" name="otplatni_plan_title">Otplatni plan ugovora br. </h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 bg-transparent">
                            <table id="ugovori" class="table table-striped table-bordered no-wrap bg-white" style="border-collapse: collapse; font-size: 0.9rem">
                                <thead>
                                <tr>
                                    <th>R.Br.</th>
                                    <th>Datum plaćanja</th>
                                    <th hidden>Mjesečni iznos najma</th>
                                    <th>Mjesečni iznos najma</th>
                                    <th hidden>Kamata</th>
                                    <th>Kamata</th>
                                    <th hidden>Otplata</th>
                                    <th>Otplata</th>
                                    <th hidden>Ostatak duga</th>
                                    <th>Ostatak duga</th>
                                    <th hidden>Amortizacija</th>
                                    <th>Amortizacija</th>
                                    <th hidden>Ukupni trošak</th>
                                    <th>Ukupni trošak</th>
                                    <th hidden>Šifra mjesta troška</th>
                                    <th hidden>Šifra dobavljača</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white" id="otplatni_plan_tabela">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            otplatniPlan()
            });

        function monthDiff(d1, d2) {
            var months;
            months = (d2.getFullYear() - d1.getFullYear()) * 12;
            months -= d1.getMonth() + 1;
            months += d2.getMonth();
            return months <= 0 ? 0 : months;
        }
        function endOfMonth(date, i)
        {
            var mjeseci = ["Januar", "Februar", "Mart", "April", "Maj", "Juni", "Juli", "August", "Septembar", "Oktobar", "Novembar", "Decembar"];
            var datum = new Date(date.getFullYear(), date.getMonth() + i + 1, 0);
            //var lastDayOfMonth = new Date(datum.getFullYear(), datum.getMonth() + 1, 1);
            return (datum.getDate() + '.' + (datum.getMonth()+1) + '.' + datum.getFullYear() );
        }

        function formatMoney(amount, currency = "KM", decimalCount = 2, decimal = ",", thousands = ".") {
            try {
                decimalCount = Math.abs(decimalCount);
                decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

                const negativeSign = amount < 0 ? "-" : "";

                let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
                let j = (i.length > 3) ? i.length % 3 : 0;

                return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "") + currency;
            } catch (e) {
                console.log(e)
            }
        }

        function otplatniPlan() {

            // placanje na pocetku i jednakih najamnina
            // samo se mijenja sadasnja vrijednost
            // sadasnja = iznos_naknade * (  (r * (r na n - 1) ) / ( r na n  * (r - 1)  ) )
            document.getElementsByName('otplatni_plan_title')[0].innerHTML += document.getElementsByName('broj_ugovora')[0].value;
            document.getElementsByName('godisnja_kamatna_stopa_opis')[0].innerHTML = document.getElementsByName('godisnja_kamatna_stopa')[0].value;
            document.getElementsByName('broj_godina')[0].innerHTML =  Math.floor(parseFloat(document.getElementsByName('trajanje_ugovora')[0].value)/parseFloat(12));
            document.getElementsByName('mjesecna_stopa')[0].innerHTML = parseFloat(document.getElementsByName('mjesecna_diskontna_stopa')[0].value);
            document.getElementsByName('broj_ukupnih_placanja')[0].innerHTML = parseFloat(document.getElementsByName('trajanje_ugovora')[0].value);


            var g = parseFloat(document.getElementsByName('mjesecna_diskontna_stopa')[0].value);
            var iznosNaknade = parseFloat( $('#iznos_naknade_0')[0].value);
            var trajanje_ugovora = parseFloat(document.getElementsByName('trajanje_ugovora')[0].value);
            var malo_r = parseFloat(1) + ( parseFloat(g) / parseFloat(100));

            //console.log(g + '::' + n + "::" + iznosNaknade + "::" + trajanje_ugovora + "::" + malo_r);
            // placanje na kraju perioda  i jednakih najamnina
            // p = 100 * ( m ti korijen iz (1 + p/100) - 1 )
            // p - godisnja stopa
            // m = 12

            var rnan = math.pow(parseFloat(malo_r), parseFloat(trajanje_ugovora) );
            var rnanminus1 = math.pow(parseFloat(malo_r), parseFloat(trajanje_ugovora) - parseFloat(1) );

            var sadasnja = 0;

            if ($('#moment_placanja')[0].value == 'na kraju perioda') {
                sadasnja = parseFloat(iznosNaknade) * ( (parseFloat(rnan) - parseFloat(1)) / (parseFloat(rnan) * ( parseFloat(malo_r) - 1 ))  );
            }
            else {
                sadasnja = parseFloat(iznosNaknade) + ( parseFloat(iznosNaknade) * ( (parseFloat(rnanminus1) - parseFloat(1)) / (parseFloat(rnanminus1) * ( parseFloat(malo_r) - 1 ))  ) );
            }

            var inicijalnaSadasnja = sadasnja;
            //INFO TEXT
            document.getElementsByName('sadasnja_vrijednost')[0].innerHTML = formatMoney(inicijalnaSadasnja);
            var mjesec = document.getElementById('pocetak_koristenja_imovine').value;

            var unaprijed_placeni_iznos = parseFloat( $('#unaprijed_placeni_iznos')[0].value);
            var pocetni_direktni_troskovi = parseFloat( $('#pocetni_direktni_troskovi')[0].value);
            var troskovi_demontaze = parseFloat( $('#troskovi_demontaze')[0].value);


            var sumaMjesecnog = 0;
            var sumaKamate = 0;
            var sumaAmortizacije = 0;
            var sumaUkupnogTroska = 0;
            for (var i = 0 ; i < trajanje_ugovora; i++) {

                var kamata1 = 0;
                if ($('#moment_placanja')[0].value == 'na kraju perioda') {
                    kamata1 = (sadasnja * (g / parseFloat(100)));
                }
                else {
                    if (i == 0) kamata1 = 0;
                    else kamata1 = (sadasnja * (g / parseFloat(100)));
                }
                var otplata1 = (iznosNaknade - kamata1);
                var ostatakDuga1 = (sadasnja - otplata1);
                var amortizacija1 = ((parseFloat(inicijalnaSadasnja) + parseFloat(unaprijed_placeni_iznos) + parseFloat(pocetni_direktni_troskovi) + parseFloat(troskovi_demontaze) )/ parseFloat(trajanje_ugovora));
                var ukupni_trosak1 = (parseFloat(kamata1) + parseFloat(amortizacija1));

                sumaMjesecnog += iznosNaknade;
                sumaKamate += kamata1;
                sumaAmortizacije += amortizacija1;
                sumaUkupnogTroska += ukupni_trosak1;

                sadasnja =  ostatakDuga1;
            }
            document.getElementById('otplatna_tabela').style.visibility = 'visible';
            sadasnja = inicijalnaSadasnja;

            document.getElementById('otplatni_plan_tabela').innerHTML = '';
            document.getElementById('otplatni_plan_tabela').innerHTML += "<tr class=\"bg-white\">\n" +
                "                        <td></td>\n" +
                "                        <td></td>\n" +
                "                        <td hidden>"+ formatMoney(sumaMjesecnog, "") +"</td>\n" +
                "                        <td>"+ formatMoney(sumaMjesecnog) +"</td>\n" +
                "                        <td hidden>"+ formatMoney(sumaKamate, "") +"</td>\n" +
                "                        <td>"+ formatMoney(sumaKamate) +"</td>\n" +
                "                        <td hidden></td>\n" +
                "                        <td></td>\n" +
                "                        <td hidden>"+ formatMoney(sadasnja, "") + "</td>\n" +
                "                        <td>"+ formatMoney(sadasnja) + "</td>\n" +
                "                        <td hidden>"+ formatMoney(sumaAmortizacije, "") +"</td>\n" +
                "                        <td>"+ formatMoney(sumaAmortizacije) +"</td>\n" +
                "                        <td hidden>"+ formatMoney(sumaUkupnogTroska, "") +"</td>\n" +
                "                        <td>"+ formatMoney(sumaUkupnogTroska) +"</td>\n" +
                "                        <td hidden></td>\n" +
                "                        <td hidden></td>\n" +
                "                    </tr>" +
                "<tr>" +
                "                        <td></td>\n" +
                "                        <td></td>\n" +
                "                        <td hidden></td>\n" +
                "                        <td></td>\n" +
                "                        <td hidden></td>\n" +
                "                        <td></td>\n" +
                "                        <td hidden></td>\n" +
                "                        <td></td>\n" +
                "                        <td hidden></td>\n" +
                "                        <td></td>\n" +
                "                        <td hidden></td>\n" +
                "                        <td></td>\n" +
                "                        <td hidden></td>\n" +
                "                        <td></td>\n" +
                "                        <td hidden></td>\n" +
                "                        <td hidden></td>\n" +
                "</tr>";

            for (var i = 0 ; i < trajanje_ugovora; i++) {
                var kamata = 0;
                if ($('#moment_placanja')[0].value == 'na kraju perioda') {
                    kamata = (sadasnja * (g / parseFloat(100)));
                }
                else {
                    if (i == 0) kamata = 0;
                    else kamata = (sadasnja * (g / parseFloat(100)));
                }
                var otplata = (iznosNaknade - kamata);
                var ostatakDuga = (sadasnja - otplata);
                var amortizacija = ((parseFloat(inicijalnaSadasnja) + parseFloat(unaprijed_placeni_iznos) + parseFloat(pocetni_direktni_troskovi) + parseFloat(troskovi_demontaze) )/ parseFloat(trajanje_ugovora));
                var ukupni_trosak = (parseFloat(kamata) + parseFloat(amortizacija));
                sadasnja =  ostatakDuga;
                document.getElementById('otplatni_plan_tabela').innerHTML += "<tr class=\"bg-white\">\n" +
                    "                        <td> " + parseInt(i+1) + "</td>\n" +
                    "                        <td> " + endOfMonth(new Date(mjesec), i) +"</td>\n" +
                    "                        <td hidden>" + iznosNaknade.toFixed(2) + "</td>\n" +
                    "                        <td>" + formatMoney(iznosNaknade) + "</td>\n" +
                    "                        <td hidden>" + kamata.toFixed(2) + "</td>\n" +
                    "                        <td>" + formatMoney(kamata) + "</td>\n" +
                    "                        <td hidden>" + otplata.toFixed(2) + "</td>\n" +
                    "                        <td>" + formatMoney(otplata) + "</td>\n" +
                    "                        <td hidden>"+ ostatakDuga.toFixed(2) + "</td>\n" +
                    "                        <td>"+ formatMoney(ostatakDuga) + "</td>\n" +
                    "                        <td hidden>"+ amortizacija.toFixed(2) + "</td>\n" +
                    "                        <td>"+ formatMoney(amortizacija) + "</td>\n" +
                    "                        <td hidden>"+ ukupni_trosak.toFixed(2) + "</td>\n" +
                    "                        <td>"+ formatMoney(ukupni_trosak) + "</td>\n" +
                    "                        <td hidden>{{$ugovori->sifra_troska}}</td>\n" +
                    "                        <td hidden>{{$ugovori->sifra_dobavljaca}}</td>\n" +
                    "                    </tr>";
            }
            document.getElementById('otplatna_tabela').style.visibility = 'visible';
        }


        $( function() {
            $( "#pocetak_koristenja_imovine" ).datepicker({
                dateFormat : 'yy/mm/dd',
                changeMonth: true,
                changeYear: true,
                onSelect: function() {
                    if ($('#pocetak_koristenja_imovine')[0].value != '' && $('#istek_ugovora')[0].value != '') {
                        var diff = monthDiff(new Date($('#pocetak_koristenja')[0].value), new Date($('#istek_ugovora')[0].value));
                        document.getElementsByName('neoopozivi_period')[0].value = diff + 1;
                        document.getElementsByName('neoopozivi_period_prikaz')[0].value = diff+1;
                        trajanjeUgovoraVrijednost();
                    }
                }
            });
        } );
        $( function() {
            $( "#istek_ugovora" ).datepicker({
                dateFormat : 'yy/mm/dd',
                changeMonth: true,
                changeYear: true,
                onSelect: function(t) {
                    if ($('#pocetak_koristenja_imovine')[0].value != '' && $('#istek_ugovora')[0].value != '') {
                        var diff = monthDiff(new Date($('#pocetak_koristenja_imovine')[0].value), new Date($('#istek_ugovora')[0].value));
                        document.getElementsByName('neoopozivi_period')[0].value = diff + 1;
                        document.getElementsByName('neoopozivi_period_prikaz')[0].value = diff+1;
                        trajanjeUgovoraVrijednost();
                    }
                }
            });
        } );

        function trajanjeUgovoraVrijednost() {
            if (document.getElementsByName('neoopozivi_period')[0].value != '' && $('#trajanje_otkaznog_roka')[0].value != '' && $('#produzenje')[0].value != '') {
                document.getElementsByName('trajanje_ugovora')[0].value = parseInt(document.getElementsByName('neoopozivi_period')[0].value) + parseInt($('#trajanje_otkaznog_roka')[0].value) + parseInt($('#produzenje')[0].value);
                document.getElementsByName('trajanje_ugovora_prikaz')[0].value = parseInt(document.getElementsByName('neoopozivi_period')[0].value) + parseInt($('#trajanje_otkaznog_roka')[0].value) + parseInt($('#produzenje')[0].value);
            }
        }

        function mjesecnaDiskontnaStopa() {
            var godisnja_kamatna = parseFloat($('#godisnja_kamatna_stopa')[0].value);
            var godisnja_podijeljena = godisnja_kamatna/parseFloat(100);

            // fiksne najamnine =  100 * ( 1 - 12 ti korijen ( 1 - godisnja_kamatna/100 ) )
            var oduzeeta_godisnja = parseFloat(1) - godisnja_podijeljena;
            var root_value = math.nthRoot(oduzeeta_godisnja, 12);
            var oduzeti_korijen = parseFloat(1) - root_value;
            var mjesecna = parseFloat(100) * oduzeti_korijen;

            // varijabilne najamnine = 100 * 12 ti korijen ( 1 + p/100 - 1 )
            var zagrada_godisnja = parseFloat(1) + godisnja_podijeljena;
            var root_value_varijabilna = math.nthRoot(zagrada_godisnja, 12);
            var mjesecna_varijabilna = parseFloat(100) * ( root_value_varijabilna - parseFloat(1) );

            document.getElementsByName('mjesecna_diskontna_stopa')[0].value = mjesecna_varijabilna;
            document.getElementsByName('mjesecna_diskontna_stopa_prikaz')[0].value = mjesecna_varijabilna;
        }

        function trajanjeUgovora() {
            if(document.getElementsByName('opcija_trajanja_ugovora')[0].value == "Do jedne godine bez ugovorene opcije produženja")
            {
                document.getElementById('izuzece').style.visibility = "visible";
                document.getElementById('izuzece').style.height = "auto";
            } else {
                document.getElementById('izuzece').style.visibility = "hidden";
                document.getElementById('izuzece').style.height = "0px";
            }
        }

        function imovinaMaleVrijednosti() {
            if(document.getElementsByName('predmet_ugovora')[0].value == "DA")
            {
                document.getElementById('izuzece2').style.visibility = "visible";
                document.getElementById('izuzece2').style.height = "auto";
            } else {
                document.getElementById('izuzece2').style.visibility = "hidden";
                document.getElementById('izuzece2').style.height = "0px";
            }
        }

        function iznosiNaknade() {
            var divIznosa = document.getElementById('naknade_redovi');
            divIznosa.innerHTML = '';
            console.log(divIznosa);
            var iznosi = 0;
            if (document.getElementsByName('vrsta_placanja')[0].value == "fiksne najamnine") {
                divIznosa.innerHTML += '<div class="col-12">\n' +
                    '                                        <div class="input-group-prepend">\n' +
                    '                                            <span class="bg-transparent" for="iznos_naknade_0">Iznos naknade:</span>\n' +
                    '                                        </div>\n' +
                    '                                        <input type="text" class="form-control" id="iznos_naknade_0" name="iznos_naknade_0" autocomplete="off">\n' +
                    '                                    </div>\n';
            }else {
                iznosi = parseInt(document.getElementsByName('neoopozivi_period')[0].value);

                for (i = 0; i< iznosi ; i++) {
                    divIznosa.innerHTML += '<div class="col-12 mt-2">\n' +
                        '                                        <div class="input-group-prepend">\n' +
                        '                                            <span class="bg-transparent" for="iznos_naknade_' + i + '">Iznos naknade za '+ (i+1) +' mjesec:</span>\n' +
                        '                                        </div>\n' +
                        '                                        <input type="text" class="form-control" id="iznos_naknade_' + i + '" name="iznos_naknade_' + i + '" autocomplete="off">\n' +
                        '                                    </div>\n';
                }
            }

        }

        var table = $(document).ready(function() {
            $('#ugovori').DataTable( {
                dom: 'Bfrtip',
                paging: false,
                "searching": false,
                "ordering": false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: document.getElementsByName('otplatni_plan_title')[0].innerText,
                        exportOptions: {
                            columns: [ 0,1,2,4,6,8,10,12,14,15 ]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        title: document.getElementsByName('otplatni_plan_title')[0].innerText,
                        exportOptions: {
                            columns: [ 0,1,2,4,6,8,10,12,14,15 ]
                        }
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
