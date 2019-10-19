<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Ugovor
 *
 * @property int $id
 * @property string $broj_ugovora
 * @property string $broj_aneksa_ugovora
 * @property string $najmodavac
 * @property string $povezano_lice
 * @property string|null $lokacija
 * @property int $vrsta_imovine_id
 * @property string $opcija_trajanja_ugovora
 * @property string $izuzece
 * @property string $pocetak_koristenja_imovine
 * @property string $istek_ugovora
 * @property string $neoopozivi_period
 * @property string $trajanje_otkaznog_roka
 * @property string|null $produzenje
 * @property string|null $trajanje_ugovora
 * @property string $predmet_ugovora
 * @property string $izuzece2
 * @property string $moment_placanja
 * @property string $vrsta_placanja
 * @property float $unaprijed_placeni_iznos
 * @property float $pocetni_direktni_troskovi
 * @property float $troskovi_demontaze
 * @property float $godisnja_kamatna_stopa
 * @property float $mjesecna_diskontna_stopa
 * @property string|null $napomena
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereBrojAneksaUgovora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereBrojUgovora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereGodisnjaKamatnaStopa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereIstekUgovora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereIzuzece($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereIzuzece2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereLokacija($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereMjesecnaDiskontnaStopa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereMomentPlacanja($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereNajmodavac($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereNapomena($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereNeoopoziviPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereOpcijaTrajanjaUgovora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor wherePocetakKoristenjaImovine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor wherePocetniDirektniTroskovi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor wherePovezanoLice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor wherePredmetUgovora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereProduzenje($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereTrajanjeOtkaznogRoka($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereTrajanjeUgovora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereTroskoviDemontaze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereUnaprijedPlaceniIznos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereVrstaImovineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereVrstaPlacanja($value)
 * @mixin \Eloquent
 * @property string $mjesto_troska
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereMjestoTroska($value)
 * @property string $sifra_troska
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereSifraTroska($value)
 * @property string $sifra_dobavljaca
 * @property string $entitet
 * @property string $tip_dobavljaca
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereEntitet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereSifraDobavljaca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereTipDobavljaca($value)
 * @property bool $inaktivan
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereInaktivan($value)
 * @property string|null $datum_placanja
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereDatumPlacanja($value)
 * @property string|null $datum_inaktivnosti
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ugovor whereDatumInaktivnosti($value)
 */
class Ugovor extends Model
{
    //
}
