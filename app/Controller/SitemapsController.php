<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva
 * Sitemaps Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class SitemapsController extends AppController {

    public function index(){
        $areas = $this->Sitemap->getSitemapInformation('Area');
        $products = $this->Sitemap->getSitemapInformation('Product');

        $this->set(compact('areas','products'));
        $this->RequestHandler->respondAs('xml');
    }
}