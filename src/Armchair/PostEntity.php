<?php
namespace Armchair;

class PostEntity
{
    protected $slug;
    protected $title;
    protected $date;
    protected $author;
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
        $this->title = $metadata['title'];
        $this->date = $metadata['date'];
        $this->author = $metadata['author'];
        $this->contentPath = $metadata['contentPath'];
        $this->path = $metadata['path'];
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return file_get_contents($this->contentPath);
    }
}