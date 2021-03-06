<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;
use App\Models\BlogPost;
//use Illuminate\Http\Request;
//use Carbon\Carbon;

/**
*
* Управление статьями блога
*
* @package App\Http\Controllers\Blog\Admin
*/
class PostController extends BaseController
{
    /**
    * @var BlogPostRepository
    */
    private $blogPostRepository;

    /**
    * @var BlogCategoryRepository
    */
    private $blogCategoryRepository;

    /**
    * PostController constructor.
    */
    public function __construct()
    {
      parent::__construct();

      $this->blogPostRepository = app(BlogPostRepository::class);
      $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate();
        return view('blog.admin.posts.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //dd(__METHOD__);
        $item = new BlogPost();
        $categoryList
              = $this->blogCategoryRepository->getForComboBox();
        return view('blog.admin.posts.edit',
              compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BlogPostCreateRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();
        // Создаст объект и добавит в БД
        $item = (new BlogPost())->create($data);

        if ($item) {
          return redirect()->route('blog.admin.posts.edit', [$item->id])
                           ->with(['success' => 'Успешно сохранено']);
        } else {
          return back()->withErrors(['msg' => 'Ошибка сохранения'])
                       ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dd(__METHOD__, $id);
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) {
          abort(404);
        }

        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.posts.edit',
          compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BlogPostUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
        //dd(__METHOD__, $request->all(), $id);
        $item = $this->blogPostRepository->getEdit($id);
//dd($item);
        if (empty($item)) {
          return back()
          ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
          ->withInput();
        }

        $data = $request->all();
       /* Ушло в обсервер
        if (empty($data['slug'])) {
          $data['slug'] = \Str::slug($data['title']);
        }

        if (empty($item->published_at) && $data['is_published']) {
          $data['published_at'] = Carbon::now();
        }*/

        $result = $item->update($data);
//dd($result);
        if ($result) {
          return redirect()
            ->route('blog.admin.posts.edit', $item->id)
            ->with(['success' => 'Успешно сохранено']);
        } else {
          return back()
            ->withErrors(['msg' => 'Ошибка сохранения'])
            ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //d(__METHOD__, $id, request()->all());
        // софт-удаление, в бд остается.
        // если хотим востановить пишем метод restore
        $result = BlogPost::destroy($id);

        // полное удаление из бд
        //$result = BlogPost::find($id)->forceDelete();

        if ($result) {
          return redirect()
            ->route('blog.admin.posts.index')
            ->with(['success' => "Запись id[$id] удалена"]);
        } else {
          return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
