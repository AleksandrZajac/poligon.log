<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;

/**
* Class BlogCategoryRepository
*
* @package App\Repositoties
*/
class BlogPostRepository extends CoreRepository
{
  /**
  * @return string
  */

protected function getModelClass()
  {
    return Model::class;
  }

  /**
  * Получить список статей для вывода в списке
  * (Админка)
  *
  * @return LenghtAwarePaginator
  */
public function getAllWithPaginate()
{
  $columns = [
    'id',
    'title',
    'slug',
    'is_published',
    'published_at',
    'user_id',
    'category_id',
  ];

  $result = $this->startConditions()
                 ->select($columns)
                 ->orderBy('id', 'DESC')
//                 ->with(['category', 'user'])
               ->with([
                 // Можно так
                 'category' => function ($query) {
                   $query->select(['id', 'title']);
                 },
                 // или так
                 'user:id,name',
               ])
                 ->paginate(25);
        //          ->get();
//dd($result->first());
  return $result;
  }
}
