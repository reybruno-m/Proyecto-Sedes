<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
	protected $table = 'categorias';

	public function persona(){
		return $this->hashOne(Persona::class);
	}
}
