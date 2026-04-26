<?php

namespace App\Workflow\MarkingStore;

use App\Entity\ToyRequest;
use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\MarkingStore\MarkingStoreInterface;
use Twig\Markup;

final class ToyRequestStatusMarkingStore implements MarkingStoreInterface
{
    /**
     * @param ToyRequest $subject
     */
    public function getMarking(object $subject): Marking
    {
        if ($subject->getStatus() === []) {
            // Si return un new Marking(), c'est le initial_marking qui est utilisé
            return new Marking();
        }

        $representation = [];
        foreach ($subject->getStatus() as $status) {
            $representation[$status->value] = 1;
        }

        return new Marking($representation);
    }

    /**
     * @param ToyRequest $subject
     */
    public function setMarking(object $subject, Marking $marking, array $context = []): void
    {
        $marking = array_keys($marking->getPlaces());
        $subject->setStatus($marking);
    }
}
