<?php
class Question {
    private $qstLine = ['TR 3']; //qst脚本行
    private $qstGroupLen = 0;
    private $scales = ['C', 'Db', 'D', 'Eb', 'E', 'F', 'Gb', 'G', 'Ab', 'A', 'Bb', 'B']; //音高标记

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
                $regexList[] = '*' . $lChar . $one . $rChar . '*';
            }
        }
        return '{' . implode(',', $regexList) . '}';
    }

    public function splitNum($num){
        $ret = [];
        while($num != 0){
            $ret[] = $num % 10;
            $num = floor($num / 10);
        }
        return array_reverse($ret);
    }

    //生成0到指定数字的正则表达式
    public function getNumRangeRegex($num){
        $ret = [];
        $prefix = '';
        $numList = $this->splitNum($num);
        $numLen = count($numList);
        for($i = 1; $i < $numLen; $i ++){
            $ret[] = str_repeat('?', $i);
        }
        for($i = 0; $i < $numLen; $i ++){
            $one = $numList[$i];
            $fillLen = $numLen - $i - 1;
            $j = 0;
            if($numLen > 1 && $i == 0) $j = 1;
            for(; $j < $one; $j ++){
                $ret[] = $prefix . strval($j) . str_repeat('?', $fillLen);
            }
            $prefix .= strval($one);
        }
        $ret[] = strval($num);
        return $ret;
    }

    public function getScaleRangeRegex($now){
        //解析数据
        $ret = [];
        $scale = substr($now, 0, -1);
        $octave = intval(substr($now, strlen($scale)));
        $scaleId = array_search($scale, $this->scales); //获取音符的ID
        for($i = 0; $i < $octave; $i ++){
            $ret[] = '?' . strval($i);
            $ret[] = '?b' . strval($i);
        }
        for($i = 0; $i <= $scaleId; $i ++){
            $ret[] = $this->scales[$i] . strval($octave);
        }
        return $ret;
    }

    public function scaleToInt($now){
        $scale = substr($now, 0, -1);
        $octave = intval(substr($now, strlen($scale)));
        $scaleId = array_search($scale, $this->scales);
        return $octave * 12 + $scaleId;
    }

    public function intToScale($num){
        $scaleId = $num % 12;
        $octave = floor($num / 12);
        $scale = $this->scales[$scaleId];
        return $scale . $octave;
    }

    public function generatePair($lChar, $rChar, $prefix, $class, &$data, &$param) {
        $separator = '-';
        if(isset($param['separator'])){
            $separator = $param['separator'];
        }
        $maxKeyLen = 0;
        foreach($data as $key => $one){
            $keyLen = strlen($key);
            if($keyLen > $maxKeyLen){
                $maxKeyLen = $keyLen;
            }
        }
        if($prefix !== ''){
            $prefix .= '-';
        }
        $prefix .= Utils::toTitleCase($class);
        $this->qstLine[] = '// QS Group "' . $prefix . '" (' . strval($this->qstGroupLen + 1) . '/%d) %.1f%%';
        foreach($data as $key => $one){ //遍历所有键和值
            $fillSpace = $maxKeyLen - strlen($key);
            $qsData = 'QS ';
            $qsName = $prefix . $separator . $key;
            $qsRegex = $this->generateOne($lChar, $rChar, $one);
            $qsData .= '"' . $qsName . '" ' . str_repeat(' ', $fillSpace) . $qsRegex;
            $this->qstLine[] = $qsData;
        }
        $this->qstLine[] = '';
        $this->qstGroupLen ++;
    }

    public function generateList($lChar, $rChar, $prefix, $class, &$data, &$param){
        $separator = '_';
        if(isset($param['separator'])){
            $separator = $param['separator'];
        }
        $maxKeyLen = 0;
        foreach($data as $one){
            $keyLen = strlen($one);
            if($keyLen > $maxKeyLen){
                $maxKeyLen = $keyLen;
            }
        }
        if($prefix !== ''){
            $prefix .= '-';
        }
        $prefix .= Utils::toTitleCase($class);
        $this->qstLine[] = '// QS Group "' . $prefix . '_List" (' . strval($this->qstGroupLen + 1) . '/%d) %.1f%%';
        foreach($data as $one){ //遍历所有键和值
            $fillSpace = $maxKeyLen - strlen($one);
            $qsData = 'QS ';
            $qsName = $prefix . $separator . $one;
            $qsRegex = $this->generateOne($lChar, $rChar, $one);
            $qsData .= '"' . $qsName . '" ' . str_repeat(' ', $fillSpace) . $qsRegex;
            $this->qstLine[] = $qsData;
        }
        $this->qstLine[] = '';
        $this->qstGroupLen ++;
    }

    public function generateRange($lChar, $rChar, $prefix, $class, &$data, &$param){
        $separator = '<=';
        if(isset($param['separator'])){
            $separator = $param['separator'];
        }
        if(isset($data['start'])){ //单级参数转多级
            $data = [$data];
        }
        $maxKeyLen = 0;
        //得到最长的数字
        foreach($data as $one){

            $tLen = strlen(strval($one['end']));
            if($tLen > $maxKeyLen){
                $maxKeyLen = $tLen;
            }
        }
        if($prefix !== ''){
            $prefix .= '-';
        }
        $prefix .= Utils::toTitleCase($class);
        $this->qstLine[] = '// QS Group "' . $prefix . '" (' . strval($this->qstGroupLen + 1) . '/%d) %.1f%%';
        //插入为xx空参数的段落
        $fillSpace = $maxKeyLen - strlen('xx') + 1;
        $qsData = 'QS ';
        $qsName = $prefix . '=xx';
        $qsRegex = $this->generateOne($lChar, $rChar, 'xx');
        $qsData .= '"' . $qsName . '" ' . str_repeat(' ', $fillSpace) . $qsRegex;
        $this->qstLine[] = $qsData;
        //分别生成每个区段
        foreach($data as $one){
            $start = $one['start'];
            $end = $one['end'];
            $step = isset($one['step']) ? $one['step'] : 1;
            for($i = $start; $i <= $end; $i += $step){
                $strKey = strval($i);
                $fillSpace = $maxKeyLen - strlen($strKey);
                $qsData = 'QS ';
                $qsName = $prefix . $separator . $strKey;
                $qsRegex = $this->generateOne($lChar, $rChar, $this->getNumRangeRegex($i));
                $qsData .= '"' . $qsName . '" ' . str_repeat(' ', $fillSpace) . $qsRegex;
                $this->qstLine[] = $qsData;
            }
        }
        $this->qstLine[] = '';
        $this->qstGroupLen ++;
    }

    public function generateScaleRange($lChar, $rChar, $prefix, $class, &$data, &$param){
        $separator = '<=';
        if(isset($param['separator'])){
            $separator = $param['separator'];
        }
        if(isset($data['start'])) { //单级参数转多级
            $data = [$data];
        }
        $maxKeyLen = 3;

        if($prefix !== ''){
            $prefix .= '-';
        }
        $prefix .= Utils::toTitleCase($class);
        $this->qstLine[] = '// QS Group "' . $prefix . '" (' . strval($this->qstGroupLen + 1) . '/%d) %.1f%%';
        //插入为xx空参数的段落
        $fillSpace = $maxKeyLen - strlen('xx') + 1;
        $qsData = 'QS ';
        $qsName = $prefix . '=xx';
        $qsRegex = $this->generateOne($lChar, $rChar, 'xx');
        $qsData .= '"' . $qsName . '" ' . str_repeat(' ', $fillSpace) . $qsRegex;
        $this->qstLine[] = $qsData;
        //分别生成每个区段
        foreach($data as $one){
            $start = $this->scaleToInt($one['start']);
            $end = $this->scaleToInt($one['end']);
            $step = 1;
            for($i = $start; $i <= $end; $i += $step){
                $strKey = $this->intToScale($i);
                $fillSpace = $maxKeyLen - strlen($strKey);
                $qsData = 'QS ';
                $qsName = $prefix . $separator . $strKey;
                $qsRegex = $this->generateOne($lChar, $rChar, $this->getScaleRangeRegex($this->intToScale($i)));
                $qsData .= '"' . $qsName . '" ' . str_repeat(' ', $fillSpace) . $qsRegex;
                $this->qstLine[] = $qsData;
            }
        }
        $this->qstLine[] = '';
        $this->qstGroupLen ++;
    }

    public function generate(&$conf, &$separatorList){
        //遍历所有键
        $genMap = &$conf['map'];
        $parts = &$conf['part'];
        $keyMap = array_keys($parts);
        for($i = 0; $i < count($keyMap); $i ++){
            $key = $keyMap[$i];
            $values = $parts[$key];
            if(isset($separatorList[$key])){
                $separators = &$separatorList[$key];
            } else {
                print($separatorList);
                throw new Exception('没有找到 ' . $key . ' 区段的分隔符');
            }
            if($i < count($keyMap) - 1){
                $separators[] = $separatorList[$keyMap[$i + 1]][0];
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
                    foreach($genCode as $key2 => $data2){
                        if(strpos($key2, $type . '_') == 0){
                            $tKey = substr(strstr($key2, '_'), 1);
                            $specialData[$tKey] = $data2;
                        }
                    }
                    $lChar = $separators[$id];
                    $rChar = isset($separators[$id + 1]) ? $separators[$id + 1] : '';
                    switch($type){
                        case 'pair': //键、值数据
                            $this->generatePair($lChar, $rChar, $prefix, $class, $data, $specialData);
                            break;
                        case 'list': //列表数据
                            $this->generateList($lChar, $rChar, $prefix, $class, $data, $specialData);
                            break;
                        case 'range': //区间数据
                            $this->generateRange($lChar, $rChar, $prefix, $class, $data, $specialData);
                            break;
                        case 'scaleRange': //音高区间
                            $this->generateScaleRange($lChar, $rChar, $prefix, $class, $data, $specialData);
                            break;
                    }
                }
            }
        }
    }

    public function fillProgress(){
        $nowNum = 1;
        foreach($this->qstLine as $key => $one){
            if(strpos($one, '//') === 0){
                $this->qstLine[$key] = sprintf($one, $this->qstGroupLen, (floatval($nowNum) / $this->qstGroupLen) * 100);
                $nowNum ++;
            }
        }
    }

    public function getQuestion(){
        $this->fillProgress();
        return implode("\n", $this->qstLine);
    }
}