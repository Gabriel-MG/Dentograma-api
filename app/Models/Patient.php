<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    protected $fillable = ['public_id','workspace_id','name','email','phone'];
    public function workspace(): BelongsTo
    { return $this->belongsTo(Workspace::class); }
}
