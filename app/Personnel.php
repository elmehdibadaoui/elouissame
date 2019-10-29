<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Personnel extends Model
{
    public function getLastPaiment(){
		$paiement = \App\Paiement::where('user_id', $this->id)->orderBy('date', 'desc')->first();
		if($paiement)
			return $paiement->date ? \Carbon\Carbon::parse($paiement->date)->format('d/m/Y') : "-";
		else
			return "Aucun Paiement";
	}
}
