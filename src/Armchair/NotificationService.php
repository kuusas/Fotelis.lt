<?php
namespace Armchair;

class NotificationService
{
    protected $postService;
    protected $mailer;
    protected $twig;
    protected $options = array();

    public function __construct (PostService $postService, 
        \Swift_Mailer $mailer, 
        \Twig_Environment $twig,
        array $options)
    {
        $this->postService = $postService;
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->options = $options;
    }

    public function notifyNewComment(array $comment)
    {
        $post = $this->postService->get($comment['reference']);

        $body = $this->twig->render('notification/new_comment.html', array(
            'comment' => $comment,
            'post' => $post,
        ));

        $message = \Swift_Message::newInstance()
            ->setSubject('Fotelis new comment')
            ->setFrom($this->options['from'])
            ->setTo($this->options['to'])
            ->setBody($body, 'text/html');

        $res = $this->mailer->send($message);

        return $res;
    }
}