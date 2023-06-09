<?php

namespace phenyxDigitale\digitalSpreadSheet\Cell;

use DateTimeInterface;
use phenyxDigitale\digitalSpreadSheet\RichText\RichText;
use phenyxDigitale\digitalSpreadSheet\Shared\StringHelper;

class DefaultValueBinder implements IValueBinder {

    /**
     * Bind value to a cell.
     *
     * @param Cell $cell Cell to bind value to
     * @param mixed $value Value to bind in cell
     *
     * @return bool
     */
    public function bindValue(Cell $cell, $value) {

        // sanitize UTF-8 strings

        if (is_string($value)) {
            $value = StringHelper::sanitizeUTF8($value);
        } else if (is_object($value)) {
            // Handle any objects that might be injected

            if ($value instanceof DateTimeInterface) {
                $value = $value->format('Y-m-d H:i:s');
            } else if (!($value instanceof RichText)) {
                // Attempt to cast any unexpected objects to string
                $value = (string) $value; // @phpstan-ignore-line
            }

        }

        // Set value explicit
        $cell->setValueExplicit($value, static::dataTypeForValue($value));

        // Done!
        return true;
    }

    /**
     * DataType for value.
     *
     * @param mixed $value
     *
     * @return string
     */
    public static function dataTypeForValue($value) {

        // Match the value against a few data types

        if ($value === null) {
            return DataType::TYPE_NULL;
        } else if (is_float($value) || is_int($value)) {
            return DataType::TYPE_NUMERIC;
        } else if (is_bool($value)) {
            return DataType::TYPE_BOOL;
        } else if ($value === '') {
            return DataType::TYPE_STRING;
        } else if ($value instanceof RichText) {
            return DataType::TYPE_INLINE;
        } else if (is_string($value) && strlen($value) > 1 && $value[0] === '=') {
            return DataType::TYPE_FORMULA;
        } else if (preg_match('/^[\+\-]?(\d+\\.?\d*|\d*\\.?\d+)([Ee][\-\+]?[0-2]?\d{1,3})?$/', $value)) {
            $tValue = ltrim($value, '+-');

            if (is_string($value) && strlen($tValue) > 1 && $tValue[0] === '0' && $tValue[1] !== '.') {
                return DataType::TYPE_STRING;
            } else if ((strpos($value, '.') === false) && ($value > PHP_INT_MAX)) {
                return DataType::TYPE_STRING;
            } else if (!is_numeric($value)) {
                return DataType::TYPE_STRING;
            }

            return DataType::TYPE_NUMERIC;
        } else if (is_string($value)) {
            $errorCodes = DataType::getErrorCodes();

            if (isset($errorCodes[$value])) {
                return DataType::TYPE_ERROR;
            }

        }

        return DataType::TYPE_STRING;
    }

}
