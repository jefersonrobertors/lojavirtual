<?php

namespace core\helpers;

use app\database\repositories\ProductRepository;

use core\helpers\Request;

final class Paginator {

    private $repository;
    private int $limit = 3;
    private int $currentPage = 1;
    private int $linksPerPage = 2;

    private readonly Server $server;

    public function __construct() {
        //$this->repository = ProductRepository::create();

        $request = Request::create();
        $this->server = $request->getServer();
        $currentPage = $request->get->get('page') ?? 1;

        if($currentPage <= 0) {
            $currentPage = 1;
        }
        $this->currentPage = $currentPage;
    }

    public static function create() : self {
        return new self;
    }

    public function getAll(string $key = '', mixed $value = '') : array {
        $list = $this->repository->list();

        if(!empty($key) && !empty($value)) {
            $method = $this->repository->parseMethod($key, 'get');
            
            $list = array_filter($list, function ($entity) use ($method, $value) {
                return $entity->$method() === $value;
            });
        }
        return $list;
    }

    public function list(array $list) : array {
        return array_chunk($list, $this->limit)[$this->currentPage - 1];
    }

    public function loadPagination(array $list) : string {
        $total = ceil(count($list) / $this->limit);

        if($total <= 1) {
            return '';
        }
        if($this->currentPage > $this->linksPerPage) {
            $start = $this->currentPage - $this->linksPerPage;
        }
        $end = $total;

        if(($this->currentPage + $this->linksPerPage) < $total) {
            $end = $this->currentPage + $this->linksPerPage;
        }
        $html = "<ul class='pagination justify-content-center'>\n";

        if($this->currentPage > 1) {
            $previous = build_query_string('page', $this->currentPage - 1);
            $html .= "\t<li class'page-item'><a class='page-link shadow-none' href='{$previous}'>&laquo;</a></li>\n";
        }
        for($i = $start; $i <= $end; $i++) {
            $current = build_query_string('page', $i);
            if($this->currentPage == $i) {
                $html .= "\t<li class='page-item active' aria-current='page'><span class='page-link' href='{$current}'>$i</span></li>\n";
            }else{
                $html .= "\t<li class='page-item'><a class='page-link shadow-none' href='{$current}'>$i</a></li>\n";
            }
        }
        if($this->currentPage < $total) {
            $next = build_query_string('page', $this->currentPage + 1);
            $html .= "\t<li class='page-item'><a class='page-link shadow-none' href='{$next}'>&raquo;</a></li>\n";
        }
        $html .= "</ul>\n";
        return $html;
    }
}
?>