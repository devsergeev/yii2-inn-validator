<?php

namespace devsergeev\yii2Validators;

use yii\validators\Validator;
use InvalidArgumentException;
use \devsergeev\validators\InnValidator as DevsergeevInnValidator;

class InnValidator extends Validator
{
    public $messageInvalidLenght;
    public $messageOnlyDigits;
    public $messageInvalidChecksum;

    public function init(): void
    {
        parent::init();
        foreach (['messageInvalidLenght', 'messageOnlyDigits', 'messageInvalidChecksum'] as $propertyName) {
            if ($this->$propertyName) {
                DevsergeevInnValidator::$$propertyName = $this->$propertyName;
            }
        }
    }

    public function validateAttribute($model, $attribute): void
    {
        try {
            DevsergeevInnValidator::check($model->$attribute);
        } catch (InvalidArgumentException $e) {
            $this->addError($model, $attribute, $e->getMessage());
        }
    }
}
