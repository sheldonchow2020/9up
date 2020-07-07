# 9up 胡话生成器

### 使用方法:

```
require ('vendor/autoload.php');

use NineUp\App;

$app = new App();
$app->setTopic('做个好人');
echo $app->write(50);
```