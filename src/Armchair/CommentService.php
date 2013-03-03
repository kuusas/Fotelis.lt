<?php
namespace Armchair;

class CommentService
{
    protected $model;

    public function __construct (CommentModel $model)
    {
         $this->model = $model;
    }

    public function getAllByReference($reference)
    {
        return $this->model->getAllByReference($reference);
    }

    public function update(array $data, $id)
    {
        $data['date_updated'] = date('Y-m-d H:i:s');
        return $this->model->update($data, $id);
    }   

    public function insert(array $data)
    {
        $data['date_created'] = date('Y-m-d H:i:s');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];

        return $this->model->insert($data);
    }   
}