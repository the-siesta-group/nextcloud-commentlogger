<?php

declare(strict_types=1);

namespace OCA\CommentLogger\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\Comments\CommentsEvent;
use OCA\CommentLogger\Event\CommentListener;

class Application extends App implements IBootstrap {
    public function __construct() {
        parent::__construct("commentlogger");
    }

    public function register(IRegistrationContext $context): void {
        $context->registerEventListener(CommentsEvent::class, CommentListener::class);
    }

    public function boot(IBootContext $context): void {}
}
