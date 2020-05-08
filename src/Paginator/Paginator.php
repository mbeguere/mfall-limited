<?php
namespace App\Paginator;

use App\Repository\JobRepository;

class Paginator
{
    const LIMIT = 5;

    private $repository;

    public function __construct(JobRepository $repository)
    {
        $this->repository = $repository;
    }

    public function paginate(int $page): array
    {
        $offset = 0;
        $total = $this->repository->count([]);
        if ($total > self::LIMIT) {
            $pages = ceil($total / self::LIMIT);
            $offset = ($page - 1) * self::LIMIT;
            
        }
        $jobs = $this->repository->findBy([], ['createdAt' => 'DESC'], self::LIMIT, $offset);
        
        return compact('jobs', 'pages', 'page');
    }
}