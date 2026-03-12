<?php

namespace App\Http\Resources;

use App\Applications\SubKategoriAnggaran\Mappers\SubKategoriAnggaranResponseMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubKategoriAnggaranResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public $status;
    public $message;

    public function __construct($status, $message, $resource)
    {
        parent::__construct($resource);
        $this->status  = $status;
        $this->message = $message;
    }


    public function toArray($request): array
    {
        return [
            'status' => $this->status ? 'success' : 'error',
            'message' => $this->message,
            'data' => SubKategoriAnggaranResponseMapper::map($this->resource)
        ];
    }
}
