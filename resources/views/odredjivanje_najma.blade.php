@extends('layouts.app')
@section('content')
    <div class="container-fluid w-75">
        <div class="row justify-content-center">
            <div class="col-12">
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

                <div class="card mt-3">
                    <div class="card-header title">
                        Određivanje postojanja najma
                    </div>
                    <div class="card-body">
                        <div class="row ml-2 mr-2">
                            <div class="input-group mb-3 col-10 w-100">
                                <div class="input-group-prepend w-100">
                                    <span class="input-group-text w-100" style="background-color: white" id="basic-addon1">Da li postoji određena imovina?</span>
                                </div>
                            </div>
                            <div class="col-2">
                                <select class="selectpicker form-control" name="imovina">
                                    <option>DA</option>
                                    <option>NE</option>
                                </select>
                            </div>
                        </div>
                        <div class="row ml-2 mr-2">
                            <div class="input-group mb-3 col-10 w-100 bgWhite">
                                <div class="input-group-prepend w-100">
                                    <span class="input-group-text w-100" style="background-color: white" id="basic-addon1">Da li kupac ima pravo sticati suštinski sve ekonomske koristi od korištenja imovine tokom cijelog perioda korištenja?</span>
                                </div>
                            </div>
                            <div class="col-2">
                                <select class="selectpicker form-control" onchange="" name="kupac">
                                    <option>DA</option>
                                    <option>NE</option>
                                </select>
                            </div>
                        </div>
                        <div class="row ml-2 mr-2">
                            <div class="input-group mb-3 col-10 w-100">
                                <div class="input-group-prepend w-100">
                                    <span class="input-group-text w-100" style="background-color: white" id="basic-addon1">Ko ima pravo određivanja načina i svrhe korištenja imovine tokom cijelog perioda korištenja?</span>
                                </div>
                            </div>
                            <div class="col-2">
                                <select class="selectpicker form-control" onchange="" name="odredjivanje">
                                    <option>Kupac</option>
                                    <option>Dobavljač</option>
                                    <option>Nijedna od strana</option>
                                </select>
                            </div>
                        </div>
                        <div class="row ml-2 mr-2">
                            <div class="input-group mb-3 col-10 w-100">
                                <div class="input-group-prepend w-100">
                                    <span class="input-group-text w-100" style="background-color: white" id="basic-addon1">Da li kupac ima pravo upravljati sredstvom tokom cijelog perioda korištenja, s tim da dobavljač nema pravo mijenjati upustva o upravljanju?</span>
                                </div>
                            </div>
                            <div class="col-2">
                                <select class="selectpicker form-control" onchange="" name="upravljati">
                                    <option>DA</option>
                                    <option>NE</option>
                                </select>
                            </div>
                        </div>
                        <div class="row ml-2 mr-2">
                            <div class="input-group mb-3 col-10 w-100">
                                <div class="input-group-prepend w-100">
                                    <span class="input-group-text w-100" style="background-color: white" id="basic-addon1">Da li je kupac imovinu dizajnirao tako da su način i svrha njenog korištenja tokom cijelog perioda korištenja unaprijed određeni?</span>
                                </div>
                            </div>
                            <div class="col-2">
                                <select class="selectpicker form-control" onchange="" name="dizajnirao">
                                    <option>DA</option>
                                    <option>NE</option>
                                </select>
                            </div>
                        </div>
                        <div class="row ml-2 mr-2">
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="form-group col m-0 p-0">
                                <button type="submit" class="btn buttonOutline btn-lg fontVariant w-100" onclick="odredi()">Odredi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="dialog" title="Basic dialog" style="visibility: hidden;">
        This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">

        function odredi() {
            var imovina = (document.getElementsByName('imovina')[0]);
            var imovina = imovina.options[imovina.selectedIndex].value;

            var kupac = (document.getElementsByName('kupac')[0]);
            var kupac = kupac.options[kupac.selectedIndex].value;

            var odredjivanje = (document.getElementsByName('odredjivanje')[0]);
            var odredjivanje = odredjivanje.options[odredjivanje.selectedIndex].value;

            var upravljati = (document.getElementsByName('upravljati')[0]);
            var upravljati = upravljati.options[upravljati.selectedIndex].value;

            var dizajnirao = (document.getElementsByName('dizajnirao')[0]);
            var dizajnirao = dizajnirao.options[dizajnirao.selectedIndex].value;


            if (imovina == "NE") {
                alert ("Ne postoji najam!");
            }
            else {

                if (kupac == "NE") alert ("Ne postoji najam!");
                else {

                    if (odredjivanje == "Dobavljač") alert ("Ne postoji najam!");
                    else if (odredjivanje == "Kupac") alert ("Postoji najam!");
                    else {

                        if (upravljati == "DA") alert ("Postoji najam!");
                        else {

                            if (dizajnirao == "NE") alert ("Ne postoji najam!");
                            else alert ("Postoji najam!");
                        }
                    }
                }
            }
        }
    </script>
@endpush
