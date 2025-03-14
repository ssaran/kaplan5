<?php
/**
 * User: Sancar Saran
 * Date: 18.9.2015
 * Time: 9:54
 *
 * User: Sancar Saran
 * Extended
 * Date: 30.10.2019
 * Time: 14:43
 */

namespace K5\Helper\Form;

class Render
{
    private static array $_elements = [];
    private static array $_out = [];
    private static \K5\Entity\Request\Setup $_setup;
    private static \Phalcon\Forms\Form $_form;
    private static array $_formSetup = [];
    private static array $_hidden = [];
    private static array $_content = [];
    private static array $_rawKeys = [];
    private static ?array $_template = [];

    public static function Exec(\K5\Entity\Request\Setup $setup,\Phalcon\Forms\Form $form, array $formSetup,?array $template=null) : void
    {
        self::$_setup = $setup;
        self::$_form = $form;
        self::$_formSetup = $formSetup;
        self::$_out['html'] = '';
        self::$_out['js'] = '';
        if(!is_null($template)){
            self::$_template = $template;
        } else {
            self::$_template = [
                'group' => '<div class="mb-3" id="{id}_form_group_cover">{label}{html}</div>',
                'label' => '<label for="{name}" id="{id}_form_label" class="form-label">{label_text}</label>',
                'hidden' => '{html}' . "\n",
                'full_width' => 'col-12',
                'with_label' => 'col-9'
            ];
        }

        self::parseContent();
        self::$_out['html'] =
                self::GetFormStart(self::$_formSetup['form']).'
                '.implode("\n",self::$_content).'
                '.self::GetSubmit().'					
                '.implode("\n",self::$_hidden).'
                '.self::GetFormEnd().'
';
        self::$_out['js'] = '';

    }

    public static function GetFormStart(?array $params = []) : string
    {
        $_params = is_null($params) ? self::$_formSetup['form'] : $params;
        return '<form '.\K5\Helper\Dom\ElementParameters::Prepare($_params).'>';
    }

    public static function GetFormEnd() : string
    {
        return '</form>';
    }

    public static function GetElementKeys(bool $isRaw=false) : array
    {
        if(!$isRaw) {
            return array_keys(self::$_content);
        }
        return array_keys(self::$_rawKeys);
    }

    public static function GetElementById(string $id,bool $isRaw=true) : string
    {
        $_r = '-';
        $_myId = $id;
        if(!$isRaw && isset(self::$_rawKeys[$id]) ) {
            $_myId = self::$_rawKeys[$id];
        }
        if(isset(self::$_content[$_myId])) {
            $_r = self::$_content[$_myId];
        }
        return $_r;
    }

    public static function GetHidden() : string
    {
        return  implode("\n",self::$_hidden);
    }

    public static function parseContent($customTemplate = null) : bool
    {
        self::$_content = [];

        // Merge custom template with default
        $template = $customTemplate ? array_merge(self::$_template, $customTemplate) : self::$_template;

        foreach (self::$_form as $f) {
            $className = get_class($f);
            $nameElement = $f->getName();
            $labelElement = $f->getLabel();
            $attr = $f->getAttributes();
            $vals = $f->getValidators();
            $html = $f->render();
            $id = $f->getAttribute('id');

            self::$_elements[$id] = $nameElement;

            // Handle hidden elements
            if ($className == "Phalcon\Forms\Element\Hidden") {
                self::$_hidden[] = str_replace('{html}', $html, $template['hidden']);
                continue;
            }

            // Label and column width logic
            if (isset($attr['no-label']) || (self::$_formSetup->FormIsNaked())) {
                $label = '';
                $col = $template['full_width'];
            } else {
                $label = str_replace(
                    ['{name}', '{id}', '{label_text}'],
                    [$nameElement, $id, $labelElement],
                    $template['label']
                );
                $col = $template['with_label'];
            }

            // Add HTML message if specified
            if (isset($attr['html-msg'])) {
                $html .= " " . $attr['html-msg'];
            }

            // Handle replace functionality
            if (isset($attr['replace'])) {
                $findRepl = explode("-", $attr['replace']);
                if (sizeof($findRepl) == 2) {
                    $html = str_replace($findRepl[0], $findRepl[1], $html);
                } else {
                    \K5\U::ldbg($findRepl);
                }
            }

            // Apply Bootstrap 5 column class if specified
            if ($col) {
                $html = "<div class=\"$col\">$html</div>";
            }

            // Build final output using template
            $finalHtml = str_replace(
                ['{id}', '{label}', '{html}'],
                [$id, $label, $html],
                $template['group']
            );

            self::$_content[$id] = $finalHtml;
        }
        return true;
    }

    public static function GetSubmit($naked=false) : string
    {
        if(self::$_formSetup->SubmitIsDisabled()) {
            return '';
        }

        $submitParams = self::$_formSetup->SubmitGetParams();
        if(self::$_formSetup->SubmitIsHidden()) {
            $submitParams['class'][] = 'd-hide';
        }

        $_params = \K5\Helper\Dom\ElementParameters::Prepare($submitParams);

        $btn = '
                    <button '.$_params.'">'.self::$_formSetup->SubmitGetIcon(). ' ' .self::$_formSetup->SubmitGetLabel().'</button>
        ';
        if(!$naked) {
            return '
            <div class="form-group hidden-sm hidden-xs">&nbsp;</div>
            <div class="form-group">
                <div class="col-sm-12 form-element-cover">
                    '.$btn.'
                </div>
            </div>
';
        }

        return $btn;
    }

}