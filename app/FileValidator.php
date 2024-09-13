<?php

namespace App;

use Illuminate\Support\Facades\Log;

class FileValidator
{

    public function handle(string $file) : bool {

        $encoded = json_decode($file, true);

        if(!$encoded) {
            return false;
        }

        $results = $this->checkForTeamId($encoded);

        if(!$results) {
            return false;
        }


        return true;

    }

    protected function checkForTeamId(array $encoded) : bool {

        $appIds = data_get($encoded, 'applinks.details.0.appIDs');

        if(!$appIds) {
            return false;
        }

        $id = "39BPG64KGW.com.rivian.ios.consumer";

        if(!in_array($id, $appIds)) {
            return false;
        }

        return true;
    }
}
