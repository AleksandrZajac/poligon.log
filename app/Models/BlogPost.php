<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* Class BlogPost
*
* @package App\Models
*
* @property App\Models\BlogCategory $category
* @property App\Models\User         $user
* @property string                  $slug
* @property string                  $content_html
* @property string                  $content_raw
* @property string                  $excerpt
* @property string                  $published_at
* @property boolean                 $is_published
*/

class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable
      = [
        'title',
        'slug',
        'category_id',
        'excerpt',
        'content_raw',
        'is_published',
        'published_at',
        'user_id',
         ];
    /**
    * Категория статьи.
    *
    * @return \Illuminate\Database\Eloqent\Relations\BelongsTo
    */
    public function category()
    {
      //Eloquent: Relationships
      // Статья принадлежит категории работает если поле
      // имеет окончание _id (category_id)
      return $this->belongsTo(BlogCategory::class);
    }

    /**
    * Автор статьи
    *
    * @return \Illuminate\Database\Eloqent\Relations\BelongsTo
    */
    public function user()
    {
      // Статья принадлежит пользователю работает если поле
      // имеет окончание _id (user_id)
      return $this->belongsTo(User::class);
    }
}
