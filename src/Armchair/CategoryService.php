<?php
namespace Armchair;

class CategoryService
{
    protected $request;
    
    public function __construct($request) 
    {
        $this->request = $request;
    }

    public function getAll()
    {
        return array(
            array(
                'name' => 'PHP',
                'slug' => 'php',
                'url' => $this->request->getBaseUrl() . '/php',
            ),
            array(
                'name' => 'Symfony2',
                'slug' => 'symfony2',
                'url' => $this->request->getBaseUrl() . '/symfony2',
            ),
            array(
                'name' => 'Mobile',
                'slug' => 'mobile',
                'url' => $this->request->getBaseUrl() . '/mobile',
            ),
            array(
                'name' => 'Bendrai',
                'slug' => 'bendrai',
                'url' => $this->request->getBaseUrl() . '/bendrai',
            ),
        );
    }
}