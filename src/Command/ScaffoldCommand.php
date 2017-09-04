<?php

namespace Drupal\review_scaffold\Command;

use Drupal\Console\Core\Command\Shared\CommandTrait;
use Drupal\review_scaffold\Event\ScaffoldEvent;
use Drupal\review_scaffold\Event\ScaffoldEvents;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ScaffoldCommand extends Command {

  use CommandTrait;

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  public function __construct(EventDispatcherInterface $eventDispatcher) {
    $this->eventDispatcher = $eventDispatcher;
    parent::__construct();
  }

  protected function configure() {
    $this->setName('review:scaffold')
      ->setDescription('Scaffold with review/sample content.');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $output->writeln('Dispatching scaffold event.');
    $event = new ScaffoldEvent();
    $this->eventDispatcher->dispatch(ScaffoldEvents::SCAFFOLD, $event);
    if (!$event->isPropagationStopped()) {
      $output->writeln('Scaffolding successful (propagation was not stopped)');
    }
    else {
      $output->writeln('Scaffolding event propagation was stopped.');
    }
  }

}
