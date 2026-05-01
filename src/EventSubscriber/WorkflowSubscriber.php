<?php

namespace App\EventSubscriber;

use Override;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Workflow\Event\Event;

class WorkflowSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private MailerInterface $mailer,
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function newToyRequest(Event $event): void
    {
        $email = (new Email())
            ->from($event->getSubject()->getKid()->getEmail())
            ->to('mum@test.com')
            ->addTo('dad@test.com')
            ->subject('Demande de jouet - ' . $event->getSubject()->getName())
            ->text('Bonjour Maman et Papa, merci de me commander le jouet : '  . $event->getSubject()->getName());
        ;

        $this->mailer->send($email);
    }

    public function toyReceived(Event $event): void
    {
        $email = (new Email())
            ->from('papa.noel@laponie.fr')
            ->to($event->getSubject()->getKid()->getEmail())
            ->subject('Ton jouet est là, oh oh oh !')
            ->text('Ton jouet est arivé, amuse toi bien !')
        ;

        $this->mailer->send($email);
    }

    public function wainttingConfirmationForDad(Event $event): void
    {
        $link = '<a href="'. $this->urlGenerator->generate('app_toy_parent', referenceType: UrlGeneratorInterface::ABSOLUTE_URL) . '">Confirmer la demande de jouet</a>';

        $email = (new Email())
            ->from('mum@test.com')
            ->to('dad@test.com')
            ->subject('[Papa] Confirmation de demande de jouet')
            ->html('<p>Bonjour Chéri,<p><p>Merci de confirmer la demande de jouet pour ' . $event->getSubject()->getName() . ' via le le lien suivant : ' . $link . '.</p>')
        ;

        $this->mailer->send($email);
    }

    #[Override]
    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.toy_request.leave.request' => 'newToyRequest',
            'workflow.toy_request.entered.received' => 'toyReceived',
            'workflow.toy_request.completed.to_mum_ok' => 'wainttingConfirmationForDad',
        ];
    }
}
