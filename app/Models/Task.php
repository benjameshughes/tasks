<?php

namespace App\Models;

use App\Enums\Priority;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    /**
     * Relationships
     */

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Casts
     */
    protected $casts =
    [
        'status' => Status::class,
        'priority' => Priority::class,
        'attachments' => 'array',
     ];

    /**
     * Functions
     */
    // Mark task as complete
    public function complete(): void
    {
        $this->update([
            "status" => Status::complete,
            "updated_at" => now(),
        ]);
    }
}
