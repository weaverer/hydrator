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


### todo
1. 检验注解            if ($value === 'foo') {
    