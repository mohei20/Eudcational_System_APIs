<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->roles[0]->name=='head_of_branch') {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'created_at' => date_format($this->created_at, 'Y m-d h:i:s'),
                'role_id' => $this->roles[0]->id,
                'role_name' => $this->roles[0]->name,
                'branchHead_manager' => $this->headBranch,
            ];
        }elseif ($this->roles[0]->name=='assistant') {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'created_at' => date_format($this->created_at, 'Y m-d h:i:s'),
                'role_id' => $this->roles[0]->id,
                'role_name' => $this->roles[0]->name,
                'branch_id_assistant' => $this->branch[0]->id ,
                'exter_info' => $this->branch[0]->pivot
            ];
        } else {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'created_at' => date_format($this->created_at, 'Y m-d h:i:s'),
                'role_id' => $this->roles[0]->id,
                'role_name' => $this->roles[0]->name,
            ];
        }

    }
}