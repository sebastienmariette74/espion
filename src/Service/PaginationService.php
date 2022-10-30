<?php

namespace App\Service;

use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginationService extends ServiceEntityRepository
{
    public function __construct(private RequestStack $request){}

    public function pagination(
        Request $request,
        $repo,
        // UserRepository $userRepo,
        int $limit,
        string $function,
        array $filters = null,
        string $query = null,
        string $functionTotal
    ): array
    {
        // $limit = 5;
        $page = htmlentities((int)$request->query->get("page", 1));
        
        $missions = $repo->$function($page, $limit, $filters, $query);
        $total = $repo->$functionTotal($filters, $query);
        // dump($page, $limit, $total, $missions, $repo);

        return [ 
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'missions' => $missions,
        ];
    }
    
}
