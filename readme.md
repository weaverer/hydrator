# 数据类型说明
- 类属性为析public,非静态属性,有类型的,可读写的的属性;目前不支持联合类型和交集类型;
- 类属性的数据类型支持标量,list类型数组(需要doc说明),类类型,枚举类型(回退枚举)
- list类型是标量和class,目前不支持枚举类型

### 类属性类型
#### 注解接口
1. AnnotationInterface:实现AnnotationInterface的注解才能被收集,所有的注解都是AnnotationInterface的子类
2. MapFromInterface:实现MapFromInterface的注解才能在将数据转成对象属性时指定源数据的名称(如 DbField 和 RequestField)
3. ValueConvertInterface:实现ValueConvertInterface的注解才能在将数据转成对象属性时指定转换器,注意会先转换再赋值给对象
4. 如果属性指定了MapFrom的key,但是在源数据中找不到对应的数据,则不会赋值给对象属性
5. 如果没有属性指定MapFrom的key,会将对象属性名和源数据的key进行匹配,匹配成功则赋值给对象属性
6. Convert顺序从上到下执行
### 数组
1. 注解支持数组的数据转换
2. 在绑定数组数据时不会过滤null,如定义int[]类型的属性,传入的数据为[1,2,null,3],属性就是[1,2,null,3],不会过滤null,如果需要过滤null,请在转换器中处理或者加前置检验

### RequestField
#### 说明:RequestField是用于请求数据的字段,用于将请求数据转换成对象属性
#### 参数:
1. @param string $requestField 接口请求字段(post,get等方式的请求的字段)
2. @param string $fieldTitle 字段名称(接口请求字段的名称,会用于错误提示或者用与接口文档生成)
3. @param array $rules 验证规则(必须数组),会将规则转成laravel的检验;注意php的注解不支持表达式,laravel的闭包和Rule::func是不允许的; example1:['required'=>"必填",'max:255'=>'最大长度为255']:example2:['required','in:1,2'=>'只能是1或2']
4. 枚举类型在请求的数据(RequestField)转换时,会默认加上:in(values1,values2)的校验;RequestField已添加in的规则会覆盖默认的规则

### DbField
#### 说明:DbField是用于数据库字段,用于将数据库数据或者entity转换成对象属性
#### 参数:
1. @param string $dbField 数据库字段名称

### Convert
#### 说明:Convert是用于数据转换的注解,注意数据的转换是在赋值之前进行的
#### 参数:
1. @param string callable $convert 转换器,转换器的参数是源数据,返回值是转换后的数据
2. @params mixed ....$args 转换器的参数,如果转换器需要参数,可以在这里传入;当$args参数为空时,转换器的会将源数据作为唯一参数默认传入,如果$args不为空,则会将$args作为参数传入,"$var"会当场占位符被替换成源数据
```php
class ConvertObject extends AutoHydrate
{
    #[Convert("strtotime")]
    #[RequestField('date', 'date')]
    public int $timestamp;

    #[Convert("strtotime")]
    #[Convert("date",'Y-m-d H:i:s','$var')]
    #[RequestField('local_time', 'local_time')]
    public string $date;

}

 $object = new ConvertObject($data,RequestField::class);
```

### todo

    