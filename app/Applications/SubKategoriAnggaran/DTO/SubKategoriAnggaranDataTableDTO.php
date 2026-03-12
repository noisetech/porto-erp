<?php

namespace App\Applications\SubKategoriAnggaran\DTO;

use Illuminate\Http\Request;

class SubKategoriAnggaranDataTableDTO
{
    public function __construct(
        public ?string $search,
        public int $start,
        public int $length,
        public int $draw
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            search: $request->input('search.value'),
            start: (int) $request->input('start', 0),
            length: (int) $request->input('length', 10),
            draw: (int) $request->input('draw', 1)
        );
    }
}
