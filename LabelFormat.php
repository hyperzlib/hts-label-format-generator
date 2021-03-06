<?php
class labelFormat {
    private $staticChar = [];
    private $randChar = [];
    private $usedChar = [];

    public function __construct(){

    }

    public function setStaticSeparator($separator){
        $this->staticChar = $separator;
    }

    public function setSeparatorRange($separator){
        $this->randChar = $separator;
    }

    /**
     * 判断分隔符是否存在
     */
    public function isSeparatorExists($last, $now){
        $len = count($this->usedChar);
        for($i = 1; $i < $len; $i ++){
            if($this->usedChar[$i - 1] == $last && $this->usedChar[$i] == $now){
                return true;
            }
        }
        return false;
    }

    /**
     * 生成指定长度的分隔符
     */
    public function generateSeparator($startChar, $num){
        $len = count($this->randChar) - 1;
        $spliters = [$startChar];
        $this->usedChar[] = $startChar;
        $lastChar = $startChar;
        for($i = 0; $i < $num - 1; $i ++){
            $startTime = time();
            while(true){
                $rand = $this->randChar[rand(0, $len)];
                if(!$this->isSeparatorExists($lastChar, $rand)){
                    $lastChar = $rand;
                    $spliters[] = $rand;
                    $this->usedChar[] = $rand;
                    break;
                }
                if(time()- $startTime >5){
                    throw new Exception('Cannot generate more spilder.');
                }
            }
        }
        return $spliters;
    }

    /**
     * 将分隔符插入字符列表
     */
    public function cInsert($strList, $separatorList){
        if(count($strList) != count($separatorList)){
            throw new Exception('The length of stringList not equal with separatorList');
        }

        $ret = '';
        $len = count($strList);
        for($i = 0; $i < $len; $i ++){
            $ret .= $separatorList[$i] . $strList[$i];
        }
        return $ret;
    }

    public function generateId($start, $num){
        $ret = [];
        for($i = 0; $i < $num; $i ++){
            $ret[] = $start . strval($i + 1);
        }
        return $ret;
    }

    public function generateFormat($items){
        $ret = [];
        foreach($items as $item){
            $ret[] = '%' . $item[0];
        }
        return $ret;
    }

    public function generateMarkdown($config, $separatorList){
        $md = "<style>* { font-family: Consolas, 'Courier New', monospace, 'Microsoft Yahei' }</style>\r\n";
        //生成示例
        $demoList = [];
        foreach($config as $key => $one) {
            $demoList[$key] = $this->cInsert($this->generateId($key, count($one)), $separatorList[$key]);
        }
        $md .= "## 示例\r\n";
        $md .= "```\r\n";
        $md .= implode('', $demoList) . "\r\n```\r\n";
        //生成介绍表格
        $md .= "| 变量 | 介绍 |\r\n| ---- | ---- |\r\n";
        $firstLine = true;
        foreach($config as $key => $one){
            if($firstLine){
                $firstLine = false;
            } else {
                $md .= "| | |\r\n";
            }
            foreach($one as $id => $item){
                $md .= sprintf("| %s%d | %s |\r\n", $key, $id + 1, $item[1]);
            }
        }
        //生成格式输出样例
        $md .= "\r\n## 格式\r\n";
        $md .= "```\r\n";
        foreach($config as $key => $one){
            $md .= '"' . $this->cInsert($this->generateFormat($one), $separatorList[$key]) . '", ' . implode(', ', $this->generateId($key, count($one))) . "\r\n";
        }
        $md .= "```\r\n";
        return $md;
    }

    public function generateTemplate($config, $separatorList){
        //生成示例
        $template = [];
        foreach($separatorList as $type => $separators){
            $opt = $config[$type];
            $temp = [];
            foreach($separators as $key => $separator){
                $temp[] = [$opt[$key][2], $opt[$key][3]];
            }
            $template[$type] = $temp;
        }
        return ['separators' => $separatorList, 'values' => $template];
    }

    public function generate($config){
        $separatorList = [];
        foreach($config as $key => $one){
            $key = strtolower($key);
            if(isset($this->staticChar[$key])){
                if($key !== 'p'){
                    $startChar = '/' . strtoupper($key) . ':';
                } else {
                    $startChar = '';
                }
                $separator[0] = $startChar;
                $separator = $this->staticChar[$key];
                if(count($separator) >= count($one)){
                    $separator = array_splice($separator, 0, count($one));
                }
                $this->usedChar = array_merge($this->usedChar, $separator);
                if(count($separator) < count($one)) {
                    $appendSeparator = $this->generateSeparator(end($separator), count($one) - count($separator) + 1);
                    $separator = array_merge($separator, array_splice($appendSeparator, 1));
                }

            } else {
                $startChar = '/' . strtoupper($key) . ':';
                $separator = $this->generateSeparator($startChar, count($one));
            }
            $separatorList[$key] = $separator;
            
        }
        return $separatorList;
    }
}