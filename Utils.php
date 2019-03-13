<?php
class Utils {
    public static function toTitleCase($str){
        $parts = explode('_', $str);
        $ret = [];
        foreach($parts as $part){
            $ret[] = strtoupper($part[0]) . substr($part, 1);
        }
        return implode('_', $ret);
    }
}