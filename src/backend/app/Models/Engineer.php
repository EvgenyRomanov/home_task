<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Engineer extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'engineers';
    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
