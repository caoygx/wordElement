<?php

test();
function test()
{

    $allElement = [
        'fess', 'ap', 'ad', 'pro', 'ion', 'pro', 'al','en','li','ght'
    ]; //词根前缀后缀集合

    $list = [];
    $rWord = [];
    $rWord[] = "adapprofessional"; //测试单词 
    

    foreach ($rWord as $k => $word) {

        $sp = new Separate($word);
        $sp->dispose($allElement);
        //var_dump($sp->elements);
        $er = new ElementRender();
        $r = $er->render($word, $sp->elements);
        echo($r);
        var_dump($er->arrWordElements);
        
        $list[] = ['word' => $r];
    }
}

function arraySort($array, $keys, $sort = SORT_DESC) {
    $keysValue = [];
    foreach ($array as $k => $v) {
        $keysValue[$k] = $v[$keys];
    }
    array_multisort($keysValue, $sort, $array);
    return $array;
}

class Separate
{
    public $elements = [];
    public $left = 0;
    public $right = 0;
    public $word;


    function __construct($word)
    {
        $this->word = $word;
        $this->right = strlen($word);
    }

    function dispose($elements)
    {

        $oldElementsCount = count($this->elements);
        foreach ($elements as $element) {
            if(empty($elements)) continue;
            $this->getPrefix($this->word, $element);
            $this->getSuffix($this->word, $element);
        }
        $newElementsCount = count($this->elements);

        if ($newElementsCount > $oldElementsCount) {
            $this->dispose($elements);
        }
    }

    /**
     * @param $word
     * @param $element
     */
    function getPrefix($word, $prefix)
    {

        $len = strlen($prefix);
        $start = $this->left;
        if ($this->left >= $this->right) return; //左指针与右指针重合
        //设前缀长度=2,取单词2个字符，判断是否与前缀相同，是则找到了前缀
        if (substr($word, $start, $len) === $prefix) {
            $this->elements[] = ['start' => $start, 'length' => $len];
            $this->left = $start + $len;
        }

    }

    function getSuffix($word, $suffix)
    {

        $lenSuffix = strlen($suffix);
        $lenWord = strlen($word);
        $start = $this->right - $lenSuffix;
        if ($this->right <= $this->left) { //右指针与左指针重合
            return;
        }
        //设前缀长度=2,取单词2个字符，判断是否与前缀相同，是则找到了前缀
        if (substr($word, $start, $lenSuffix) === $suffix) {
            $this->elements[] = ['start' => $start, 'length' => $lenSuffix];
            $this->right = $start;
        }
    }
}


class ElementRender
{
    protected $arrColor = [
        /* '#f00',
         '#0f0',
         '#00f',*/
        '#2a8d2a',
        '#B22222',
        '#E066FF',
        '#B8860B',
        '#f3715c',
        '#7A378B',
        '#7fb80e',

    ];
    protected $team = [];
    protected $teamNo = 0;
    protected $groupedElementColor = [];
    public $arrWordElements;

    function render($word, $wordElement)
    {
        return $this->outString($word, $wordElement);
    }

    function outString($word, $wordElements)
    {

        $wordElements = arraySort($wordElements,"start",SORT_ASC);
        $arrStr = str_split($word);
        $arrCharacter = [];
        $this->arrWordElements = [];
        for ($i = 0; $i < count($arrStr); $i++) {
            $temp = [];
            $temp['char'] = $arrStr[$i];
            //$temp['color'] =
            $arrCharacter[$i] = $temp;
        }
        foreach ($wordElements as $k => $element) {
            $start = $element['start'];
            for ($j = $start; $j < $start + $element['length']; $j++) {
                //var_dump($k);
                $arrCharacter[$j]['color'] = $this->arrColor[$k];
            }
            $this->arrWordElements[] = substr($word,$element['start'],$element['length']);
        }

        $outString = "";
        foreach ($arrCharacter as $k2 => $v) {
            if (!empty($v['color'])) {
                $outString .= "<e style='color: {$v['color']}'>{$v['char']}</e>";//."-".$v['color']."<br />";
            } else {
                $outString .= $v['char'];
            }
        }
        return $outString;
    }

    function render_old($word, $wordElement)
    {
        foreach ($wordElement as $k => $element) {
            $colorElement = "<#1 #2='#3:{$this->arrColor[$k]}'>$element</#1>";//
            $word = str_replace($element, $colorElement, $word);
        }
        $word = str_replace('#1', "e", $word);
        $word = str_replace('#2', "style", $word);
        $word = str_replace('#3', "color", $word);
        //$word = str_replace('#4',"&nbsp;",$word);
        return $word;
    }
}