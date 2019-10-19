<?php

namespace App\Http\Controllers;

use App\IznoseNaknade;
use App\Ugovor;
use App\VrsteImovine;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ugovorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ugovori = Ugovor::all();
        $vrsteImovine = VrsteImovine::all();
        //$iznosiNaknade = IznosNakade::all();
        return view('ugovori.pregled')
            ->with('ugovori', $ugovori)
            ->with('vrste_imovine', $vrsteImovine);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vrste_imovine = VrsteImovine::all();
        return view('ugovori.kreiraj')->with('vrste_imovine', $vrste_imovine);
    }


    public function izracun(Request $request) {
        $ugovori = Ugovor::orderBy('id', 'DESC')->get();
        $sumaDugovanja = 0;
        $u = [];
        $d = [];
        $losUgovor = [];

        foreach ($ugovori as $ugovor) {
            $pocetak_ugovora = Carbon::createFromFormat('Y-m-d',$ugovor->pocetak_koristenja_imovine);
            if ($pocetak_ugovora < '2019-01-01') continue;
            $g = $ugovor->mjesecna_diskontna_stopa;
            $iznos_naknade = IznoseNaknade::whereUgovorId($ugovor->id)->first();
            if ($iznos_naknade == null) {
                array_push($losUgovor, $ugovor->id);
                continue;
            }
            else $iznos_naknade = $iznos_naknade->iznos_nakande;
            $trajanje_ugovora = $ugovor->trajanje_ugovora;
            $malo_r = 1 + ( $g / 100);
            $rnan = pow($malo_r, $trajanje_ugovora );
            $rnanminus1 = pow($malo_r, ($trajanje_ugovora - 1 ));
            $sadasnja = 0;
            if ($ugovor->moment_placanja == 'na kraju perioda') $sadasnja = $iznos_naknade * ( ($rnan - 1) / ($rnan * ( $malo_r - 1 ))  );
            else $sadasnja = $iznos_naknade + ( $iznos_naknade * ( ($rnanminus1 - 1) / ($rnanminus1 * ( $malo_r - 1 ))  ) );

            $trenutni_datum = $pocetak_ugovora;

            for ($i = 0; $i < $trajanje_ugovora; $i++) {
                $kamata = 0;
                if ($ugovor->moment_placanja == 'na kraju perioda') $kamata = ($sadasnja * ($g / 100));
                else {
                    if ($i == 0) $kamata = 0;
                    else $kamata = ($sadasnja * ($g / 100));
                }
                $otplata = ($iznos_naknade - $kamata);
                $ostatakDuga = ($sadasnja - $otplata);
                $amortizacija = (($sadasnja + $ugovor->unaprijed_placeni_iznos + $ugovor->pocetni_direktni_troskovi + $ugovor->troskovi_demontaze)/ $trajanje_ugovora);
                $ukupni_trosak = ($kamata + $amortizacija);
                array_push($d, $sadasnja);
                $sadasnja = $ostatakDuga;
                $trenutni_datum->addMonth();
                if ($trenutni_datum >= Carbon::create(2019,1,1,0)) {
                    $sumaDugovanja += $ostatakDuga;
                    array_push($u, $ugovor->broj_ugovora);
                    break;
                }
            }
        }
        return view('/izvjestaji/pregled_dugovanja', compact('sumaDugovanja', 'losUgovor', 'u', 'd'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'broj_ugovora' => 'required|max:100'
        ], [
            'broj_ugovora.required' => 'Unesite broj ugovora.',
        ]);

        if ($validator->fails()) {
            return redirect('ugovori/kreiraj')
                ->withErrors($validator)
                ->withInput();
        }

        $ugovor = new Ugovor();
        $ugovor->broj_ugovora = $request->get('broj_ugovora');
        $ugovor->broj_aneksa_ugovora = $request->get('broj_aneksa_ugovora');
        $ugovor->najmodavac = $request->get('najmodavac');
        $ugovor->povezano_lice = $request->get('povezano_lice');
        $ugovor->lokacija = $request->get('lokacija');
        $ugovor->opcija_trajanja_ugovora = $request->get('opcija_trajanja_ugovora');
        $ugovor->izuzece = $request->get('izuzece');
        $ugovor->pocetak_koristenja_imovine = $request->get('pocetak_koristenja_imovine');
        $ugovor->istek_ugovora = $request->get('istek_ugovora');
        $ugovor->neoopozivi_period = $request->get('neoopozivi_period');
        $ugovor->trajanje_otkaznog_roka = $request->get('trajanje_otkaznog_roka');
        $ugovor->produzenje = $request->get('produzenje');
        $ugovor->trajanje_ugovora = $request->get('trajanje_ugovora');
        $ugovor->predmet_ugovora = $request->get('predmet_ugovora');
        $ugovor->izuzece2 = $request->get('izuzece2');
        $ugovor->moment_placanja = $request->get('moment_placanja');
        $ugovor->vrsta_placanja = $request->get('vrsta_placanja');
        $ugovor->unaprijed_placeni_iznos = $request->get('unaprijed_placeni_iznos');
        $ugovor->pocetni_direktni_troskovi = $request->get('pocetni_direktni_troskovi');
        $ugovor->troskovi_demontaze = $request->get('troskovi_demontaze');
        $ugovor->godisnja_kamatna_stopa = $request->get('godisnja_kamatna_stopa');
        $ugovor->mjesecna_diskontna_stopa = $request->get('mjesecna_diskontna_stopa');
        $ugovor->napomena = $request->get('napomena');
        $ugovor->mjesto_troska = $request->get('mjesto_troska');
        $ugovor->sifra_troska = $request->get('sifra_troska');
        $ugovor->sifra_dobavljaca = $request->get('sifra_dobavljaca');
        $ugovor->entitet = $request->get('entitet');
        $ugovor->tip_dobavljaca = $request->get('tip_dobavljaca');
        $ugovor->inaktivan = false;

        $vrsta_imovine = VrsteImovine::firstOrFail()->where('naziv', $request->get('vrsta_imovine'))->first();

        $ugovor->vrsta_imovine_id = $vrsta_imovine->id;

        $iznos_naknade = new IznoseNaknade();
        $iznos_naknade->iznos_nakande = $request->get('iznos_naknade_0');
        $ugovor->save();
        $iznos_naknade->ugovor_id = $ugovor->id;
        $iznos_naknade->save();

        $request->session()->flash('alert-success', 'Ugovor je spašen!');
        return redirect("./");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ugovor = Ugovor::whereId($id)->first();
        $vrsteImovine = VrsteImovine::all();
        $iznosiNaknade = IznoseNaknade::whereUgovorId($ugovor->id)->first();
        return view('ugovori.pregled_ugovora')
            ->with('ugovori', $ugovor)
            ->with('vrste_imovine', $vrsteImovine)
            ->with('iznosi_naknade', $iznosiNaknade);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ugovor = Ugovor::whereId($id)->first();

        $vrsteImovine = VrsteImovine::all();
        $iznosiNaknade = IznoseNaknade::whereUgovorId($ugovor->id)->first();

        return view('ugovori.izmijeni')
            ->with('ugovori', $ugovor)
            ->with('vrste_imovine', $vrsteImovine)
            ->with('iznosi_naknade', $iznosiNaknade);
    }

    public function inaktivan(Request $request, $id)
    {
        $ugovor = Ugovor::whereId($id)->first();
        $ugovor->datum_inaktivnosti = $request->get('datum');
        $ugovor->inaktivan = true;
        $ugovor->save();

        $ugovori = Ugovor::all();
        return view('/ugovori/pregled')->with('ugovori', $ugovori);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ugovor = Ugovor::whereId($id)->first();
        $vrsteImovine = VrsteImovine::all();
        $iznosiNaknade = IznoseNaknade::whereUgovorId($ugovor->id)->first();

        $ugovor->broj_ugovora = $request->get('broj_ugovora');
        $ugovor->broj_aneksa_ugovora = $request->get('broj_aneksa_ugovora');
        $ugovor->najmodavac = $request->get('najmodavac');
        $ugovor->povezano_lice = $request->get('povezano_lice');
        $ugovor->lokacija = $request->get('lokacija');
        $ugovor->opcija_trajanja_ugovora = $request->get('opcija_trajanja_ugovora');
        $ugovor->izuzece = $request->get('izuzece');
        $ugovor->pocetak_koristenja_imovine = $request->get('pocetak_koristenja_imovine');
        $ugovor->istek_ugovora = $request->get('istek_ugovora');
        $ugovor->neoopozivi_period = $request->get('neoopozivi_period');
        $ugovor->trajanje_otkaznog_roka = $request->get('trajanje_otkaznog_roka');
        $ugovor->produzenje = $request->get('produzenje');
        $ugovor->trajanje_ugovora = $request->get('trajanje_ugovora');
        $ugovor->predmet_ugovora = $request->get('predmet_ugovora');
        $ugovor->izuzece2 = $request->get('izuzece2');
        $ugovor->moment_placanja = $request->get('moment_placanja');
        $ugovor->vrsta_placanja = $request->get('vrsta_placanja');
        $ugovor->unaprijed_placeni_iznos = $request->get('unaprijed_placeni_iznos');
        $ugovor->pocetni_direktni_troskovi = $request->get('pocetni_direktni_troskovi');
        $ugovor->troskovi_demontaze = $request->get('troskovi_demontaze');
        $ugovor->godisnja_kamatna_stopa = $request->get('godisnja_kamatna_stopa');
        $ugovor->mjesecna_diskontna_stopa = $request->get('mjesecna_diskontna_stopa');
        $ugovor->napomena = $request->get('napomena');
        $ugovor->mjesto_troska = $request->get('mjesto_troska');
        $ugovor->sifra_troska = $request->get('sifra_troska');
        $ugovor->sifra_dobavljaca = $request->get('sifra_dobavljaca');
        $ugovor->entitet = $request->get('entitet');
        $ugovor->tip_dobavljaca = $request->get('tip_dobavljaca');
        $ugovor->datum_placanja = $request->get('datum_placanja');

        $vrsta_imovine = VrsteImovine::firstOrFail()->where('naziv', $request->get('vrsta_imovine'))->first();
        $ugovor->vrsta_imovine_id = $vrsta_imovine->id;

        $iznos_naknade = new IznoseNaknade();
        $iznos_naknade->iznos_nakande = $request->get('iznos_naknade_0');
        $ugovor->save();
        $iznos_naknade->ugovor_id = $ugovor->id;
        $iznos_naknade->save();

        $request->session()->flash('alert-success', 'Ugovor je spašen!');

        $ugovori = Ugovor::all();
        return view('/ugovori/pregled')->with('ugovori', $ugovori);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $ugovor = Ugovor::whereId($id)->first();
        $ugovor->delete();
        $ugovori = Ugovor::all();
        return view('ugovori.pregled')
            ->with('ugovori', $ugovori);
    }
}
