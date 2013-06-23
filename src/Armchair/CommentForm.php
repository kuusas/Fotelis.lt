<?php
namespace Armchair;

use Symfony\Component\Validator\Constraints as Assert;

class CommentForm 
{
    protected $formFactory;
    protected $session;
    protected $request;
    protected $comment;
    protected $isSuccess = false;

    public function __construct($formFactory, $session, $request, CommentService $comment) 
    {
        $this->formFactory = $formFactory;
        $this->session = $session;
        $this->request = $request;
        $this->comment = $comment;
    }

    public function isSuccess()
    {
        return $this->isSuccess;
    }

    public function getForm($reference)
    {
        $data = array(
            'reference' => $reference
        );

        $form = $this->formFactory->createBuilder('form', $data)
            ->add('reference', 'hidden')
            ->add('name', 'text', array(
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 2)))
            ))
            ->add('email', 'text', array(
                'constraints' => new Assert\Email()
            ))
            ->add('comment', 'textarea', array(
                'constraints' => array(new Assert\NotBlank())
            ))
            ->getForm();

        if ('POST' == $this->request->getMethod()) {
            $form->bind($this->request);

            if ($form->isValid()) {
                $data = $form->getData();
                $this->isSuccess = true;

                if ($this->comment->insert($data)) {
                    $this->session->set('flash', array(
                        'type' => 'success',
                        'title' => 'Ačiū!',
                        'message' => 'Jūsų komentaras išsaugotas, netrukus administratorius patvirtins.',
                    ));
                } else {
                    $this->session->set('flash', array(
                        'type' => 'error',
                        'title' => 'Klaida!',
                        'message' => 'Atsiprašome, bet nepavyko išsaugoti Jūsų komentaro. Bandykite dar kartą.',
                    ));
                }
            }
        }

        return $form;
    }
}