<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Doctor;

use Core\Domain\Repository\DoctorRepositoryInterface;
use Core\Shared\Application\Data\DeleteOutput;
use Core\Shared\Application\Exception\NotFoundException;

final class DoctorDeleteHandler
{
    public function __construct(
        private DoctorRepositoryInterface $repository
    ) {
    }

    public function execute(
        int | string $id,
    ): DeleteOutput {

        $entity = $this->repository->find($id);

        if (null === $entity) {
            throw new NotFoundException('Doctor not found');
        }

        return new DeleteOutput(
            success: $this->repository->delete($entity),
            message: 'Doctor deleted successfully',
        );
    }
}
