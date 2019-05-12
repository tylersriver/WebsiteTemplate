<?php
/**
 * h -> HTML Builder function and example
 *
 * @param string $tag
 * @param array  $children - variadtic uses of _ or properties array
 *
 * @return string
 */
function h($tag, ...$children)
{
    // Start element
    if(strpos($tag, '.') === false) {
        $html = "<$tag ";
    } else {
        // Add element classes
        $tagParts = explode('.', $tag);
        $tag = $tagParts[0];
        $html = "<$tag";
        foreach ($tagParts as $key => $class) {
            if($key === 0) continue;
            if($key === 1) $html .= " class='";
            $html .= "$class ";
        }
        $html .= "' ";
    }

    // Concat parent properties
    if(count($children) > 0
        and is_array($children[0])
        and array_values($children[0]) !== $children[0]) {

        // Grab element properties
        $props = $children[0];
        unset($children[0]);

        // Add element properties
        foreach ($props as $name => $val) {
            $html .= "$name='$val' ";
        }
    }
    $html .= ">";

    // Concat Children
    foreach ($children as $child) {
        $html .= $child . "\n";
    }

    // End
    $html .= "</$tag>";
    return $html;
}