<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sbine\Tenancy\HasTenancy;

class CommandLog extends Model
{
    use HasFactory, HasTimestamps, HasTenancy;

    protected $fillable = [
        'user_id',
        'command_id',
        'ticks',
        'ticks_remaining',
        'direction',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function command()
    {
        return $this->belongsTo(Command::class);
    }

    public function ticks()
    {
        return $this->command->ticks;
    }
}
