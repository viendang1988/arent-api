<?php

namespace App\Serializer;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Entity\MealHistory;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;

final class MealHistoryDenormalize implements ContextAwareDenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    protected const ALREADY_CALLED = 'MEAL_HISTORY_DENORMALIZER_ALREADY_CALLED';

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

        return $type === MealHistory::class;
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

        $data['user'] = $currentUserIri;

        if (empty($data['date'])) {
            $data['date'] = (new \DateTime())->format('Y-m-d');
        }

        return $this->denormalizer->denormalize($data, $type, $format, $context);
    }

}
