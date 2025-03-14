<?php
/**
 * Date: 7.11.2019
 * Time: 15:41
 * Updated: 14.03.2025
 */

namespace K5\Helper\Form;

final class Config
{
    private static array $defaultFormParams = [
        'method' => 'POST',
        'name' => null,
    ];

    private static array $defaultSubmitParams = [
        'title' => null,
        'Label' => 'Kaydet',
        'Icon' => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>',
    ];

    private static array $defaultViewParams = [
        'is_naked' => false,
        'is_submit_disabled' => false,
        'is_submit_hidden' => false,
    ];

    /**
     * Prevent instantiation of utility class
     */
    private function __construct() {}

    /**
     * Creates and validates form parameters
     *
     * @param array $formParams
     * @param array $submitParams
     * @return array{form: array, submit: array}
     * @throws \InvalidArgumentException
     */
    public static function create(array $formParams, array $submitParams,array $viewParams=[]): array
    {
        return [
            'form' => self::prepareFormParams($formParams),
            'submit' => self::prepareSubmitParams($submitParams),
            'view' => self::prepareViewParams($viewParams),
        ];
    }

    /**
     * Prepares and validates form parameters
     *
     * @param array $params
     * @param array $append
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function prepareFormParams(array $params, array $append = []): array
    {
        if (empty($params['id'])) {
            throw new \InvalidArgumentException("Form DOM ID is required");
        }

        if (empty($params['action'])) {
            throw new \InvalidArgumentException("Form action is required");
        }

        $result = array_merge(self::$defaultFormParams, $params);

        // Set name to id if not provided
        $result['name'] = $result['name'] ?? $result['id'];

        // Remove processing flags
        unset($result['IsNaked'], $result['Novalidate']);

        // Apply append parameters
        return array_merge($result, $append);
    }

    /**
     * Prepares submit button parameters
     *
     * @param array $params
     * @return array
     */
    public static function prepareSubmitParams(array $params): array
    {
        $result = array_merge(self::$defaultSubmitParams, $params);

        // Ensure title is set
        $result['title'] = $result['title'] ?? $result['Label'];

        // Remove processing flags
        unset($result['Label'], $result['Icon'], $result['IsHidden'], $result['IsDisabled']);

        return $result;
    }

    /**
     * Prepares submit button parameters
     *
     * @param array $params
     * @return array
     */
    public static function prepareViewParams(array $params=[]): array
    {
        return array_merge(self::$defaultViewParams, $params);
    }

    /**
     * Checks if form should be rendered without styling
     *
     * @param array $formParams
     * @return bool
     */
    public static function isFormNaked(array $formParams): bool
    {
        return !empty($formParams['Is-Naked']);
    }

    /**
     * Gets submit button icon
     *
     * @param array $submitParams
     * @return string
     */
    public static function getSubmitIcon(array $submitParams): string
    {
        return $submitParams['Icon'] ?? self::$defaultSubmitParams['Icon'];
    }

    /**
     * Gets submit button label
     *
     * @param array $submitParams
     * @return string
     */
    public static function getSubmitLabel(array $submitParams): string
    {
        return $submitParams['Label'] ?? self::$defaultSubmitParams['Label'];
    }

    /**
     * Checks if submit button should be hidden
     *
     * @param array $submitParams
     * @return bool
     */
    public static function isSubmitHidden(array $submitParams): bool
    {
        return !empty($submitParams['IsHidden']);
    }

    /**
     * Checks if submit button should be disabled
     *
     * @param array $submitParams
     * @return bool
     */
    public static function isSubmitDisabled(array $submitParams): bool
    {
        return !empty($submitParams['IsDisabled']);
    }
}