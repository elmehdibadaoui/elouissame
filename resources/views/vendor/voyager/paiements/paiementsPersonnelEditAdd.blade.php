@extends('voyager::master')@section('css')    <meta name="csrf-token" content="{{ csrf_token() }}">@stop@section('page_title', __('voyager::generic.'.(!is_null($dataTypeContent->getKey()) ? 'edit' : 'add')).' '.$dataType->display_name_singular)@section('page_header')    <h1 class="page-title">        <i class="{{ $dataType->icon }}"></i>        {{ __('voyager::generic.'.(!is_null($dataTypeContent->getKey()) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}    </h1>    @include('voyager::multilingual.language-selector')@stop@section('content')    <div class="page-content edit-add container-fluid">        <div class="row">            <div class="col-md-12">                <div class="panel panel-bordered">                    <!-- form start -->                    <form role="form"                            class="form-edit-add"                            action="@if(!is_null($dataTypeContent->getKey())){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"                            method="POST" enctype="multipart/form-data">                        <!-- PUT Method if we are editing -->                        @if(!is_null($dataTypeContent->getKey()))                            {{ method_field("PUT") }}                        @endif                        <!-- CSRF TOKEN -->                        {{ csrf_field() }}                        <div class="panel-body">							<!-- Adding / Editing -->							<!-- GET THE DISPLAY OPTIONS -->							<div class="form-group  col-md-12">							<label for="name">Nom du Personnel</label>							<select class="form-control select2" name="user_id" >								@foreach(App\Personnel::all() as $item)									@php										$lastPaiement = $item->getLastPaiment();										if($loop->iteration==1){											$firstLastPaiement = $item->getLastPaiment();										}									@endphp									@php echo '<option data-lastpaiement="'.$lastPaiement.'" value="'.$item->id.'" '.($dataTypeContent->user_id && $dataTypeContent->user_id==$item->id ? "selected" : "").'>'.$item->name.'</option>' @endphp								@endforeach															</select>							</div>							<!-- GET THE DISPLAY OPTIONS -->							<div class="form-group  col-md-12">							<label for="titre">Titre</label>							<input type="text" class="form-control" name="titre" placeholder="Titre" value="{{$dataTypeContent->titre ? $dataTypeContent->titre : ''}}">							</div>							<!-- GET THE DISPLAY OPTIONS -->							<div class="form-group  col-md-12">							<label for="desc">Description</label>							<textarea class="form-control" name="desc" placeholder="Description">{{$dataTypeContent->desc ? $dataTypeContent->desc : ''}}</textarea>							</div>							<!-- GET THE DISPLAY OPTIONS -->							<div class="form-group  col-md-12" style="display:none">							<label for="type">Type</label>							<select class="form-control select2 select2-hidden-accessible" name="type" tabindex="-1" aria-hidden="true">							<option value="0" selected><?php echo ('Dépense') ?></option>							<option value="1" >Revenu</option>							</select>							</div>							<!-- GET THE DISPLAY OPTIONS -->							<div class="form-group  col-md-12" style="display:none">							<label for="is_etudiant">Pour <?php echo ('Étudiant') ?></label>							<select class="form-control select2 select2-hidden-accessible" name="is_etudiant" tabindex="-1" aria-hidden="true">							<option value="0" selected>Non</option>							<option value="1">Oui</option>							</select>							</div>							<!-- GET THE DISPLAY OPTIONS -->							<div class="form-group  col-md-12">							<label for="total">Total</label>							<input type="number" class="form-control" name="total" step="any" placeholder="Total" value="{{$dataTypeContent->total ? $dataTypeContent->total : ''}}">							</div>							<!-- GET THE DISPLAY OPTIONS -->							<div class="form-group  col-md-12">                                        							<label for="statu">Statu</label>							<select class="form-control select2 select2-hidden-accessible" name="statu" tabindex="-1" aria-hidden="true">							<option value="1" {{!is_null($dataTypeContent->getKey()) && $dataTypeContent->statu=='1' ? "selected" : ""}}><?php echo ('payé') ?></option>							<option value="0" {{!is_null($dataTypeContent->getKey()) && $dataTypeContent->statu=='0' ? "selected" : ""}}>non <?php echo ('payé') ?></option>							<option value="2" {{!is_null($dataTypeContent->getKey()) && $dataTypeContent->statu=='2' ? "selected" : ""}}>En cours</option>							</select>							</div>							<!-- GET THE DISPLAY OPTIONS -->							<div class="form-group  col-md-12">                                        							<label for="method"><?php echo ('Méthode') ?></label>							<select class="form-control select2 select2-hidden-accessible" name="method" tabindex="-1" aria-hidden="true">							<option value="0" {{!is_null($dataTypeContent->getKey()) && $dataTypeContent->method=='0' ? "selected" : ""}}><?php echo ('Chèque') ?></option>							<option value="1" {{!is_null($dataTypeContent->getKey()) && $dataTypeContent->method=='1' ? "selected" : ""}}>Cache</option>							<option value="2" {{!is_null($dataTypeContent->getKey()) && $dataTypeContent->method=='2' ? "selected" : ""}}>carte de <?php echo ('crédit') ?></option>							<option value="3" {{!is_null($dataTypeContent->getKey()) && $dataTypeContent->method=='3' ? "selected" : ""}}>Autre</option>							</select>														</div>							<!-- GET THE DISPLAY OPTIONS -->							<div class="form-group  col-md-12">							<label for="name">Date de Paiement ( Dernier Paiement : <span style="font-weight:bold" id="lastpaiment">{{(isset($firstLastPaiement) ? $firstLastPaiement : "")}}</span> ) </label>							<input type="date" class="form-control" name="date" placeholder="Date" value="">							</div>						</div>                        <div class="panel-footer">                            <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>                        </div>                    </form>                    <iframe id="form_target" name="form_target" style="display:none"></iframe>                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">                        <input name="image" id="upload_file" type="file"                                 onchange="$('#my_form').submit();this.value='';">                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">                        {{ csrf_field() }}                    </form>                </div>            </div>        </div>    </div>    <div class="modal fade modal-danger" id="confirm_delete_modal">        <div class="modal-dialog">            <div class="modal-content">                <div class="modal-header">                    <button type="button" class="close" data-dismiss="modal"                            aria-hidden="true">&times;</button>                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>                </div>                <div class="modal-body">                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>                </div>                <div class="modal-footer">                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>                </div>            </div>        </div>    </div>    <!-- End Delete File Modal -->@stop@section('javascript')    <script>        var params = {};        var $image;        $('document').ready(function () {			$('select[name=user_id]').on('change', function() {				$('#lastpaiment').text($(this).find(":selected").data('lastpaiement'));			});							            $('.toggleswitch').bootstrapToggle();            //Init datepicker for date fields if data-datepicker attribute defined            //or if browser does not handle date inputs            $('.form-group input[type=date]').each(function (idx, elt) {                if (elt.type != 'date' || elt.hasAttribute('data-datepicker')) {                    elt.type = 'text';                    $(elt).datetimepicker($(elt).data('datepicker'));                }            });            $('.side-body input[data-slug-origin]').each(function(i, el) {                $(el).slugify();            });            $('.form-group').on('click', '.remove-multi-image', function (e) {                e.preventDefault();                $image = $(this).siblings('img');                params = {                    slug:   '{{ $dataType->slug }}',                    image:  $image.data('image'),                    id:     $image.data('id'),                    field:  $image.parent().data('field-name'),                    _token: '{{ csrf_token() }}'                }                $('.confirm_delete_name').text($image.data('image'));                $('#confirm_delete_modal').modal('show');            });            $('#confirm_delete').on('click', function(){                $.post('{{ route('voyager.media.remove') }}', params, function (response) {                    if ( response                        && response.data                        && response.data.status                        && response.data.status == 200 ) {                        toastr.success(response.data.message);                        $image.parent().fadeOut(300, function() { $(this).remove(); })                    } else {                        toastr.error("Error removing image.");                    }                });                $('#confirm_delete_modal').modal('hide');            });            $('[data-toggle="tooltip"]').tooltip();        });    </script>@stop