<?php

namespace App\MessageHandler;

use App\Message\CommentMessage;
use App\Notification\CommentReviewNotification;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class CommentMessageHandler implements MessageHandlerInterface
{

    private $entityManager;
    private $commentRepository;
    private $bus;
    private $workflow;
    private $notifier;
    private $logger;

    public function __construct(
        EntityManagerInterface $entityManager,
        CommentRepository $commentRepository,
        MessageBusInterface $bus,
        WorkflowInterface $commentStateMachine,
        NotifierInterface $notifier,
        LoggerInterface $logger = null
    ) {
        $this->entityManager = $entityManager;
        $this->commentRepository = $commentRepository;
        $this->bus = $bus;
        $this->workflow = $commentStateMachine;
        $this->notifier = $notifier;
        $this->logger = $logger;
    }

    public function __invoke(CommentMessage $message)
    {
        $comment = $this->commentRepository->find($message->getId());
        if (!$comment) {
            return;
        }


        if ($this->workflow->can($comment, 'sended')) {
//            $score = $this->spamChecker->getSpamScore($comment, $message->getContext());
            $transition = 'sended';
            $score = 0;
            if (2 === $score) {
                $transition = 'reject_spam';
            } elseif (1 === $score) {
                $transition = 'might_be_spam';
            }
            $this->workflow->apply($comment, $transition);
            $this->entityManager->flush();

            $this->bus->dispatch($message);
        } elseif ($this->workflow->can($comment, 'publish') || $this->workflow->can($comment, 'publish_ham')) {
            $notification = new CommentReviewNotification($comment, $message->getReviewUrl());
            $this->notifier->send($notification, ...$this->notifier->getAdminRecipients());
        } elseif ($this->workflow->can($comment, 'optimize')) {

            $this->workflow->apply($comment, 'optimize');
            $this->entityManager->flush();
        } elseif ($this->logger) {
            $this->logger->debug(
                'Dropping comment message',
                ['comment' => $comment->getId(), 'state' => $comment->getState()]
            );
        }
    }
}