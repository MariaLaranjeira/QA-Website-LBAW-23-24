<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Moderator;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class TagPolicy
{
    public function create() : bool
    {
        return Auth::check() && Admin::where('admin_id', Auth::id())->exists();
    }

    public function edit() : bool
    {
        return Auth::check() && Admin::where('admin_id', Auth::id())->exists();
    }

    public function delete() : bool
    {
        return Auth::check() && Admin::where('admin_id', Auth::id())->exists();
    }
}