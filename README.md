# TVCalendarAPI
TVCalender api with CodeIgniter
此项目通过一个小爬虫从网络上获取英美剧的日历信息，之后将它储存在数据库中（这一部分的工程我们称之为 <a href="https://github.com/zhuyf8899/TvCalendarShellNew">TVCalenderScript</a> ，之后提供一个用于浏览器的UI界面和一个用于移动终端的api。

## 1. 部署要求
### 1.1 准备材料
+ 一台服务器，能够提供HTTP服务和MySQL/MariaDB服务，支持PHP
+ 一个根据TVCalenderScript配置好的数据库
+ 在/application/config/database.php下配置好服务器的账号密码，具体方法参见CodeIgniter教程
### 1.2 起步前
api仅提供json格式的数据
ui界面需要完全支持HTML5的现代浏览器才能访问
项目已针对Edge浏览器优化
## 2.使用方法
API文档请向我们<a href="mailto:zhuyf8899@gmail.com">发送邮件</a>获取。
## 3.展望
欢迎与我们进行交流，本项目由于各种主观和客观原因尚无商业化打算，我们欢迎任何个人或者机构与我们联系商讨合作，如果对于版权或者系统bug等问题也欢迎<a href="mailto:zhuyf8899@gmail.com">发送邮件</a>告知我们
## 4.引用
+本项目使用了EllisLab的<a href="http://codeigniter.org/">CodeIgniter</a>代码，该代码使用MIT协议发布，<a href="https://github.com/bcit-ci/CodeIgniter/blob/develop/license.txt">阅读其协议</a>.
+本项目使用了mdo和fat开发的<a href="http://getbootstrap.com/">Bootstrap</a>框架作为前端样式基础,该代码使用MIT协议发布,<a href="https://github.com/bcit-ci/CodeIgniter/blob/develop/license.txt">阅读其协议</a>.
+本项目使用了由John Papa,Tim Ferrell和Hans Fjällemark开发的<a href="http://getbootstrap.com/">toastr</a>的代码作为前端弹框通知插件,该代码使用MIT协议发布,<a href="https://opensource.org/licenses/mit-license.php">阅读其协议</a>.

+本项目的剧集信息使用了<a href="http://www.pogdesign.co.uk/cat/">TVCalendar</a>提供的数据，具体播放信息以各媒体实际播放为准，部分剧集可能包含色情、暴力、意识形态等信息，请用户下载之前明确自己的年龄等条件符合当地法律法规的限制，本项目不对第三方获取的数据承担法律责任.
+本项目的下载链接引用的是<a href="https://btio.pw/">BTSOW</a>的磁力链接搜索页面，搜索的结果可能包含色情、暴力、违法信息，请用户下载之前明确自己的年龄等条件符合当地法律法规的限制，本项目不对第三方获取的数据承担法律责任.
+本项目的剧名翻译使用<a href="http://www.youdao.com/">有道翻译</a>，翻译结果可能与正确翻译存在出入,请用户以官方提供的标准翻译为准，本项目不对第三方获取的数据承担法律责任.

## 5.作者
+ <a href="https://github.com/zhuyf8899">zhuyifan</a>
+ <a href="https://github.com/Everyb0dyLies">GaoMing</a>
