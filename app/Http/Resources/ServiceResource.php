<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Sortie;

class ServiceResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'quand'     => $this->quand,
            'type'      => $this->type,
            'qui'       => $this->qui,
            'z'         => $this->z_jour,
            'avances'   => $this->getAvances()->count(),
            'equipe'    => $this->horaires->count(),
            'chiffre'   => $this->chiffre(),
        ];
    }
}
