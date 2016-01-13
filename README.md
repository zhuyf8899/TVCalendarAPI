# TVCalendarAPI
TVCalender api with CodeIgniter
这个项目是来自于<a href="https://github.com/Everyb0dyLies"高铭同学</a的设想，即通过一个小爬虫从<a href="http://www.pogdesign.co.uk/cat/"pogdesign官网</a抓取英美剧的日历信息，之后将它储存在数据库中（这一部分的工程我们称之为 <a href="https://github.com/zhuyf8899/TVCalenderScript"TVCalenderScript</a ,也在GitHub上发表）。之后再一共一个api提供给iOS和Android客户端。

这个项目是api部分。
## 1. 使用方法
### 1.1 准备材料
+ 一台服务器，能够提供HTTP服务和MySQL服务，支持PHP
+ 一个根据<a href="https://github.com/zhuyf8899/TVCalenderScript"TVCalenderScript</a配置好的数据库
+ 在/application/config/database.php下配置好服务器的账号密码，具体方法参见CodeIgniter教程
### 1.2 起步前
本api仅提供json格式的数据

## 2.使用方法
### 2.1按照日期查找美剧
#### 2.1.1 查找某一天的剧集
    localhost/TVCalendarAPI/index.php/SearchByDate/selectOneDate/yyyy-mm-dd
其中，yyyy-mm-dd为查询的日期，格式需要严格遵守，localhost为域名，返回的格式为(给出了部分样例数据)：
	[
	    {
	        "n_id":"611",
	        "e_id":"611",
	        "n_name":"Shetland",
	        "e_name":"",
	        "season":"3",
	        "episode":"3",
	        "on_air":"2016-01-03",
	        "photo_link":"http://www.pogdesign.co.uk/cat/imgs/sibig/Shetland.jpg",
	        "e_description":""
	    },
	    {
	        "n_id":"612",
	        "e_id":"612",
	        "n_name":"QI",
	        "e_name":"",
	        "season":"13",
	        "episode":"13",
	        "on_air":"2016-01-03",
	        "photo_link":"http://www.pogdesign.co.uk/cat/imgs/sibig/QI.jpg",
	        "e_description":""
	    },...
   ]
#### 2.1.2 查找一个时间范围内的剧集
	localhost/TVCalendarAPI/index.php/SearchByDate/selectDates/yyyy-mm-dd/yyyy-mm-dd
其中两个日期缺一不可，分别为起始日期和结束日期，返回的格式为(给出了部分样例数据)：
	{
	    "2016-01-03":[
	        {
	            "n_id":"611",
	            "e_id":"611",
	            "n_name":"Shetland",
	            "e_name":"",
	            "season":"3",
	            "episode":"3",
	            "on_air":"2016-01-03",
	            "photo_link":"http://www.pogdesign.co.uk/cat/imgs/sibig/Shetland.jpg",
	            "e_description":""
	        },
	        {
	            "n_id":"612",
	            "e_id":"612",
	            "n_name":"QI",
	            "e_name":"",
	            "season":"13",
	            "episode":"13",
	            "on_air":"2016-01-03",
	            "photo_link":"http://www.pogdesign.co.uk/cat/imgs/sibig/QI.jpg",
	            "e_description":""
	        },...
	    ],
	    "2016-01-04":[
	        {
	            "n_id":"622",
	            "e_id":"622",
	            "n_name":"The-X-Files",
	            "e_name":"",
	            "season":"10",
	            "episode":"2",
	            "on_air":"2016-01-04",
	            "photo_link":"http://www.pogdesign.co.uk/cat/imgs/sibig/The-X-Files.jpg",
	            "e_description":""
	        },....
	    ],...
	}
### 2.2 按照ID查找
#### 2.2.1 按照剧的ID查找
	localhost/TVCalendarAPI/index.php/SearchById/SearchById/id
其中最后的id是整数，与上面的n_id一致，返回的格式为(给出了部分样例数据)：
	{
	    "n_id":"643",
	    "n_name":"Second-Chance",
	    "photo_link":"http://www.pogdesign.co.uk/cat/imgs/sibig/Second-Chance.jpg"
	}
#### 2.2.2按照集的ID查找
	localhost/TVCalendarAPI/index.php/SearchById/searchByEpiId/id
其中，id为剧集的id与上方e_id一致，返回的格式为(给出了部分样例数据)：
	{
	    "n_id":"953",
	    "e_id":"999",
	    "n_name":"Mr-Selfridge",
	    "e_name":"",
	    "season":"4",
	    "episode":"2",
	    "on_air":"2016-01-28",
	    "photo_link":"http://www.pogdesign.co.uk/cat/imgs/sibig/Mr-Selfridge.jpg",
	    "e_description":""
	}
### 2.3 错误反馈
错误会被按照以下格式反馈:
	{
   	 "error":"ERROR MESSAGE"
	}
错误（ERROR MESSAGE）目前分为以下几种：
+ Date parameter loss : 缺少参数
+ Date Format Error : 参数格式不正确
+ Result Empty : 查询结果返回为空

## 3.展望
下一步我们打算完善每一季的信息，完善每部剧的相关介绍信息，而不再是单纯的去扒网页然后给出。
## 4.相关技术
本项目使用了CodeIgniter 3.0.3.
本项目使用了pogdesign的数据信息
## 5.作者
+ zhuyifan
+ GaoMing