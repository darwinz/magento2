<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\BundleGraphQl\Model\Resolver\Options;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * Format new option id_v2 in base64 encode for entered bundle options
 */
class BundleEnteredOptionValueIdV2 implements ResolverInterface
{
    /**
     * Option type name
     */
    private const OPTION_TYPE = 'bundle';

    /**
     * Create a option id_v2 for entered option in "<option-type>/<option-id>/<option-value-id>/<quantity>" format
     *
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     *
     * @return string
     *
     * @throws GraphQlInputException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($value['option_id']) || empty($value['option_id'])) {
            throw new GraphQlInputException(__('Wrong format option data: option_id should not be empty.'));
        }

        if (!isset($value['selection_id']) || empty($value['selection_id'])) {
            throw new GraphQlInputException(__('Wrong format option data: selection_id should not be empty.'));
        }

        $optionDetails = [
            self::OPTION_TYPE,
            $value['option_id'],
            $value['selection_id'],
            (int) $value['selection_qty']
        ];

        $content = implode('/', $optionDetails);

        // phpcs:ignore Magento2.Functions.DiscouragedFunction
        return base64_encode($content);
    }
}
