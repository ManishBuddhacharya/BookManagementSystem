<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $appends = ['attachment_url'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded= [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'userc_id', 'id');
    }

    public function setPublishedDateAttribute($value)
    {
        $this->attributes['published_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getAttachmentUrlAttribute()
    {
        return isset($this->attributes['attachment']) ? route('books.attachment', ['attachment' => base64_encode($this->attributes['attachment'])]) : NULL;
    }

}
