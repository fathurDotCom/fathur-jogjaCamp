<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public $status;
    public $message;
    public $data;

    public function __construct($status, $message, $data = null)
    {
        $this->data = @$data;
        $this->status  = $status;
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $json = ['code' => $this->status, 'message' => $this->message];
        $this->data ? $json['data'] = $this->data : null;

        return $json;
    }
}
