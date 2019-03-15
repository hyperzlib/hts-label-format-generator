<?php
//生成器

//是否生成label
define('GENERATE_LABEL', true);
//是否生成question
define('GENERATE_QST', true);

//输出目录
$outputDir = 'output';

//分隔符文件
$separatorFile = $outputDir . '/separator.json';
$helpFile = $outputDir . '/readme.md';
$qstFile = $outputDir . '/question.hed';

@mkdir($outputDir, 0777, true);
require_once(__DIR__ . '/vendor/autoload.php');
$config = include('config.php');

//生成label格式
$separatorList = [];
if($config['switch']['generate_label'] == true){
    $label = new LabelFormat();
    if(is_file($separatorFile)){
        $separatorList = json_decode(file_get_contents($separatorFile), true);
        foreach($config['static_separator'] as $key => $one){
            $separatorList[$key] = $one;
        }
        $label->setStaticSeparator($separatorList);
    } else {
        $label->setStaticSeparator($config['static_separator']);
    }
    $label->setSeparatorRange($config['separator_range']);
    $separatorList = $label->generate($config['part']);
    $helper = $label->generateMarkdown($config['part'], $separatorList);

    file_put_contents($separatorFile, json_encode($separatorList));
    file_put_contents($helpFile, $helper);
} elseif($config['switch']['generate_qst']) {
    //读取已经生成的Label
    if(is_file($separatorFile)){
        $separatorList = file_get_contents($separatorFile);
    } else {
        throw new Exception('请先生成label，再生成question');
    }
}


//生成question
if($config['switch']['generate_qst']){
    $qstGen = new Question();
    $qstGen->generate($config, $separatorList);
    $qst = $qstGen->getQuestion();
    file_put_contents($qstFile, $qst);
}