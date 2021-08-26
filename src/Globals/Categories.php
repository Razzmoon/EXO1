<?php


namespace App\Globals;


use App\Repository\CategoriesRepository;

class Categories
{
    private $categoryRepository;

    public function __construct(CategoriesRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll()
    {
        $categories = $this->categoryRepository->findAll();

        return $categories;
    }

}