<?php

namespace App\Services\Exporters;

use SimpleXMLElement;

class XmlExporter extends Exporter
{
    public function export(array $data): string
    {
        $xml = new SimpleXMLElement('<root/>');
        foreach ($data as $item) {
            $child = $xml->addChild('item');
            foreach ($item as $key => $value) {
                $child->addChild($key, htmlspecialchars($value));
            }
        }
        return $xml->asXML();
    }
}
