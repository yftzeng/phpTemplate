<?php
function assocArrayToXML($root, $ar) {
    $xml = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\" ?"."><{$root}></{$root}>");
    $f = create_function('$f,$c,$a', '
            foreach($a as $k=>$v) {
                if(is_array($v)) {
                    $ch=$c->addChild($k);
                    $f($f,$ch,$v);
                } else {
                    $c->addChild($k,$v);
                }
            }');
    $f($f,$xml,$ar);
    return $xml->asXML();
}
