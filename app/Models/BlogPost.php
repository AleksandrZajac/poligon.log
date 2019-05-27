<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;

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
