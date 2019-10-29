<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Voyager;
use App\Paiement;
class PaiementController extends Controller
{
    public function paiementsPersonnelBrowse(Request $request){
        $dataType = Voyager::model('DataType')->where('slug', '=', 'paiements')->first();
		
		$paiements = Paiement::where('is_etudiant', 0)->get();
		
		return view('vendor.voyager.paiements.paiementsPersonnelBrowse', compact('dataType', 'paiements'));        
	}
    public function paiementsPersonnelCreate(Request $request){
        $dataType = Voyager::model('DataType')->where('slug', '=', 'paiements')->first();
		$dataTypeContent = (strlen($dataType->model_name) != 0)
                            ? new $dataType->model_name()
                            : false;
		return view('vendor.voyager.paiements.paiementsPersonnelEditAdd', compact('dataType', 'dataTypeContent'));
	}
	public function paiementsPersonnelEdit(Request $request, $id){
        $dataType = Voyager::model('DataType')->where('slug', '=', 'paiements')->first();
		$dataTypeContent = (strlen($dataType->model_name) != 0)
            ? app($dataType->model_name)->findOrFail($id)
            : DB::table($dataType->name)->where('id', $id)->first(); // If Model doest exist, get data from table name
		return view('vendor.voyager.paiements.paiementsPersonnelEditAdd', compact('dataType', 'dataTypeContent'));
	}
	public function paiementsEtudiantBrowse(Request $request){
        $dataType = Voyager::model('DataType')->where('slug', '=', 'paiements')->first();
		
		$paiements = Paiement::where('is_etudiant', 1)->get();
		
		return view('vendor.voyager.paiements.paiementsEtudiantBrowse', compact('dataType', 'paiements'));        
	}
    public function paiementsEtudiantCreate(Request $request){
        $dataType = Voyager::model('DataType')->where('slug', '=', 'paiements')->first();
		$dataTypeContent = (strlen($dataType->model_name) != 0)
                            ? new $dataType->model_name()
                            : false;
		return view('vendor.voyager.paiements.paiementsEtudiantEditAdd', compact('dataType', 'dataTypeContent'));
	}
	public function paiementsEtudiantEdit(Request $request, $id){
        $dataType = Voyager::model('DataType')->where('slug', '=', 'paiements')->first();
		$dataTypeContent = (strlen($dataType->model_name) != 0)
            ? app($dataType->model_name)->findOrFail($id)
            : DB::table($dataType->name)->where('id', $id)->first(); // If Model doest exist, get data from table name
		return view('vendor.voyager.paiements.paiementsEtudiantEditAdd', compact('dataType', 'dataTypeContent'));
	}
}
