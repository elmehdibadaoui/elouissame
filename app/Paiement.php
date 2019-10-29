<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Voyager;

class Paiement extends Model
{
    protected static function boot()
	{
		parent::boot();
		
		// To set default session
		Paiement::updated(function ($paiement) {
			if($paiement->is_etudiant){
				exit('<script>window.location = "'.url('admin/paiements-etudiant').'"; </script>');
			}else{				
				exit('<script>window.location = "'.url('admin/paiements-personnel').'"; </script>');
			}
        });
		
		Paiement::saved(function ($paiement) {
			if(!request()->from_paiement){				
				if($paiement->is_etudiant){
					exit('<script>window.location = "'.url('admin/paiements-etudiant').'"; </script>');
				}else{				
					exit('<script>window.location = "'.url('admin/paiements-personnel').'"; </script>');
				}
			}
        });
		
		// To set default session
		Paiement::creating(function ($paiement) {
			$paiement->user_by_id = \Auth::user()->id;
			$paiement->session = setting('site.session');
        });

		// Apply session for all retrieved data
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->where('session', setting('site.session'));
		});
	}
}
