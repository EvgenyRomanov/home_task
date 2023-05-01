<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Filterable;

class Task extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'tasks';
    protected $guarded = [];

    public function engineer()
    {
        return $this->belongsTo(Engineer::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
