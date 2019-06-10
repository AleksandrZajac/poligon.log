<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;

class BlogPostObserver
{
    /**
    * Отработка ПЕРЕД созданием записи
    *
    * @param BlogPost $blogPost
    */
    public function creating(BlogPost $blogPost)
    {
      /*$this->setPublishedAt($blogPost);
      $this->setSlug($blogPost);*/
    }

    /**
    * Отработка ПЕРЕД обновлением записи
    *
    * @param BlogPost $blogPost
    */
    public function updating(BlogPost $blogPost)
    {
      // $test[] = $blogPost->isDirty();// изменялись ли поля в модели
      // $test[] = $blogPost->isDirty('is_published');// изменялось ли поле 1
      // $test[] = $blogPost->isDirty('user_id');// изменялось ли поле 1
      // $test[] = $blogPost->getAttribute('is_published');//получаем значение атрибута текущего
      // $test[] = $blogPost->is_published;//получаем значение атрибута текущего значения
      // $test[] = $blogPost->getOriginal('is_published');// получаем значение атрибута старое
      // dd($test);

      $this->setPublishedAt($blogPost);
      $this->setSlug($blogPost);
      //return false;
    }

    /**
    * Если дата публикации не установлена и происходит установка
    * флага - Опубликованоб, то устанавливаем дату публикации
    * на текущую
    *
    * @param BlogPost $blogPost
    */
    protected function setPublishedAt(BlogPost $blogPost)
    {

      if (empty($blogPost->published_at) && $blogPost->is_published) {
        $blogPost->published_at = Carbon::now();
      }
    }

    /**
    * Если поле слаг пустое, то заполняем его конвертацией заголовка.
    *
    * @param BlogPost $blogPost
    */
    protected function setSlug(BlogPost $blogPost)
    {
      if (empty($blogPost->slug)) {
        $blogPost->slug = \Str::slug($blogPost->title);
      }
    }

    /**
     * Handle the blog post "created" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function created(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "updated" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function updated(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "restored" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function restored(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "force deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function forceDeleted(BlogPost $blogPost)
    {
        //
    }
}
