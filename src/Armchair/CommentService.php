<?php
namespace Armchair;

class CommentService
{
    protected $model;
    protected $notificationService;

    public function __construct (CommentModel $model, NotificationService $notificationService)
    {
         $this->model = $model;
         $this->notificationService = $notificationService;
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

    public function activate($hash)
    {
        $comment = $this->model->getByHash($hash);

        if ($comment) {
            $data['status'] = 'active';
            $data['date_activate'] = date('Y-m-d H:i:s');
            
            if ($this->model->update($data, $comment['id'])) {
                return $comment;
            }
        }
    }

    public function trash($hash)
    {
        $comment = $this->model->getByHash($hash);

        if ($comment) {
            $data['status'] = 'trash';
            $data['date_trash'] = date('Y-m-d H:i:s');
            
            if ($this->model->update($data, $comment['id'])) {
                return $comment;
            }
        }
    }

    public function insert(array $data)
    {
        $data['date_created'] = date('Y-m-d H:i:s');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['status'] = 'new';

        $res = $this->model->insert($data);

        $data['id'] = $res;
        $data['hash'] = $this->model->getCommentHash($data);
        $this->notificationService->notifyNewComment($data);

        return $res;
    }
}