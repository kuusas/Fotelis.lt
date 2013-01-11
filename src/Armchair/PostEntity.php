<?php
namespace Armchair;

class PostEntity
{
    protected $slug;
    protected $name;
    protected $date;
    protected $author;
    protected $category;
    protected $contentPath;
    protected $content;
    protected $path;

    public function __construct($slug, $metadata)
    {
        $this->slug = $slug;
        $this->load($metadata);
    }

    public function load($metadata)
    {
        $this->name = $metadata['name'];
        $this->date = $metadata['date'];
        $this->author = $metadata['author'];
        $this->category = $metadata['category'];
        $this->contentPath = $metadata['contentPath'];
        $this->path = $metadata['path'];
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getContent()
    {
        return file_get_contents($this->contentPath);
    }
}