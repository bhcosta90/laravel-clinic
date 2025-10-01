<?php

namespace Core\Application\Handler\Patient;

use Core\Domain\Repository\PatientRepositoryInterface;
use Core\Shared\Application\Data\DeleteOutput;
use Core\Shared\Application\Exception\NotFoundException;

class PatientDeleteHandler
{
    public function __construct(
        protected PatientRepositoryInterface $repository
    ) {}

    public function execute(
        int|string $id,
    ): DeleteOutput {

        $entity = $this->repository->find($id);

        if ($entity === null) {
            throw new NotFoundException('Patient not found');
        }

        return new DeleteOutput(
            success: $this->repository->delete($entity),
            message: 'Patient deleted successfully',
        );
    }
}
