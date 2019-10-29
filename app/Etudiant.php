<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Etudiant extends Model
{
	
	protected static function boot()
	{
		parent::boot();
		
		// To set default session
		Etudiant::creating(function ($etudiant) {
			$etudiant->session = setting('site.session');
        });
		Etudiant::created(function ($etudiant) {
			for($i=0 ; $i<request()->nbr_mois ; $i++){				
				$paiement        		= new \App\Paiement();
				$paiement->total		= $etudiant->getPaimentPrix() + ( $i==0 ? intval($etudiant->prix_inscription) : 0 );
				$paiement->type  		= 1;
				$paiement->is_etudiant  = 1;
				$paiement->user_id  	= $etudiant->id;
				$paiement->statu 		= 1;
				$paiement->method  		= 1;
				$paiement->date  		= \Carbon\Carbon::now()->addMonth($i);
				$paiement->save();
			}
        });

		// Apply session for all retrieved data
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->where('session', setting('site.session'));
		});
	}
	public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
	public function getLastPaiment(){
		$paiement = \App\Paiement::where('user_id', $this->id)->orderBy('date', 'desc')->first();
		return $paiement ? $paiement : null;
	}
	public function getPaimentPrix(){
		return (floatval($this->prix_mensuel) + floatval($this->prix_transport) + floatval($this->prix_fourniture) + floatval($this->prix_sport));

	}
}
