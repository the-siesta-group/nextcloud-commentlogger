<?php

declare(strict_types=1);

namespace OCA\CommentLogger\Event;

use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\Comments\CommentsEvent;
use function OCP\Log\logger;

class CommentListener implements IEventListener {
    public function handle(Event $event): void {
        if (!($event instanceof CommentsEvent)) {return;}

        $comment = $event->getComment();
        $file_id = $comment->getObjectId();
        $path = ($nodes = \OC::$server->getRootFolder()->getById($file_id)) ? $nodes[0]->getPath() : null;
        $actions = array(
            CommentsEvent::EVENT_ADD => 'Added',
            CommentsEvent::EVENT_DELETE => 'Deleted',
            CommentsEvent::EVENT_PRE_UPDATE => 'Updated',
            CommentsEvent::EVENT_UPDATE => 'Updated',
        );
        $old_or_new_value = array(
            CommentsEvent::EVENT_ADD => 'new_value',
            CommentsEvent::EVENT_DELETE => 'old_value',
            CommentsEvent::EVENT_PRE_UPDATE => 'old_value',
            CommentsEvent::EVENT_UPDATE => 'new_value',
        );
        logger('commentlogger')->info(
            sprintf(
                '%s a comment on %s (id "%s")',
                $actions[$event->getEvent()],
                $path,
                $file_id,
            ),
            array($old_or_new_value[$event->getEvent()] => $comment->getMessage())
        );
    }
}
