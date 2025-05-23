<?php

namespace App\Traits;

trait RulesTraits
{
    public function requiredMessage($attr)
    {
        return  'Data ' . $attr . ' harus di isi.';
    }

    public function existsMessage($attr)
    {
        return  'Data ' . $attr . ' tidak cocok dengan database kami.';
    }

    public function formattingMessage($attr, $format)
    {
        return  'Data ' . $attr . ' harus memiliki format ' . $format;
    }

    public function fileMessage(array $extensions)
    {
        $extensionsList = implode(', ', $extensions);
        return "Hanya menerima file dengan exstension {$extensionsList}.";
    }

    public function contactMessage()
    {
        return 'Nomor kontak harus ada.';
    }
}
