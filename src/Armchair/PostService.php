<?php
namespace Armchair;

class PostService
{
    protected $data = array();

    public function add($slug, $params)
    {
        $this->data[$slug] = new PostEntity($slug, $params);
    }

    public function get($slug)
    {
        if ($this->exists($slug)) {
            return $this->data[$slug];
        }
    }

    public function getAll()
    {
        return $this->data;
    }

    public function getAllByCategory($categorySlug)
    {
        $return = array();
        $data = $this->getAll();

        foreach ($data as $item) {
            if ($item->getCategory() == $categorySlug) {
                $return[] = $item;
            }
        }

        return $return;
    }

    public function exists($slug)
    {
        return array_key_exists($slug, $this->data);
    }

    /**
     * Load all registered posts
     * 
     * @param string $path
     */
    public function load($path)
    {
        $dirs = array();
        
        if (is_string($path)) {
            $path = array($path);
        }

        foreach ($path as $p) {
            $dirs = array_merge($this->getPostDirsByPath($p), $dirs);
        }
        
        foreach ($dirs AS $dir) {
            require_once($dir . '/autoload.php');
        }
    }

    public function getPostDirsByPath($path)
    {
        $return = array();

        if ($handle = opendir($path)) {

            while (false !== ($entry = readdir($handle))) {
                if ($entry == '.' || $entry == '..') {
                    continue;
                }

                $fullPath = $path . '/' . $entry;
                if (is_dir($fullPath)) {
                    $return[] = $fullPath;
                }
            }

            closedir($handle);
        }

        return $return;
    }
}