<?php

namespace App\Serializer;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Entity\Exercise;
use App\Entity\ExerciseHistory;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;

final class ExerciseHistoryDenormalize implements ContextAwareDenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    protected const ALREADY_CALLED = 'EXERCISE_HISTORY_DENORMALIZER_ALREADY_CALLED';

    public function __construct(
        protected Security $security,
        protected UserRepository $userRepository,
        protected IriConverterInterface $decorated
    )
    {
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param array $context
     * @return bool
     */
    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $type === ExerciseHistory::class;
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param array $context
     * @return mixed
     * @throws ExceptionInterface
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        $context[self::ALREADY_CALLED] = true;

        /** @var User $currentUser */
        $currentUser = $this->security->getUser();
        $currentUserIri = $this->decorated->getIriFromItem($currentUser);

        /** @var Exercise $exercise */
        $exercise = $this->decorated->getItemFromIri($data['exercise']);

        $data['user'] = $currentUserIri;

        if (empty($data['date'])) {
            $data['date'] = (new \DateTime())->format('Y-m-d');
        }
        $data['caloriesBurnt'] = (int) ((int) $data['timer'] * $exercise->getRate());

        return $this->denormalizer->denormalize($data, $type, $format, $context);
    }

}
