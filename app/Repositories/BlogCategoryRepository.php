<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BlogCategoryRepository.
 */
class BlogCategoryRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class; // абстрагування моделі BlogCategory, для легшого створення іншого репозиторія
    }

    /**
     * Отримати модель для редагування в адмінці
     * @param int $id
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Отримати список категорій для виводу в випадаючий список
     * @return Collection
     */
    public function getForComboBox()
    {
        $columns = [
            'id',
            \DB::raw('CONCAT(id, ". ", title) AS id_title')
        ];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->toBase() // не робити колекцію (масив) BlogCategory, отримати дані у вигляді класу
            ->get();

        return $result;
    }

    /**
     * Отримати категорію для виводу пагінатором
     * @param int|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'parent_id'];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->paginate($perPage); // можна $columns додати сюди

        return $result;
    }
}
