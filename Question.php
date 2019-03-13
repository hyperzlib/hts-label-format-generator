<?php
class Question {
    private $qstLine = []; //qst脚本行

    public function __construct(){

    }

    public function generateOne($lChar, $rChar, $data){
        if(is_string($data)){
            $data = [$data];
        }
        $regexList = [];
        foreach($data as $one){
            if($rChar === ''){
                $regexList[] = '*' . $lChar . $one;
            } else {
                $regexList[] = '*' . $lChar . $center . $rChar . '*';
            }
        }
        return '{' . implode(',', $regexList) . '}';
    }

    public function generatePair($lChar, $rChar, $prefix, $class, $data, $param){
        $spilter = '-';
        if(isset($param['spilter'])){
            $spilter = $param['spilter'];
        }
        $maxKeyLen = 0;
        foreach($data as $key => $one){
            $keyLen = strlen($key);
            if($keyLen > $maxKeyLen){
                $maxKeyLen = $keyLen;
            }
        }
        foreach($data as $key => $one){ //遍历所有键和值
            $fillSpace = $maxKeyLen - strlen($key);
            $qsData = 'QS ';
            $qsName = '';
            if($prefix !== ''){
                $qsName = $prefix . '-';
            }
            $qsName .= Utils::toTitleCase($class) . $spilter . $key;
            $qsRegex = $this->generateOne($lChar, $rChar, $one);
            $qsData .= '"' . $qsName . '" ' . str_repeat(' ', $fillSpace) . $qsRegex;
            $this->qstLine[] = $qsData;
        }
        $this->qstLine[] = '';
    }

    public function generate($conf, $spilterList){
        //遍历所有键
        $genMap = &$conf['map'];
        foreach($conf['part'] as $key => $values){
            if(isset($spilterList['part'])){
                $spilters = &$spilterList['part'];
            } else {
                throw new Exception('没有找到 ' . $key . ' 区段的分隔符');
            }

            //遍历所有参数
            foreach($values as $id => $param){
                $prefix = $param[2]; //前缀
                $class = $param[3];  //数据类型
                if(!isset($genMap[$class])){
                    throw new Exception('生成类型不存在：' . $class);
                }

                $genCode = &$genMap[$class]; //解析生成指令
                foreach($genCode as $type => $data){
                    $specialData = [];
                    foreach($data as $key2 => $data2){
                        if(strpos($key2, $type . '_') == 0){
                            $tKey = substr(strstr($key2, '_'), 1);
                            $specialData[$tKey] = $data2;
                        }
                    }
                    $lChar = $spilters[$id];
                    $rChar = isset($spilters[$id + 1]) ? $spilters[$id + 1] : '';
                    switch($type){
                        case 'pair': //键、值数据
                            $this->generatePair($lChar, $rChar, $prefix, $class, $data, $specialData);
                            break;
                        case 'list': //列表数据
                            break;
                        case 'range': //区间数据
                            break;
                    }
                }
            }
        }
    }
}