<?php

namespace heggemsnes\parceltwig\models;

use craft\base\Model;

class Settings extends Model
{
    public $manifestPath = 'dist/parcel-manifest.json';
    public $distPath = 'dist';

    public function rules()
    {
        return [
            [['manifestPath', 'distPath'], 'required'],
            // ...
        ];
    }
}