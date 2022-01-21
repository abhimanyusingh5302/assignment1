<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{


    public function __construct($resource)
    {
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       
       
        
        $response_data=   [
            "id" => $this->id ?? null,
            'name' => $this->name ?? null,
            'email' => $this->email ?? null,
            'phone_number' => $this->phone_number ?? null,
            "country_iso_code" => $this->country_iso_code ?? null,
            "date_of_birth"=>$this->date_of_birth ?? null,
            
        ];


        if (isset($this->auth_token) and $this->auth_token != null) {
            $response_data['access_token'] = $this->auth_token ?? null;
        }
        return $response_data;

    }
}
