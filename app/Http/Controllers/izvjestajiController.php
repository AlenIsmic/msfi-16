<?php

namespace App\Http\Controllers;

use App\IznoseNaknade;
use App\Ugovor;
use App\VrsteImovine;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use function MongoDB\BSON\toJSON;

class izvjestajiController extends Controller
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
        $ugovori = Ugovor::all();
        $mjesta_troska = array();
        for ($i = 0; $i<sizeof($ugovori); $i++) {
            array_push($mjesta_troska, $ugovori[$i]->mjesto_troska);
        }
        $mjesta_troska = array_unique($mjesta_troska);
        return view('/izvjestaji/izvjestaj_biljeske')
            ->with('ugovori', $ugovori)
            ->with('vrste_imovine', $vrsteImovine)
            ->with('mjesta_troska', $mjesta_troska);
    }

    public function izvjestaji(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'period_od' => 'required',
            'period_do' => 'required'
        ],
            [
                'period_od.required' => 'Unesite period ispravno.',
                'period_do.required' => 'Unesite period ispravno.'
            ]);

        if ($validator->fails()) {
            return redirect('/izvjestaj_biljeske')
                ->withErrors($validator)
                ->withInput();
        }
        $vrste_imovine = array();
        $broj_imovina = VrsteImovine::all();
        $sadasnjaZaIzvjestaj = 0;
        $tipIzvjestaja = $request->get('mjesecni');

        $loop = 0;
        for ($i = 0; $i < sizeof($broj_imovina); $i++) {
            if ($request->get($broj_imovina[$i]->id) !== null) {
                $vrste_imovine[$loop]["id"] = $request->get($broj_imovina[$i]->id);
                $vrste_imovine[$loop++]["naziv"] = VrsteImovine::whereId($request->get($broj_imovina[$i]->id))->first()->naziv;
            }
        }
        $period_od = Carbon::createFromFormat('Y/m/d', $request->get('period_od'));
        $period_do = Carbon::createFromFormat('Y/m/d', $request->get('period_do'));
        $datumi = [];
        $knj_na_pocetku = [];
        $knj_na_kraju = [];
        $iznos_glavnice = [];
        $iznos_kamate = [];
        $iznos_ugovorene_najamnine = [];
        $iznos_nominalne_vrijednosti = [];
        $iznos_ostatka_duga = [];
        $amort = [];
        $ugovorPocetna = [];
        $ugovorBroj = [];

        $inicijalni = Carbon::createFromFormat('Y/m/d', $request->get('period_od'));
        $krajni = Carbon::createFromFormat('Y/m/d', $request->get('period_do'));

        while ($inicijalni <= $krajni) {
            $privremeni = Carbon::createFromFormat('Y/m/d', $inicijalni->format('Y/m/d'));
            $privremeni = $privremeni->format('Y/m/d');
            array_push($datumi, $privremeni);
            $inicijalni->addMonth(1);
        }
        for ($i = 0; $i<sizeof($datumi); $i++) {
            $knj_na_pocetku[$datumi[$i]] = 0;
            $amort[$datumi[$i]] = 0;
            $knj_na_kraju[$datumi[$i]] = 0;
            $iznos_glavnice[$datumi[$i]] = 0;
            $iznos_kamate[$datumi[$i]] = 0;
            $iznos_ugovorene_najamnine[$datumi[$i]] = 0;
            $iznos_nominalne_vrijednosti[$datumi[$i]] = 0;
            $iznos_ostatka_duga[$datumi[$i]] = 0;
        }

        $sifra_troska = $request->get('sifra_troska');

        $ugovori = Ugovor::all();
        $mjesta_troska = array();
        if ($request->get('mjesto_troska')!= null) {
            array_push($mjesta_troska, $request->get('mjesto_troska'));
        }
        else {
            for ($i = 0; $i < sizeof($ugovori); $i++) {
                array_push($mjesta_troska, $ugovori[$i]->mjesto_troska);
            }
        }
        $mjesta_troska = array_unique($mjesta_troska);


        if (sizeof($vrste_imovine) == 0) {
            for ($i = 0; $i < sizeof($broj_imovina); $i++) {
                $vrste_imovine[$loop]["id"] = $broj_imovina[$i]->id;
                $vrste_imovine[$loop++]["naziv"] = VrsteImovine::whereId($broj_imovina[$i]->id)->first()->naziv;
            }
        }
        for($j=0; $j < sizeof($vrste_imovine); $j++) {
            $ugovori = Ugovor::whereVrstaImovineId($vrste_imovine[$j]["id"])->orderBy('id', 'DESC')->get();
            foreach ($ugovori as $ugovor) {
                $pocetak_ugovora = Carbon::createFromFormat('Y-m-d',$ugovor->pocetak_koristenja_imovine);
                if ($pocetak_ugovora < $period_od) continue;
                $mjesto_ispravno = false;
                foreach ($mjesta_troska as $mjesto_troska){
                    if ($ugovor->mjesto_troska === $mjesto_troska) $mjesto_ispravno = true;
                    if ($mjesto_ispravno) break;
                }
                if (!$mjesto_ispravno) continue;
                if ($sifra_troska != '' && $ugovor->sifra_troska != $sifra_troska) continue;
                $g = $ugovor->mjesecna_diskontna_stopa;
                $iznos_naknade = IznoseNaknade::whereUgovorId($ugovor->id)->first();
                if ($iznos_naknade == null) continue;
                else $iznos_naknade = $iznos_naknade->iznos_nakande;
                $trajanje_ugovora = $ugovor->trajanje_ugovora;
                $malo_r = 1 + ( $g / 100);
                $rnan = pow($malo_r, $trajanje_ugovora );
                $rnanminus1 = pow($malo_r, ($trajanje_ugovora - 1 ));
                if ($ugovor->moment_placanja == 'na kraju perioda') $sadasnja = $iznos_naknade * ( ($rnan - 1) / ($rnan * ( $malo_r - 1 ))  );
                else $sadasnja = $iznos_naknade + ( $iznos_naknade * ( ($rnanminus1 - 1) / ($rnanminus1 * ( $malo_r - 1 ))  ) );

                $DatumZaIzvjestaj = Carbon::createFromFormat('Y/m/d', $pocetak_ugovora->format('Y/m/01'));
                $sadasnjaZaIzvjestaj += $sadasnja;
                $sadasnjaZaAmort = $sadasnja;
                $iznos_nominalne_vrijednosti[$DatumZaIzvjestaj->format('Y/m/01')] += $iznos_naknade * $trajanje_ugovora;
                $amortizacija = (($sadasnja + $ugovor->unaprijed_placeni_iznos + $ugovor->pocetni_direktni_troskovi + $ugovor->troskovi_demontaze)/ $trajanje_ugovora);
                array_push($ugovorPocetna, $sadasnja);
                array_push($ugovorBroj, $ugovor->broj_ugovora);
                for ($i = 0; $i < $trajanje_ugovora; $i++) {
                    $DatumZaIzvjestaj = Carbon::createFromFormat('Y/m/d', $pocetak_ugovora->format('Y/m/01'));
                    $DatumZaIzvjestaj->addMonth($i);
                    if ($ugovor->moment_placanja == 'na kraju perioda') $kamata = ($sadasnja * ($g / 100));
                    else {
                        if ($i == 0) $kamata = 0;
                        else $kamata = ($sadasnja * ($g / 100));
                    }
                    $otplata = ($iznos_naknade - $kamata);
                    $ostatakDuga = ($sadasnja - $otplata);
                    $amortizacija = (($sadasnja + $ugovor->unaprijed_placeni_iznos + $ugovor->pocetni_direktni_troskovi + $ugovor->troskovi_demontaze)/ $trajanje_ugovora);
                    $amortZaIzvjestaj = (($sadasnjaZaAmort + $ugovor->unaprijed_placeni_iznos + $ugovor->pocetni_direktni_troskovi + $ugovor->troskovi_demontaze)/ $trajanje_ugovora);

                    if (isset($amort[$DatumZaIzvjestaj->format('Y/m/01')])) {
                        $amort[$DatumZaIzvjestaj->format('Y/m/01')] += $amortZaIzvjestaj;
                        $iznos_ostatka_duga[$DatumZaIzvjestaj->format('Y/m/01')] += $ostatakDuga;
                        $iznos_kamate[$DatumZaIzvjestaj->format('Y/m/01')] += $kamata;
                        $iznos_ugovorene_najamnine[$DatumZaIzvjestaj->format('Y/m/01')] += $iznos_naknade;
                        $iznos_glavnice[$DatumZaIzvjestaj->format('Y/m/01')] += $otplata;
                    }

                    if ($DatumZaIzvjestaj >= $period_do) break;

                    $sadasnja = $ostatakDuga;
                    $knj_na_pocetku[$DatumZaIzvjestaj->format('Y/m/01')] = $sadasnjaZaIzvjestaj - ($amort[$DatumZaIzvjestaj->format('Y/m/01')] * $i);
                    $knj_na_kraju[$DatumZaIzvjestaj->format('Y/m/01')] = $knj_na_pocetku[$DatumZaIzvjestaj->format('Y/m/01')] - $amort[$DatumZaIzvjestaj->format('Y/m/01')];
                }
            }
        }

        return view('/izvjestaji/biljeske')
            ->with('vrste_imovine', $vrste_imovine)
            ->with('mjesta_troska', $mjesta_troska)
            ->with('datumi', $datumi)
            ->with('knj_na_pocetku', $knj_na_pocetku)
            ->with('knj_na_kraju', $knj_na_kraju)
            ->with('amort', $amort)
            ->with('ostatak_duga', $iznos_ostatka_duga)
            ->with('kamata', $iznos_kamate)
            ->with('iznos_naknade', $iznos_ugovorene_najamnine)
            ->with('iznos_glavnice', $iznos_glavnice)
            ->with('iznos_nominalne', $iznos_nominalne_vrijednosti)
            ->with('tipIzvjestaja', $tipIzvjestaja)
            ->with('ugovorbroj', $ugovorBroj)
            ->with('ugovorpocetna', $ugovorPocetna)
            ->with('sadasnjaZaIzvjestaj', $sadasnjaZaIzvjestaj);
    }
}
