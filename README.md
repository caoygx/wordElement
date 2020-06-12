#使用方法
```
 $allElement = [
        'fess', 'ap', 'ad', 'pro', 'ion', 'pro', 'al','en','li','ght'
    ]; //词根前缀后缀集合
$word = "adapprofessional"; //测试单词

$sp = new Separate($word);
$sp->dispose($allElement);
$er = new ElementRender();
$r = $er->render($word, $sp->elements);
echo($r);
print_r($er->arrWordElements);

```
输出结果
```
Array
(
    [0] => ad
    [1] => ap
    [2] => pro
    [3] => fess
    [4] => ion
    [5] => al
)
```

# 浏览器运行效果

![页面](https://github.com/caoygx/wordElement/blob/master/1.jpg)
