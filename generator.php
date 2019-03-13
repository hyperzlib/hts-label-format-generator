<?php
//生成器

//是否生成label
define('GENERATE_LABEL', true);
//是否生成question
define('GENERATE_QST', true);

//输出目录
$outputDir = 'output';

//分隔符文件
$spilterFile = $outputDir . '/spilter.json';
$helpFile = $outputDir . '/readme.md';
$qstFile = $outputDir . '/question.hed';

require_once(__DIR__ . '/vendor/autoload.php');
$config = include('config.php');

//生成label格式
$spilterList = [];
if(defined('GENERATE_LABEL') && GENERATE_LABEL == true){
    $label = new LabelFormat();
    if(is_file($spilterFile)){
        $spilterList = json_decode(file_get_contents($spilterFile), true);
        $label->setStaticSpilter($spilterList);
    }
    $spilterList = $label->generate($config['part']);
    $helper = $label->generateMarkdown($config['part'], $spilterList);

    file_put_contents($spilterFile, json_encode($spilterList));
    file_put_contents($helpFile, $helper);
} else {
    //读取已经生成的Label
    if(is_file($spilterFile)){
        $spilterList = file_get_contents($spilterFile);
    } else {
        throw new Exception('请先生成label，再生成question');
    }
}


//生成question
