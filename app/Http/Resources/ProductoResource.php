<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'precio' => $this->precio,
            'nombre' => $this->nombre,
            'imagen' => $this->imagen,
            'disponible' => $this->disponible,
            'categoria_id' => $this->categoria_id
        ];
    }
}
