<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleDailyView extends Model
{
    protected $fillable = ['article_id', 'view_date', 'views'];

    protected $casts = [
        'view_date' => 'date',
        'views'     => 'integer',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
