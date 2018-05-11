<?php

namespace Extera\FormBuilderToDbBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class ExteraFormBuilderToDbBundle extends AbstractPimcoreBundle
{
    public function getJsPaths()
    {
        return [
            '/bundles/exteraformbuildertodb/js/pimcore/startup.js'
        ];
    }

    public function getDescription()
    {
        return [
            'FormBuilder Addon: save contact to object'
        ];
    }

}
