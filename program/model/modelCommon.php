<?php

class modelCommon extends coreModel
{
    protected static function _load($sClass)
    {
        $aDsn = getDsn('microblog');

        return m($sClass, $aDsn);
    }
}
