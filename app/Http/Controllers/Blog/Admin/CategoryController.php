<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
//use App\Repositories\BlogCategoryRepository не
//нужен если без BlogCategoryRepository
use App\Repositories\BlogCategoryRepository;
//use Illuminate\Http\Request;

/**
* Управление категориями блога
*
* @package App\Http\Controllers\Blog\Admin
*/
class CategoryController extends BaseController
{
    /**
    * @var BlogCategoryRepository
    */
    private $blogCategoryRepository;

    public function __construct()
    {
      parent::__construct();

      $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(__METHOD__);
        //Без репозитория
        //$paginator = BlogCategory::paginate(5);

        $paginator = $this->blogCategoryRepository->getAllWithpaginate(5);

        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //dd(__METHOD__);
      //из-за одной вьюшки для update u created
      //создаем экземпляр класса
      $item = new BlogCategory();
      //dd($item);
      //Без репосзитория
      //$categoryList = BlogCategory::all();
      $categoryList =
          $this->blogCategoryRepository->getForComboBox();

      return view('blog.admin.categories.edit',
        compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     //php artisan make:request BlogCategoryCreateRequest
     public function store(BlogCategoryCreateRequest $request)
     {
       //dd(__METHOD__);
       $data = $request->input();
       /*
       // Ушло в обсервер
       if (empty($data['slug'])) {
         $data['slug'] = \Str::slug($data['title']);
       }*/
       //Создаст объект но не добавит в БД
       //$item = new BlogCategory($data);
       //dd($item);
       //$item->save();

       //Создаст объект и добавит в БД
       $item = (new BlogCategory())->create($data);

       if ($item) {
         return redirect()->route('blog.admin.categories.edit', [$item->id])
            ->with(['success' => 'Успешно сохранено']);
       } else {
         return back()->withErrors(['msg' => 'Ошибка сохранения'])
            ->withInput();
       }
     }
//-----------------------------------------------------------------------
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //без BlogCategoryRepository
    // public function edit($id)
    // {
    //   //dd(__METHOD__);
    //   //$item = BlogCategory::find($id);
    //   $item = BlogCategory::findOrFail($id);
    //   //$item[] = BlogCategory::where('id', $id)->first();
    //   //dd($item);
    //
    //   $categoryList = BlogCategory::all();
    //
    //   return view('blog.admin.categories.edit',
    //   compact('item', 'categoryList'));
    // }
//-------------------------------------------------------------------------
/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @param BlogCategoryRepository $categoryRepository
 * @return \Illuminate\Http\Response
 */
    public function edit($id, BlogCategoryRepository $categoryRepository)
    {
      //$categoryRepository = new BlogCategoryRepository();
      //$categoryRepository = app(BlogCategoryRepository::class);

      //$item = BlogCategory::findOrFail($id);
      //$categoryList = BlogCategory::all();

      //$item = $categoryRepository->getEdit($id);
      $item = $this->blogCategoryRepository->getEdit($id);
      if (empty($item)) {
        abort(404);
      }

      //$categoryList = $categoryRepository->getForComboBox();
      $categoryList
          = $this->blogCategoryRepository->getForComboBox();

      return view('blog.admin.categories.edit',
          compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BlogCategoryUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //валидация в BlogCategoryUpdateRequest
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        //dd(__METHOD__, $request->all(), $id);
        //$id = 111111;

        // $rules = [
        //   'title'       => 'required|min:5|max:200',
        //   'slug'        => 'max:200',
        //   'description' => 'string|max:500|min:3',
        //   'parent_id'   => 'required|integer|exists:blog_categories,id',
        // ];

        //$validatedData = $this->validate($request, $rules);
        //$validatedData = $request->validate($rules);

        //$validator = \Validator::make($request->all(), $rules);
        //$validatedData[] = $validator->passes();
        //$validatedData[] = $validator->validate();
        //$validatedData[] = $validator->valid();
        //$validatedData[] = $validator->failed();
        //$validatedData[] = $validator->errors();
        //$validatedData[] = $validator->fails();

        //dd($validatedData);
        //php artisan make:request BlogCategoryUpdateRequest
        //$item = BlogCategory::find($id);
        $item = $this->blogCategoryRepository->getEdit($id);
        //dd($item);
        if (empty($item)) {
          return back()
            ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
            ->withInput();
        }

        $data = $request->all();
        /*
        // Ушло в обсервер
        if (empty($data['slug'])) {
          $data['slug'] = \Str::slug($data['title']);
}*/
        //dd($data);
        $result = $item->fill($data)->save();
        //$result = $item->update($data);
        if ($result) {
          return redirect()
            ->route('blog.admin.categories.edit', $item->id)
            ->with(['success' => 'Успешно сохранено']);
        } else {
          return back()
            ->withErrors(['msg' => 'Ошибка сохранения'])
            ->withInput();
        }
    }
}
