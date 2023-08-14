<?php

namespace  App\Http\trait;

use App\Models\User;


trait Branchable
{
    public function get_branch_id_by_auth_user()
    {
        $assistant = User::with('branch')->role('assistant')->whereId(auth()->user()->id)->first();
        return $assistant->branch()->first()->id;
    }

}
