<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        # 取得token
        $token = $this->createToken('api');
        $this->access_token = $token->accessToken;

        return [
            'id' => $this->hash_id,
            'cellphone' => $this->cellphone,
            'name' => $this->name,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'zipcode' => $this->zipcode,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'access_token' => $token->accessToken,
        ];
    }
}
