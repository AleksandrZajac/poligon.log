<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Database\Eloquent\Collection;

/**
* Class BlogCategoryRepository
*
* @package App\Repositories
*/
class BlogCategoryRepository extends CoreRepository
{
  /**
  * @return string
  */
  protected function getModelClass()
  {
    return Model::class;
  }

  /**
  * Получить модель для редактирования в админке.
  *
  * @param int $id
  *
  * @return Model
  */
  public function getEdit($id)
  {
    return $this->startConditions()->find($id);
  }

  /**
  * Получить список категорий для вывода в выподающем списке.
  *
  * @return Collection
  */
  public function getForComboBox()
  {
    //выбираем один из 3 вариантов $result[]
    // $result[] = $this->startConditions()->all();

    // $result[] = $this
    //     ->startConditions()
    //     ->select('blog_categories.*',
    //     \DB::raw('CONCAT (id, ". ", title) AS id_title'))
    //     ->toBase()
    //     ->get();

    $columns = implode(', ', [
      'id',
      'CONCAT (id, ". ", title) AS id_title',
    ]);

    $result = $this
        ->startConditions()
        ->selectRaw($columns)
        ->toBase()
        ->get();

     //dd($result->first());
    return $result;
  }

  /**
  * Получить категории для вывода пагинатором.
  *
  * @param int|null $perPage
  *
  * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
  */
  public function getAllWithpaginate($perPage = null)
  {
    $columns = ['id', 'title', 'parent_id'];
//dd($columns);
    $result = $this
        ->startConditions()
        ->select($columns)
        ->with([
        'parentCategory:id,title',
        ])
        ->paginate($perPage);
//dd($result);
      return $result;
  }
}
