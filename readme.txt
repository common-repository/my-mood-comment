=== My Mood Comment===
Tags: mood,comment
Stable tag:1.2

== Description ==
This plugin can help readers express their attitude to your archives quickly.And everyone can easily know others' attitude.Now it's not compatible with "wp super cache".
这个插件提供心情评论，能够让读者看完文章后快速发表心情评论，所有人都能看到各种评论的次数,目前与wp super cache不兼容.

== Installation ==

1. Upload the `my-mood-comment` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Place `<?php mood_comment(); ?>` in your template where you want to show the mood comment.

1. 下载My Mood Comment插件,上传my mood comment目录及其文件到 `/wp-content/plugins/`
2. 在后台管理中激活插件 
3. 在模板中需要的地方添加`<?php mood_comment(); ?>` 

== Screenshots ==

1. Before mood comment
2. After mood comment

== Changelog ==

= 1.2 =
*2011/06/23
*更改了图片的次序，修复了默认固定链接下cookie保存的问题，完善了图片加载过程

= 1.1 =
* 2011/06/16
*修复了cookie的提取问题，目前与wp super cache不兼容.

= 1.0 =
* 2011/06/15
*从mood comment修改而来的第一个版本，添加了cookie保存心情评论，并且永远都能看到各种态度的投票数.