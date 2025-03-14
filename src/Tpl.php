<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 14.03.2025
 * Time: 11:24
 */

namespace K5;

class Tpl {
    private $dom;

    public function __construct() {
        $this->dom = new \DOMDocument('1.0', 'UTF-8');
    }

    // Equivalent to setCustomData
    public function setCustomData(\DOMElement $el, array $dataset): \DOMElement {
        foreach ($dataset as $key => $value) {
            $el->setAttribute("data-$key", $value);
        }
        return $el;
    }

    // Equivalent to setAttribs
    public function setAttribs(\DOMElement $el, array $attribs): \DOMElement {
        foreach ($attribs as $key => $value) {
            if ($key !== 'dataset') {
                $el->setAttribute($key, $value);
            } else {
                $el = $this->setCustomData($el, $value);
            }
        }
        return $el;
    }

    // Equivalent to Node
    public function Node(
        string $tagName,
               $content = false,
        array $attribs = [],
        array $dataset = [],
        array $childs = []
    ): \DOMElement {
        $node = $this->dom->createElement($tagName);

        if ($content !== false) {
            if (is_string($content) || is_numeric($content)) {
                $node->appendChild($this->dom->createTextNode((string)$content));
            } elseif ($content instanceof \DOMElement) {
                $node->appendChild($content);
            }
        }

        if (!empty($attribs)) {
            $node = $this->setAttribs($node, $attribs);
        }

        if (!empty($dataset)) {
            $node = $this->setCustomData($node, $dataset);
        }

        if (!empty($childs)) {
            foreach ($childs as $child) {
                if ($child instanceof \DOMElement) {
                    $node->appendChild($child);
                } else {
                    error_log("Current element is not a DOM element: " . gettype($child));
                }
            }
        }

        return $node;
    }

    // Equivalent to Dom
    public function Dom(string $tagName, array $attribs = [], $childs = false): \DOMElement {
        $node = $this->dom->createElement($tagName);

        if (!empty($attribs)) {
            $node = $this->setAttribs($node, $attribs);
        }

        if ($childs !== false) {
            if (is_string($childs) || is_numeric($childs)) {
                $node->appendChild($this->dom->createTextNode((string)$childs));
            } elseif ($childs instanceof \DOMElement) {
                $node->appendChild($childs);
            } elseif (is_array($childs)) {
                foreach ($childs as $child) {
                    if ($child instanceof \DOMElement) {
                        $node->appendChild($child);
                    } else {
                        error_log("Child is not a DOM element: " . gettype($child));
                    }
                }
            } else {
                error_log("Unsupported child type: " . gettype($childs));
            }
        }

        return $node;
    }

    // Helper to check if an object is a DOMElement
    public function isDomElement($element): bool {
        return $element instanceof \DOMElement;
    }

    // Render the DOM as an HTML string
    public function render(\DOMElement $node): string {
        $this->dom->appendChild($node);
        return $this->dom->saveHTML($node);
    }
}
