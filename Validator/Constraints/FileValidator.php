<?php

namespace cleverdev\BannerBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraints\FileValidator as BaseFileValidator;
use Symfony\Component\Validator\Constraint;

/**
 * File validator
 */
class FileValidator extends BaseFileValidator
{
    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if (is_string($value)) {
            if (!is_file($value)) {
                $webPath = realpath(__DIR__ . '/../../../../web');

                if (false === $webPath) {
                    throw new \RuntimeException(sprintf(
                        'Not found web path "%s".',
                        $webPath
                    ));
                }

                if (is_file($webPath . $value)) {
                    $value = $webPath . $value;
                }
            }
        }

        parent::validate($value, $constraint);
    }
}