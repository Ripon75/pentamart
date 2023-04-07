<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'slug',
        'name'
    ];

    protected $casts = [
        'id'         => 'integer',
        'slug'       => 'string',
        'name'       => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }

    public function attachTags($tags, $attachToObj)
    {
        $tagIds = [];
        if (!is_array($tags)) {
            $tags = explode(",", $tags);
        }

        if(count($tags)) {
            foreach ($tags as $tag) {
                if ($tag) {
                    $tag = Self::firstOrCreate(
                        ['name' => $tag ],
                        ['slug' => Str::slug($tag, '-')]
                    );
                    $tagIds[] = $tag->id;
                }
            }
            $attachToObj->tags()->sync($tagIds);
        }
    }
}
